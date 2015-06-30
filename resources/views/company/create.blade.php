@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 newJobContainer">
                <div class="messageBoxHeading">Skapa jobbannons</div>
                <div class="panel-body">
                    @include('errors.validation')

                    {!! Form::open(['method' => 'GET', 'action' => 'CompanyController@confirm', 'class'=>'form-horizontal']) !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-2 control-label">Jobbtitel</label>
                            <div class="col-md-9">
                                {!! Form::input('text', 'title', null, ['class' => 'form-control input-lg', 'placeholder' => 'Kökspersonal på restaurang, telefonförsäljare..']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Yrkesområde</label>
                            <div class="col-md-3">
                                {!! Form::select('type', ['Bagare' => 'Bagare'], '', ['class' => 'form-control']) !!}
                            </div>

                            <label class="col-md-2 control-label">Arbetsplats</label>
                            <div class="col-md-4">
                                {!! Form::input('text', 'work_place', null, ['class' => 'form-control', 'placeholder' => 'Kafé Bullen, Telefontek AB..']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Län</label>
                            <div class="col-md-3">
                                {!! Form::select('county', ['Stockholms län' => 'Stockholms län'], null, ['class' => 'form-control']) !!}
                            </div>

                            <label class="col-md-2 control-label">Ort</label>
                            <div class="col-md-4">
                                {!! Form::input('text', 'municipality', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">

                            <div class="col-md-9 col-md-offset-2">
                                <label for="description">Beskrivning</label>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'placeholder' => 'Beskriv jobbets uppgifter, förkunskaper, krav osv.']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">Sista ansökningsdag</label>
                            <div class="col-md-3">
                                {!! Form::date('latest_application_date', Carbon\Carbon::today()->addMonth(1), ['class' => 'form-control']) !!}
                            </div>

                            <label class="col-md-2 control-label">Kontaktperson (e-mailadress)</label>
                            <div class="col-md-4">
                                {!! Form::email('contact_email', $user->email, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                {!! Form::submit('Skapa', ['class' => 'registerFormSubmitButton col-md-12']) !!}
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
