<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreInstalmentRequest;
use App\Instalment;
use App\Repositories\InstalmentRepository;
use function array_merge;
use function array_reverse;
use function back;
use function compact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $instalment = $this->instalment->create([
            'article_id' => $request->get('article_id'),
            'user_id' => Auth::id(),
            'body' => $request->get('body'),
        ]);
        $instalment->article()->increment('instalments_count');
return back();
    }

    public function index()
    {
        $instalments = $this->instalment->getInstalmentsFeed();
        return view('instalments.index',compact('instalments'));
    }

    public function show($id)
    {

        $instalment = $this->instalment->byId($id);//把搜索到的tag内容附加到结果里
        $instal=$instalment;
        $instalments=[$instal];

//        $collapsed=$instalments->collapse();
        while($instal->prev_instalment!==null){
            $instal= $this->instalment->byId($instal->prev_instalment);
            array_push($instalments, $instal);
//            $instalments=collect([$instalments,$instal]);
        }
        $instalments=array_reverse($instalments);
//return $instalments;
        return view('instalments.show', compact('instalment','instalments'));
    }
}
