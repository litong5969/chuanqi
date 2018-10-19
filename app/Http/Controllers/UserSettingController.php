<?php

namespace App\Http\Controllers;


use App\Http\Requests\UserSettingRequest;

class UserSettingController extends Controller {
    public function index()
    {
        return view('users.setting');
    }

    public function store(UserSettingRequest $request)
    {
        user()->settings()->merge($request->all());
        return back();
    }
}
