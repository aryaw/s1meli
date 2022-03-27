@extends('site::layouts.default')

@section('content')

<main class="tp">
	<section class="tp--text">
		<div class="container">	
			<span class="love-text center">
				<img src="{{ asset('assets/img/heart.png') }}" alt="heart">
				HeartsPrints
			</span>
			<div class="form">
				<div class="row">
					<div class="dc4 tc12 auto">
						
						{!! Form::open(['route' => ['site.reset', $code], 'autocomplete'=>'off', 'id'=>'formResetPassword']) !!}
						<h2>RESET PASSWORD</h2>
						
						<div class="input">
							<input type="password" class="input__text" placeholder="Password" name="password" value="{{ old('password') }}" required data-parsley-trigger="keyup focusout">
							@if($errors->has('password'))										
								<p class="error" id="error_password">{{ $errors->first('password') }}</p>
							@endif
						</div>

						<div class="input">
							<input type="password" class="input__text" placeholder="Password Confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required data-parsley-trigger="keyup focusout">
							@if($errors->has('password_confirmation'))										
								<p class="error" id="error_password_confirmation">{{ $errors->first('password_confirmation') }}</p>
							@endif
						</div>

						<div class="input">
							<button class="btn btn--primary" type="submit">Reset Password</button>
						</div>
						{!! Form::close() !!}

					</div>
				</div>
			</div>
			
		</div>
	</section>
</main>

@endsection