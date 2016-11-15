@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="messageBox">
                @if(!empty($user))
                    <div class="messageBoxHeading">Fel kontotyp</div>
                @else
                    <div class="messageBoxHeading">Registrera ny användare</div>
                @endif
                <div class="panel-body">
                    @include('errors.wrongusertype')
                    @include('errors.validation')

                    @if(empty($user))

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Namn</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Lösenord</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Repetera lösenord</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('cv') ? ' has-error' : '' }}">
                                {!! Form::label('cv', 'CV (.doc, .docx, .pdf, .rtf, .txt, max 3MB)', ['class' => 'control-label col-md-4']) !!}

                                <div class="col-md-6">
                                    {!! Form::file('cv', array('class'=>'form-control bordered')) !!}
                                </div>
                                @if ($errors->has('cv'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cv') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <hr>

                            <h4 >Jag är intresserad av jobb inom..</h4>

                            <div class="form-group{{ $errors->has('county') ? ' has-error' : '' }}">
                                {!! Form::label('county', 'Län', ['class' => 'control-label col-md-4']) !!}
                                <div class="col-md-6">
                                    <select name="lan" class="form-control bordered" id="county" style="display: block;">
                                        <option selected disabled>------</option>
                                        <option value="155" label="Norge" name="Norge">Norge</option>
                                        <option value="10" label="Blekinge län" name="Blekinge län">Blekinge län</option>
                                        <option value="20" label="Dalarnas län" name="Dalarnas län">Dalarnas län</option>
                                        <option value="9" label="Gotlands län" name="Gotlands län">Gotlands län</option>
                                        <option value="21" label="Gävleborgs län" name="Gävleborgs län">Gävleborgs län</option>
                                        <option value="13" label="Hallands län" name="Hallands län">Hallands län</option>
                                        <option value="23" label="Jämtlands län" name="Jämtlands län">Jämtlands län</option>
                                        <option value="6" label="Jönköpings län" name="Jönköpings län">Jönköpings län</option>
                                        <option value="8" label="Kalmar län" name="Kalmar län">Kalmar län</option>
                                        <option value="7" label="Kronobergs län" name="Kronobergs län">Kronobergs län</option>
                                        <option value="25" label="Norrbottens län" name="Norrbottens län">Norrbottens län</option>
                                        <option value="12" label="Skåne län" name="Skåne län">Skåne län</option>
                                        <option value="1" label="Stockholms län" name="Stockholms län">Stockholms län</option>
                                        <option value="4" label="Södermanlands län" name="Södermanlands län">Södermanlands län</option>
                                        <option value="3" label="Uppsala län" name="Uppsala län">Uppsala län</option>
                                        <option value="17" label="Värmlands län" name="Värmlands län">Värmlands län</option>
                                        <option value="24" label="Västerbottens län" name="Västerbottens län">Västerbottens län</option>
                                        <option value="22" label="Västernorrlands län" name="Västernorrlands län">Västernorrlands län</option>
                                        <option value="19" label="Västmanlands län" name="Västmanlands län">Västmanlands län</option>
                                        <option value="14" label="Västra Götalands län" name="Västra Götalands län">Västra Götalands län</option>
                                        <option value="18" label="Örebro län" name="Örebro län">Örebro län</option>
                                        <option value="5" label="Östergötlands län" name="Östergötlands län">Östergötlands län</option>
                                        <option value="90" label="Ospecificerad arbetsort" name="Ospecificerad arbetsort">Ospecificerad arbetsort</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }} m-b-2">
                                {!! Form::label('category', 'Yrkesgrupp', ['class' => 'control-label col-md-4']) !!}

                                <div class="col-md-8">
                                    <label class="sr-only" for="job-group">Yrkesgrupp</label>


                                    {{--Om vi vill hämta kategorierna direkt från AF--}}

                                    @if (isset($searchOptions[1]))
                                            <label class="sr-only" for="job-group">Yrkesgrupp</label>

                                            @foreach($searchOptions[1]->soklista->sokdata as $option)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="category[]" value="{{ $option->id }}" class="input--large">
                                                        &nbsp;{{ $option->namn }}
                                                    </label>
                                                </div>
                                            @endforeach
                                    @endif

                                    @if ($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="registerFormSubmitButton col-md-12">
                                            Registrera
                                        </button>
                                    </div>
                                </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
