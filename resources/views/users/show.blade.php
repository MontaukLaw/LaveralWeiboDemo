{{-- 显示用户的view --}}
@extends('layouts.default')
@section('title',$user->name)
@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
            {{-- 用户信息 --}}
            <section class="user_info">
                @include('common._user_info', ['user' => $user])
            </section>

            {{-- 关注表单 --}}
            @if (Auth::check())
                @include('users._follow_form')
            @endif

            {{-- 显示粉丝, 关注人信息 --}}
            <section class="stats mt-2">
                @include('common._stats', ['user' => $user])
            </section>
            <hr>
            <section class="status">
                @if ($statuses->count() > 0)
                    <ul class="list-unstyled">
                        @foreach ($statuses as $status)
                            @include('statuses._status')
                        @endforeach
                    </ul>
                    <div class="mt-5">
                        {!! $statuses->render() !!}
                    </div>
                @else
                    <p>没有数据！</p>
                @endif
            </section>
        </div>
    </div>
@stop