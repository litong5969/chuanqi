<?php

namespace App\Http\Controllers;

use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    protected $tag;

    /**
     * TagsController constructor.
     * @param $tag
     */
    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    public function index(Request $request)
    {
        return $this->tag->getTagsForTagging($request);
    }
}
