<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="xxxx"/>

    <title>@yield('title','Weibo App')</title>
    {{--<link rel="stylesheet" href="/css/app.css">--}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
@include('layouts._header')
<div class="container">
    <div class="offset-md-1 col-md-10">
        @include('common._messages')
        @yield('content')
        @include('layouts._footer')
    </div>
</div>
<div id="app">

</div>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>