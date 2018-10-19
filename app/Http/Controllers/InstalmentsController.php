<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreInstalmentRequest;
use App\Instalment;
use App\Repositories\InstalmentRepository;
use function back;
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

    public function store(StoreInstalmentRequest $request, $article)
    {
        $instalment = $this->instalment->create([
            'article_id' => $article,
            'user_id' => Auth::id(),
            'body' => $request->get('body'),
        ]);
        $instalment->article()->increment('instalments_count');
        return back();
    }

}
