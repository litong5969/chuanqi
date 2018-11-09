<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreInstalmentRequest;
use App\Instalment;
use App\Repositories\InstalmentRepository;
use App\Repositories\WorldLineRepository;
use function array_push;
use function array_reverse;
use function back;
use function compact;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function redirect;
use function time;


/**
 * Class instalmentsController
 * @package App\Http\Controllers
 */
class instalmentsController extends Controller {
    /**
     * @var InstalmentRepository
     */
    protected $instalment;
    /**
     * @var
     */
    protected $worldLineRepository;
    /**
     * instalmentsController constructor.
     * @param $instalment
     */
    public function __construct(InstalmentRepository $instalment,WorldLineRepository $worldLineRepository)
    {
        $this->instalment = $instalment;
        $this->worldLine = $worldLineRepository;
    }

    /**
     * @param StoreInstalmentRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $instalments = $this->instalment->getInstalmentsFeed();
        return view('instalments.index', compact('instalments'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function worldLineIndex()
    {
        $instalments = $this->instalment->getAllLastInstalments();
        return view('instalments.worldLine', compact('instalments'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
//        dd($this->worldLine->worldLinesByArticleId($id));
        $instalment = $this->instalment->byId($id);
        $worldLine=$this->worldLine->worldLineById($id);
        $worldLineValue = $this->worldLine->worldLineValueById($id);
        $worldLineCounts=$this->worldLine->worldLineCounts($instalment->article_id);
        $biggestLeg=$this->instalment->biggestLeg($instalment->article_id);
        return view('instalments.show', compact(
            'instalment', 'worldLine', 'worldLineValue','worldLineCounts','biggestLeg'
        ));
    }

}
