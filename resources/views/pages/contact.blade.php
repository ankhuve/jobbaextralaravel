@extends('app')

@section('content')

    <div class="container">

        @foreach($content as $block)
            <div class="panel panel-custom col-lg-10 col-lg-offset-1">
                <div class="panel-heading">
                    <h2>
                        {{ $block->title }}
                    </h2>
                </div>

                <div class="panel-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{Session::get('message')}}
                        </div>
                    @endif
                    <div class="well well-custom">
                        <p style="white-space: pre-line">
                            {{ $block->content }}
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
        @endforeach

    </div>



@endsection