@extends('app')

@section('content')

    <div class="singleJob">
        <center>
            <div class="jobButtons">
                <a href="#"><button class="singleJobButton">Tillbaka till sök</button></a>
                {{--<span ng-show="loggedIn()">--}}
                {{--<button class="singleJobButton save" ng-click="saveJob(jobMatch.annons.annonsid, jobMatch.annons.annonsrubrik)" ng-hide="jobSaved(jobMatch.annons.annonsid)">Spara annons</button>--}}
                {{--<button class="singleJobButton removeSaved" ng-show="jobSaved(jobMatch.annons.annonsid)" ng-click="removeSaved(jobMatch.annons.annonsid)"> Ta bort från sparade jobb </button>--}}
                {{--</span>--}}
            </div>
        </center>

        <div class="jobInfo">
            <h2>{{ $data['title'] }}</h2>
            <p style="white-space: pre-line">{{ $data['description'] }}</p>
        </div>
        <div class="moreInfo">
            <p class="extraJobInfo"> Varaktighet:  </p>
            <p class="extraJobInfo"> Kommun:  </p>
            <p class="extraJobInfo"> Publicerad:  </p>
            <p class="extraJobInfo"> Dagar sedan publicering:  </p>
            <p class="extraJobInfo"><a href="#">Länk till arbetsförmedlingen</a></p>
            {{--        <div>{{ jobMatch.ansokan.epostadress }}</div>--}}
            {{--        <div class="extraJobInfo">Sista ansökningsdag {{ jobMatch.ansokan.sista_ansokningsdag | date:'yyyy-MM-dd' }}</div>--}}
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 newJobContainer">
                <div class="messageBoxHeading">Ser allt bra ut?</div>
                <div class="panel-body">
                    @include('errors.validation')

                    {!! Form::open(['method' => 'POST', 'action' => 'CompanyController@store', 'class'=>'form-horizontal']) !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <div class="col-md-10 col-md-offset-1">
                            {!! Form::input('text', 'title', $data['title'], ['class' => 'form-control input-lg validationInput text-center', 'placeholder' => 'Kökspersonal på restaurang, telefonförsäljare..']) !!}
                        </div>
                    </div>

                    <div class="basicJobInfoContainer">
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::select('type', ['Kock' => 'Kock', 'Bagare' => 'Bagare'], $data['type'], ['class' => 'form-control validationInput']) !!}
                            </div>

                            <div class="col-md-4">
                                {!! Form::input('text', 'work_place', $data['work_place'], ['class' => 'form-control validationInput', 'placeholder' => 'Kafé Bullen, Telefontek AB..']) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-2">
                                {!! Form::select('county', ['Stockholms län' => 'Stockholms län'], $data['county'], ['class' => 'form-control validationInput']) !!}
                            </div>

                            <div class="col-md-4">
                                {!! Form::input('text', 'municipality', $data['municipality'], ['class' => 'form-control validationInput']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-8 col-md-offset-2">
                            {!! Form::textarea('description', $data['description'], ['class' => 'form-control validationInput', 'id' => 'description', 'placeholder' => 'Beskriv jobbets uppgifter, förkunskaper, krav osv.']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">Sista ansökningsdag</label>
                        <div class="col-md-3">
                            {!! Form::date('latest_application_date', $data['latest_application_date'], ['class' => 'form-control validationInput']) !!}
                        </div>

                        <label class="col-md-2 control-label">Kontaktperson (e-mailadress)</label>
                        <div class="col-md-4">
                            {!! Form::email('contact_email', $data['contact_email'], ['class' => 'form-control validationInput']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-4">
                            {!! Form::submit('Publicera', ['class' => 'registerFormSubmitButton col-md-12']) !!}
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
