<?php


namespace App\Repositories;


use App\Instalment;

class InstalmentRepository {

    public function create(array $attributes)
    {
        return Instalment::create($attributes);
    }

    public function byId($id)
    {
        return Instalment::find($id);
    }

    public function maxVotesAllByArticleAndLeg($article, $leg)
    {
        return Instalment::where('article_id', $article)->where('leg', $leg)->orderBy('votes_count_all', 'desc')->first();
    }

//    public function allLastInstalments($article)
//    {
//        return Instalment::where('article_id', $article)->where('is_the_last', 'T')->get();
//    }

    public function getInstalmentsFeed()
    {
        return Instalment::published()->latest('created_at')->with('user')->get();
    }

    public function getInstalmentCommentsById($id)
    {
        $instalment = Instalment::with('comments', 'comments.user')->where('id', $id)->first();
        return $instalment->comments;
    }
//    public function prev()
//    {
//    return $this->byId(Instalment::class->prev_instalment);
//    }
}