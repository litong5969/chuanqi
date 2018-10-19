@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">设置个人信息</div>
                    <div class="card-body">
                        <div class="card-body">
                            <user-avatar avatar="{{Auth::user()->avatar}}"></user-avatar>
                        </div>
                        <form method="POST" action="/setting" aria-label="{{ __('设置') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="bio"
                                       class="col-md-4 col-form-label text-md-right">{{ __('个人简介') }}</label>
                                <div class="col-md-6">
                                    <textarea id="bio" rows="5" maxlength="140"
                                           class="form-control{{ $errors->has('bio') ? ' is-invalid' : '' }}"
                                           name="bio" required>{{user()->settings['bio']}}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="weibo"
                                       class="col-md-4 col-form-label text-md-right">{{ __('微博') }}</label>
                                <div class="col-md-6">
                                    <input id="weibo" type="text" maxlength="30"
                                           class="form-control{{ $errors->has('weibo') ? ' is-invalid' : '' }}"
                                           name="weibo" value="{{user()->settings['weibo']}}">
                                    @if ($errors->has('weibo'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('weibo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="weibo_url"
                                       class="col-md-4 col-form-label text-md-right">{{ __('微博地址') }}</label>
                                <div class="col-md-6">
                                    <input id="weibo_url" type="text" maxlength="60"
                                           class="form-control{{ $errors->has('weibo_url') ? ' is-invalid' : '' }}"
                                           name="weibo_url" value="{{user()->settings['weibo_url']}}">
                                    @if ($errors->has('weibo_url'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('weibo_url') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('修改资料') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
