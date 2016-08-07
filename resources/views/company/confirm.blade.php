@extends('app')

@section('content')
    <div class="container">
        @include('pages.partials.newjobconfirmation', ['job' => $data ])
    </div>

    <div class="container">
        <div class="newJobContainer" id="confirmBox">
            <div class="messageBoxHeading">Ser allt bra ut?</div>

            <div class="panel-body confirmationForm">
                @include('errors.validation')

                {!! Form::open(['method' => 'POST', 'action' => 'CompanyController@store', 'class'=>'form-horizontal', 'id' => 'createNewJob']) !!}

                <div class="form-group">
                    <div class="col-md-10 col-md-offset-1">
                        {!! Form::input('text', 'title', $data['title'], ['class' => 'form-control input-lg validationInput
                        text-center', 'placeholder' => 'Kökspersonal på restaurang, telefonförsäljare..']) !!}
                    </div>
                </div>

                <div class="basicJobInfoContainer">
                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            {!! Form::input('text', 'type', $data['type'], ['class' =>
                            'form-control validationInput']) !!}
                        </div>

                        <div class="col-md-4">
                            {!! Form::input('text', 'work_place', $data['work_place'], ['class' => 'form-control
                            validationInput', 'placeholder' => 'Kafé Bullen, Telefontek AB..']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-2">
                            {!! Form::input('text', 'county', $data['county'], ['class' =>
                            'form-control validationInput']) !!}
                        </div>

                        <div class="col-md-4">
                            {!! Form::input('text', 'municipality', $data['municipality'], ['class' => 'form-control
                            validationInput']) !!}
                        </div>
                    </div>
                </div>

                <div class="form-group">

                    <div class="col-md-8 col-md-offset-2">
                        {!! Form::textarea('description', $data['description'], ['class' => 'form-control validationInput',
                        'id' => 'description', 'placeholder' => 'Beskriv jobbets uppgifter, förkunskaper, krav osv.']) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-2 control-label">Sista ansökningsdag</label>

                    <div class="col-md-3">
                        {!! Form::date('latest_application_date', $data['latest_application_date'], ['class' =>
                        'form-control validationInput']) !!}
                    </div>

                    <label class="col-md-2 control-label">Kontaktperson (e-mailadress)</label>

                    <div class="col-md-4">
                        {!! Form::email('contact_email', $data['contact_email'], ['class' => 'form-control
                        validationInput']) !!}
                    </div>
                </div>

                {!! Form::close() !!}
                <div class="confirmButtons form-group">
                    <div class="col-xs-6">
                        {{--{{ dd(URL::getRequest()->request->all()) }}--}}
                        <a href="{{ URL::route('company.create', URL::getRequest()->request->all()) }}">
                            <button class="responsiveButton col-xs-12 cancelButton">Nej, ändra</button>
                        </a>
                    </div>
                    <div class="col-xs-6">
                        {!! Form::submit('Ja, Publicera', ['class' => 'responsiveButton col-xs-12 confirmButton', 'form' => 'createNewJob']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<script src="/js/jquery.js"></script>--}}
    {{--<script src="js/openConfirmForm.js"></script>--}}
@endsection
