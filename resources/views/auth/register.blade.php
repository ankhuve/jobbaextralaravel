@extends('app')

@section('scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

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
                    {{--@include('errors.wrongusertype')--}}
                    @include('errors.validation')

                    @if(empty($user))

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Namn</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Lösenord</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="col-md-4 control-label">Repetera lösenord</label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
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

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif

                                <div class="col-md-8">
                                    <label class="sr-only" for="job-group">Yrkesgrupp</label>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="1" class="input--large">
                                            &nbsp;Administration, ekonomi, juridik
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="2" class="input--large">
                                            &nbsp;Bygg och anläggning
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="20" class="input--large">
                                            &nbsp;Chefer och verksamhetsledare
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="3" class="input--large">
                                            &nbsp;Data/IT
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="5" class="input--large">
                                            &nbsp;Försäljning, inköp, marknadsföring
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="6" class="input--large">
                                            &nbsp;Hantverksyrken
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="7" class="input--large">
                                            &nbsp;Hotell, restaurang, storhushåll
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="8" class="input--large">
                                            &nbsp;Hälso- och sjukvård
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="9" class="input--large">
                                            &nbsp;Industriell tillverkning
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="10" class="input--large">
                                            &nbsp;Installation, drift, underhåll
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="4" class="input--large">
                                            &nbsp;Kropps- och skönhetsvård
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="11" class="input--large">
                                            &nbsp;Kultur, media, design
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="22" class="input--large">
                                            &nbsp;Militärt arbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="13" class="input--large">
                                            &nbsp;Naturbruk
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="14" class="input--large">
                                            &nbsp;Naturvetenskapligt arbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="15" class="input--large">
                                            &nbsp;Pedagogiskt arbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="12" class="input--large">
                                            &nbsp;Sanering och renhållning
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="16" class="input--large">
                                            &nbsp;Socialt arbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="17" class="input--large">
                                            &nbsp;Säkerhetsarbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="18" class="input--large">
                                            &nbsp;Tekniskt arbete
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="category[]" value="19" class="input--large">
                                            &nbsp;Transport
                                        </label>
                                    </div>



                                    {{--Om vi vill hämta kategorierna direkt från AF--}}

                                    {{--@if (isset($searchOptions[1]))--}}
                                    {{--<label class="sr-only" for="job-group">Yrkesgrupp</label>--}}

                                    {{--@foreach($searchOptions[1]->soklista->sokdata as $option)--}}
                                    {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                    {{--<input type="checkbox" name="category[]" value="{{ $option->id }}" class="input--large">--}}
                                    {{--&nbsp;{{ $option->namn }}--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@endforeach--}}
                                    {{--@endif--}}

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
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
