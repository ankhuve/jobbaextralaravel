@extends('app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="messageBox">
                <div class="messageBoxHeading">Registrera företag</div>
                <div class="panel-body">
                    <div class="h4">
                        Du måste ha ett företagskonto för att skapa jobbannonser.
                        <br><br>
                        <a class="btn-link" href="{{ action('ContactController@create') }}">Kontakta oss</a> så löser vi det!
                        <br/><br/>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
