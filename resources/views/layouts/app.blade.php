<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        Laravel.apiToken = "{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}";
        @if(Auth::check())
            window.chuanqi = {
            name: "{{Auth::user()->name}}",
            avatar: "{{Auth::user()->avatar}}",
        }
        @endif
    </script>
{{--    <meta name="api_token" content="{{Auth::check()?'Bearer '.Auth::user()->api_token:'Bearer '}}">--}}
<!-- Scripts -->

    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/cards-style.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    {{--<script src="{{asset('js/siema.min.js')}}"></script>--}}
    <script src="{{asset('js/hullabaloo.js')}}"></script>
    <script type="text/javascript" src="js/hullabaloo.js"></script>
    {{--<script type="text/javascript">--}}
        {{--$.hulla = new hullabaloo();--}}

        {{--setTimeout(function() {--}}
            {{--$.hulla.send("Hi！这里是HTML5资源教程网！", "success");--}}
        {{--}, 1000);--}}

        {{--setTimeout(function() {--}}
            {{--$.hulla.send("欢迎您的访问！", "info");--}}
        {{--}, 2000);--}}

        {{--setTimeout(function() {--}}
            {{--$.hulla.send("想知道如何使用HTML5实现炫酷的应用吗？", "warning");--}}
        {{--}, 3000);--}}
    {{--</script>--}}
    <!-- Fonts -->
{{--<link rel="dns-prefetch" href="https://fonts.gstatic.com">--}}
{{--<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">--}}
<!-- Styles -->

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color: #ceecf0;">
        <div class="container">
            <a class="navbar-brand" style="color:#ffffff" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- 搜索框-->
            <form class="form-inline my-2 my-lg-0" action="{{ url('/search') }}">
                <input class="form-control mr-sm-2" name="titlesearch" type="search" placeholder="搜索"
                       aria-label="Search">
                <button class="btn btn-light my-2 my-sm-0" type="submit">搜索</button>
            </form>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" style="color:#ffffff" href="{{ route('login') }}">{{ __('登录') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color:#ffffff" href="{{ route('register') }}">{{ __('注册') }}</a>
                        </li>
                    @else

                        <li class="nav-item dropdown" style="margin-top: 7px">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#ffffff"
                               v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="/setting">
                                        <i class="fa fa-id-card-o"></i> {{ __('修改资料') }}
                                    </a></li>
                                <li><a class="dropdown-item" href="/notifications">
                                        <i class="fa fa-bell"></i> {{ __('消息通知') }}
                                    </a></li>
                                <li><a class="dropdown-item" href="/inbox">
                                        <i class="fa fa-envelope-open"></i> {{ __('收件箱') }}
                                    </a></li>
                                <hr>
                                <li><a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> {{ __('退出') }}
                                    </a></li>

                                <li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li><img width="50" src=" {{ Auth::user()->avatar }}" alt="" class="rounded-circle">
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-0  section-gray">
        <div class="container">
            @include('flash::message')
        </div>
        @yield('content')
    </main>
    <footer>
        <hr>
        <div class="footer-bottom">
            <div class="row justify-content-center">
                <a class="float-right" style="color: #2a2a2a"
                   href="http://www.miitbeian.gov.cn/">京ICP备18055726号</a>
            </div>
        </div>
    </footer>
</div>
@yield('js')
</body>
</html>
