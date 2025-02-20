@extends('layouts.default')

@section('content')
    @if (Auth::check())
        <div class="row">
            <div class="col-md-8">
                <section class="status_form">
                    @include('shared._status_form')
                </section>
                <h4>Blog's list</h4>
                <hr>
                @include('shared._feed')
            </div>
            <aside class="col-md-4">
                <section class="user_info">
                    @include('shared._user_info', ['user' => Auth::user()])
                </section>
                <section class="stats mt-2">
                    @include('shared._stats', ['user' => Auth::user()])
                </section>
            </aside>
        </div>
    @else
        <div class="bg-light p-3 p-sm-5 rounded">
            <h1>hana</h1>
            <p class="lead">
                Hi, I'm hana, a web developer from Pandaria.
            </p>
            <p>
                This is the first web application I built using Laravel. I hope you like it.
            </p>
            <p>
                <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Signup now</a>
            </p>
        </div>
    @endif
@stop
