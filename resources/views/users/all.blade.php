@extends('layouts.default')
@section('title','全部用户')
@section('content')
    {{--{{$user->name}}-{{$user->email}}--}}
    @foreach($user->all() as $u)
        <li>{{ $u->name }} : {{ $u->email }}</li>
    @endforeach
@stop