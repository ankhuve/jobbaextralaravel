@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 newJobContainer">
                <div class="messageBoxHeading">Dina jobbannonser
                    @if(count(($user->jobs)) != 0)
                        ( {{ count($user->jobs) }} )
                    @endif
                    <div class="loggedInUser"><span class="orange">(</span> {{ $user->email }} <span class="orange">)</span></div>
                </div>
                <div class="panel-body">
                    @if($user->jobs)
                        @foreach($user->jobs as $job)
                            @include('company.jobbpuff')
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Du har tyvärr inga jobbannonser.</h3>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-4 col-md-offset-4">
                        <a href="{{ url('company/create') }}">
                            <button class="registerFormSubmitButton col-md-12">
                                Skapa en annons
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
