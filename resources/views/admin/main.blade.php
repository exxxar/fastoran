@extends('layouts.admin')

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @isset($token)
                            <p>{{$token}}</p>
                        @endisset
                        <hr>
                        @isset($auth)
                            <a class="btn btn-primary" href="{{$auth->getUrl()}}">Обновить товар через ВК</a>
                        @endisset
                        {{-- <div class="row">
                             <div class="col" id="app">
                                 <passport-clients></passport-clients>
                                 <passport-authorized-clients></passport-authorized-clients>
                                 <passport-personal-access-tokens></passport-personal-access-tokens>
                             </div>
                         </div>--}}

                        {{-- You are logged in!--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
