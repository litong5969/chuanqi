<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreInstalmentRequest;
use App\Instalment;
use App\Repositories\InstalmentRepository;
use function array_push;
use function array_reverse;
use function back;
use function compact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function redirect;


class instalmentsController extends Controller {
    protected $instalment;

    /**
     * instalmentsController constructor.
     * @param $instalment
     */
    public function __construct(InstalmentRepository $instalment)
    {
        $this->instalment = $instalment;
    }

    public function store(StoreInstalmentRequest $request)
    {
        if ($request->get('leg') != null) {
            $leg = $request->get('leg') + 1;
        } else {
            $leg = 1;
        }
        $instalment = $this->instalment->create([
            'article_id' => $request->get('article_id'),
            'user_id' => Auth::id(),
            'body' => $request->get('body'),
            'leg' => $leg,
            'prev_instalment'=>$request->get('prev_id'),
        ]);
        //连接
        DB::table('instalment_instalment')->insert([
            'prev_id' => $request->get('prev_id'),
            'next_id' => $instalment->id,
        ]);
        $instalment->article()->increment('instalments_count');
        return redirect('instalments/'.$instalment->id);
    }

    public function index()
    {
        $instalments = $this->instalment->getInstalmentsFeed();
        return view('instalments.index', compact('instalments'));
    }

    public function show($id)
    {
        //        $allLastInstalments = $this->instalment->allLastInstalments($instalment->article_id);
//        foreach($allLastInstalments as $lastInstalment){
//            while ($lastInstalment->prev_instalment !== null) {
//                if()
//                $instal = $this->instalment->byId($instal->prev_instalment);
//                array_push($instalments, $instal);
//            }
//        }


        $instalment = $this->instalment->byId($id);//把搜索到的tag内容附加到结果里
        $instal = $instalment;
        $instalments = [$instal];
//        $instalment= collect($instalment)->concat(['world_line'=>$this->worldLine($instalment->id)]);
        $worldLine = $this->worldLine($instalment->id);
        while ($instal->prev_instalment !== null) {
            $instal = $this->instalment->byId($instal->prev_instalment);
            array_push($instalments, $instal);
        }
        $instalments = array_reverse($instalments);
//return $instalments;
        return view('instalments.show', compact('instalment', 'instalments', 'worldLine'));
    }

    public function worldLine($id)

    {
        $instalment = $this->instalment->byId($id);
        $worldLineVotes = $instalment->votes_count_all;
        $worldLineMaxInstal = $this->instalment->maxVotesAllByArticleAndLeg($instalment->article_id, $instalment->leg);
        if ($worldLineVotes === $worldLineMaxInstal->votes_count_all) {
            return sprintf("%.6f", 1);
        } else {
            if ($instalment->created_at < $worldLineMaxInstal->created_at) {
                return sprintf("%.6f", 1 - ($worldLineVotes / $worldLineMaxInstal->votes_count_all) * 2);
            } else {
                return sprintf("%.6f", 1 + ($worldLineVotes / $worldLineMaxInstal->votes_count_all) * 2);
            }
        }

    }
}
