@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="messageBox">
                <div class="messageBoxHeading">Registrera ny användare</div>
                <div class="panel-body">
                    @include('errors.wrongusertype')
                    @include('errors.validation')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{--<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">--}}
                            {{--<label class="col-md-4 control-label">Typ av användare</label>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<select type="select" class="form-control" name="role">--}}
                                    {{--<option value="1">Privatperson</option>--}}
                                    {{--<option value="2">Företag</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}

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

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="registerFormSubmitButton col-md-12">
                                    Registrera
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
