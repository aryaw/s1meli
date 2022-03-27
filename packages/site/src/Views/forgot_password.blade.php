@extends('site::layouts.default')

@section('content')

<main class="tp tp--reg">
	<section class="tp--text">
		<div class="container">	
			<!-- <span class="love-text center">
				<img src="{{ asset('assets/img/heart.png') }}" alt="heart">
				HeartsPrints
			</span> -->
			<div class="form">
				<div class="row">
					<div class="dc4 tc12 auto">
						
						{!! Form::open(['route' => 'site.do_forgot_password', 'autocomplete'=>'off', 'id'=>'formForgotPassword']) !!}
						<h2>LUPA PASSWORD</h2>

						<div class="input">
							<input type="email" class="input__text" placeholder="Email" name="email" value="{{ old('email') }}" required data-parsley-trigger="keyup focusout">							
							@if($errors->has('email'))										
								<p class="error server-error" id="error_email">{{ $errors->first('email') }}</p>
							@endif
							@if(Session::get('mail_error'))
								<p class="error">{{ Session::get('mail_error') }}</p>
							@endif
							@if(Session::get('success'))
								<p>{{ Session::get('success') }}</p>
							@endif
						</div>

						<div class="input">
							<button class="btn btn--primary" type="submit">Send</button>
						</div>
						{!! Form::close() !!}

					</div>
				</div>
			</div>
			
		</div>
	</section>
</main>

@endsection