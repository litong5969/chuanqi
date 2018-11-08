<?php

namespace App\Http\Controllers;

use App\Repositories\InstalmentRepository;
use Auth;
use Illuminate\Http\Request;

class VotesController extends Controller {

    protected $instalment;

    /**
     * VotesController constructor.
     * @param $instalment
     */
    public function __construct(InstalmentRepository $instalment)
    {
        $this->instalment = $instalment;
    }

    public function users($id)
    {

        if (user('api')->hasVotedFor($id)) {
            return response()->json(['voted' => true]);
        }
        return response()->json(['voted' => false]);
    }

    public function vote()
    {
        $instalment = $this->instalment->byId(request('instalment'));
        $voted=user('api')->voteFor(request('instalment'));

        if (count($voted['attached']) > 0) {
            $instalment->increment('votes_count');
            $instalment->article()->increment('votes_count');
            return response()->json(['voted' => true]);
        }
        $instalment->decrement('votes_count');
        $instalment->article()->decrement('votes_count');
        return response()->json(['voted' => false]);
    }
}
