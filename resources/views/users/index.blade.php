@extends('layouts.default')

@section('title', '用户列表')

@section('content')
    <h1>用户列表</h1>
    <ul>
        @foreach ($users as $user)
            <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
@endsection
