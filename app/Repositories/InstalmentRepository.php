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

    public function getInstalmentCommentsById($id)
    {
        $instalment = Instalment::with('comments', 'comments.user')->where('id', $id)->first();
        return $instalment->comments;
    }
}