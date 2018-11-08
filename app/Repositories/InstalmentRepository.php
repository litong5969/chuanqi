<?php


namespace App\Repositories;


use App\Instalment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InstalmentRepository {

    public function create(array $attributes)
    {
        return Instalment::create($attributes);
    }

    public function byId($id)
    {
        return Instalment::find($id);
    }

    public function worldlineValueById($id)
    {
        $instalment = $this->byId($id);
        $lasts = Instalment::where('article_id', $instalment->article_id)->where('is_the_last', 'T')->get();
        $thisWorldLineVotes = $this->worldlineVotes($id);
        $worldLineAll = [];
        foreach ($lasts as $last) {
            $lastId = $last->id;
            $worldLineVotes = $this->worldlineVotes($lastId);
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

    public function worldlineVotes($id)
    {
        $instalment = $this->byId($id);
        $worldLineVotes = $instalment->votes_count;
        while ($this->getPrevId($instalment->id) !== null) {
            $instalment = $this->byId($this->getPrevId($instalment->id));
            $worldLineVotes = $worldLineVotes + $instalment->votes_count;
        }
        return $worldLineVotes;
    }

    public function worldlineCounts($id)
    {
       return $worldlineCounts = Instalment::where('article_id', $id)->where('is_the_last', 'T')->get()->count();
    }

    public function getInstalmentsFeed()
    {
        return Instalment::published()->latest('created_at')->with('user')->get();
    }

    public function getInstalmentCommentsById($id)
    {
        $instalment = Instalment::with('comments', 'comments.user')->where('id', $id)->first();
        return $instalment->comments;
    }

    public function notALast($id)
    {
        $instalment = Instalment::find($id);
        if ($instalment != null) {
            $instalment->is_the_last = 'F';
            $instalment->save();
        }
    }

    public function instalment2($prveId, $id)
    {
        DB::table('instalment_instalment')->insert([
            'prev_id' => $prveId,
            'next_id' => $id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function getPrevId($id)
    {
        $instalment = DB::table('instalment_instalment')->where('next_id', $id)->first();
        return $instalment->prev_id;
    }
}