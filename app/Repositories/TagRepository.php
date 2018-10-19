<?php


namespace App\Repositories;

use Illuminate\Http\Request;
use App\Tag;

class TagRepository {
public function getTagsForTagging(Request $request)
{
    return Tag::select(['id', 'name'])
        ->where('name', 'like', '%' . $request->query('q') . '%')
        ->get();
}
}