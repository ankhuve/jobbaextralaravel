@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            {{--@if($user->logo_path)--}}
                {{--<div class="col-md-12">--}}
                    {{--<img class="logo" src="{{ env('UPLOADS_URL') }}/{{ $user->logo_path }}" alt="">--}}
                {{--</div>--}}
            {{--@endif--}}
            <div class="col-md-12 newJobContainer">
                <div class="messageBoxHeading">Dina jobbannonser
                    @if(count(($user->jobs)) != 0)
                        ( {{ count($user->jobs) }} )
                    @endif
                    <div class="loggedInUser"><span class="orange">(</span> {{ $user->email }} <span class="orange">)</span></div>
                </div>
                <div class="panel-body">
                    @if($user->jobs)
                        @foreach($user->jobs as $job)
                            @include('pages.partials.jobbaextrapuff')
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Du har tyvärr inga jobbannonser.</h3>
                            </div>
                        </div>
                    @endif
                    @if($user->role === 3)
                        <div class="col-md-4 col-md-offset-4">
                            <a href="{{ action('CompanyController@show') }}">
                                <button class="registerFormSubmitButton col-md-12">
                                    Skapa en annons
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
