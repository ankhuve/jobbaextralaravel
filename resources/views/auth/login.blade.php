@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="messageBox">
				<div class="messageBoxHeading">Inloggning</div>
				<div class="panel-body">
                    @include('errors.validation')

					<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Lösenord</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Håll mig inloggad
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="registerFormSubmitButton col-md-12">Logga in</button>
							</div>
						</div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <a class="loginFormLink" href="{{ url('/password/email') }}">Glömt ditt lösenord?</a>
                                <br/>
                                <a class="loginFormLink" href="{{ url('/register') }}">Inget konto?</a>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
