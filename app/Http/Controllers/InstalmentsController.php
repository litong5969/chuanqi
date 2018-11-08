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
use function time;


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
        ]);
        //连接
        $this->instalment->instalment2($request->get('prev_id'),$instalment->id);
        $instalment->article()->increment('instalments_count');
        $this->instalment->notALast($request->get('prev_id'));
        return redirect('instalments/'.$instalment->id);
    }

    public function index()
    {
//        $str=strip_tags(
//            '<p><span style="color: rgba(0, 0, 0, 0.87); font-family: Raleway, sans-serif; font-size: 14.4px; background-color: rgb(255, 255, 255);">第二棒第<span style="color: rgba(0, 0, 0, 0.87); font-family: Raleway, sans-serif; font-size: 14.4px; background-color: rgb(255, 255, 255);">二</span>棒第<span style="color: rgba(0, 0, 0, 0.87); font-family: Raleway, sans-serif; font-size: 14.4px; background-color: rgb(255, 255, 255);">二</span><span style="color: rgba(0, 0, 0, 0.87); font-family: Raleway, sans-serif; font-size: 14.4px; background-color: rgb(255, 255, 255);"></span>棒</span></p>'
//        );
//        dd(str_limit($str, 120, '... ... '));
        $instalments = $this->instalment->getInstalmentsFeed();
        return view('instalments.index', compact('instalments'));
    }

    public function show($id)
    {
        $instalment = $this->instalment->byId($id);//把搜索到的tag内容附加到结果里
        $instal = $instalment;
        $instalments = [$instal];
        $worldLineVotes=$instalment->votes_count;
        while ($this->instalment->getPrevId($instal->id) !== null) {
            $instal = $this->instalment->byId($this->instalment->getPrevId($instal->id));
            $worldLineVotes=$worldLineVotes+$instal->votes_count;
            array_push($instalments, $instal);
        }
        $worldlineValue = $this->instalment->worldlineValueById($instalment->id);
        $instalments = array_reverse($instalments);
        $worldlineCounts=$this->instalment->worldlineCounts($instalment->article_id);
        return view('instalments.show', compact('instalment', 'instalments', 'worldlineValue','worldlineCounts'));
    }

}
