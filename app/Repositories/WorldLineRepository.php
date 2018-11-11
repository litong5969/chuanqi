<?php


namespace App\Repositories;


use App\Instalment;
use function array_collapse;
use function array_prepend;
use Carbon\Carbon;
use function collect;
use function dd;
use Illuminate\Support\Facades\DB;

class WorldLineRepository extends InstalmentRepository {

    public function worldLineById($id)
    {
        $instalment = $this->byId($id);
        $worldLine = [$instalment];
        while ($this->getPrevId($instalment->id) !== null) {
            $instalment = $this->byId($this->getPrevId($instalment->id));
            array_push($worldLine, $instalment);
        }
        $worldLineValue=$this->worldLineValueById($id);
        $worldLine = array_reverse($worldLine);
        return [$worldLine,$worldLineValue];
    }

    public function worldLinesByArticleId($id)
    {
        $lasts = Instalment::where('article_id', $id)->where('is_the_last', 'T')->get();
        $worldLines=[];
        foreach($lasts as $last){
            array_push($worldLines, $this->worldLineById($last->id));
        }
        return $worldLines;
    }

    public function worldLineVotes($id)
    {
        $instalment = $this->byId($id);
        $worldLineVotes = $instalment->votes_count;
        while ($this->getPrevId($instalment->id) !== null) {
            $instalment = $this->byId($this->getPrevId($instalment->id));
            $worldLineVotes = $worldLineVotes + $instalment->votes_count;
        }
        return $worldLineVotes;
    }

    public function worldLineValueById($id)
    {
        $instalment = $this->byId($id);
        $lasts = Instalment::where('article_id', $instalment->article_id)->where('is_the_last', 'T')->get();
        $thisWorldLineVotes = $this->worldLineVotes($id);
        $worldLineAll = [];
        foreach ($lasts as $last) {
            $lastId = $last->id;
            $worldLineVotes = $this->worldLineVotes($lastId);
            array_push($worldLineAll, ['votes_count' => $worldLineVotes, 'id' => $lastId]);
        }
        $worldLineAll = collect($worldLineAll)->sortBy('votes_count');
        $maxWorldLine = $worldLineAll->last();
        $maxVotesCounts = data_get($maxWorldLine, 'votes_count');
        $maxVotesId = data_get($maxWorldLine, 'id');

        if ($thisWorldLineVotes === $maxVotesCounts) {
            return sprintf("%.6f", 1);
        } else {
            if ($instalment->created_at < $this->byId($maxVotesId)->created_at) {
                return sprintf("%.6f", 1 - ($thisWorldLineVotes / $maxVotesCounts) * 3);
            } else {
                return sprintf("%.6f", 1 + ($thisWorldLineVotes / $maxVotesCounts) * 3);
            }
        }
    }

    public function worldLineCounts($id)
    {
        return $worldLineCounts = Instalment::where('article_id', $id)->where('is_the_last', 'T')->get()->count();
    }

}