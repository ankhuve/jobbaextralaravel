@extends('app')

@section('content')

    <div class="container">

        <div class="panel panel-custom col-lg-10 col-lg-offset-1">
            <div class="panel-heading">
                <h2>
                    Kontakta oss
                </h2>
            </div>

            <div class="panel-body">
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{Session::get('message')}}
                    </div>
                @endif
                <div class="well well-custom">
                    <p>
                        Företag och arbetsplatser är byggt och består av människor.
                        <br><br>
                        Med den insikten förstår vi att samma lösning inte passar alla.
                        Kontakta oss via formuläret nedan så återkommer vi till er snarast för en dialog kring hur vi tillsammans kan skräddasy en lösning för att få ett resultat som passar just er.
                    </p>
                </div>

                {!! Form::open(['method' => 'POST', 'action' => 'ContactController@store', 'class' => 'form']) !!}

                <div class="form-group">
                    {!! Form::label('Namn') !!}
                    {!! Form::text('name', Auth::user() ? Auth::user()->name : '', array('required', 'class'=>'form-control', 'placeholder'=>'Förnamn Efternamn')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('E-mailadress') !!}
                    {!! Form::text('email', Auth::user() ? Auth::user()->email : '', array('required', 'class'=>'form-control', 'placeholder'=>'din@email.se')) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('Meddelande') !!}
                    {!! Form::textarea('message', null, array('required', 'class'=>'form-control', 'placeholder'=>'Vad funderar du på?')) !!}
                </div>

                @if(!empty($errors->all()))
                    <div class="alert alert-custom">
                        <ul>

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    {!! Form::submit('Skicka!', array('class'=>'btn btn-primary')) !!}
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>



@endsection