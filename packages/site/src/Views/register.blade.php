@extends('site::layouts.default')

@section('content')
<main class="tp tp--reg">
    <section class="tp--text">
      <div class="container">	
       
        
        <div class="form">
          <div class="row">
            <div class="dc4 tc12 auto">
              {!! Form::open(['route' => 'site.do_register', 'autocomplete'=>'off', 'id'=>'formRegister']) !!}
              <h1 class="ripley-2">Daftar Sekarang</h1>
              <p>
                Daftar dan menangkan kencanmu!
              </p>
              <div class="input">
                <input type="text" class="input__text" placeholder="Nama Depan" name="first_name" value="{{ old('first_name') }}" required required minlength="2" data-parsley-trigger="keyup focusout">
                @if($errors->has('first_name'))										
                  <p class="error server-error" id="error_first_name">{{ $errors->first('first_name') }}</p>
                @endif
              </div>
              
              <div class="input">
                <input type="email" class="input__text" placeholder="Email" name="email" value="{{ old('email') }}" required minlength="3" data-parsley-trigger="keyup focusout">
                @if($errors->has('email'))										
                  <p class="error server-error" id="error_email">{{ $errors->first('email') }}</p>
                @endif
              </div>
              <div class="input">
                <input type="password" class="input__text" placeholder="Password" name="password" value="{{ old('password') }}" required minlength="5" data-parsley-trigger="keyup focusout">
                @if($errors->has('password'))										
                  <p class="error server-error" id="error_password">{{ $errors->first('password') }}</p>
                @endif
              </div>

              <!-- <div class="input">
                <input type="text" class="input__text" placeholder="Nama Belakang" name="last_name" value="{{ old('last_name') }}" required minlength="2" data-parsley-trigger="keyup focusout">
                @if($errors->has('last_name'))										
                  <p class="error server-error" id="error_last_name">{{ $errors->first('last_name') }}</p>
                @endif
              </div>
              <div class="input">
                <input type="password" class="input__text" placeholder="Konfirmasi Password" name="password_confirmation" value="{{ old('password_confirmation') }}" required minlength="5" data-parsley-trigger="keyup focusout">
                @if($errors->has('password_confirmation'))										
                  <p class="error server-error" id="error_password_confirmation">{{ $errors->first('password_confirmation') }}</p>
                @endif
              </div> -->

              <div class="input">
                <button class="btn btn--primary" type="submit" onclick="gaEvent('register', 'email register', 'Email Register')">DAFTAR</button>
              </div>
              {!! Form::close() !!}
            </div>
          </div>

          @if(Session::has('social_login_error'))
          <div class="row">
            <div class="dc4 tc12 auto">
              <h4 style="color:red">{{ Session::get('social_login_error') }} </h4>
            </div>
          </div>
          @endif

        </div>

        

        <div class="row">
          <div class="dc4 tc12 auto">
            <p>Atau daftar dengan</p>
            <div class="btn-wrapper">
              <a href="{{ route('site.social.login',['provider'=>'facebook']) }}" class="btn btn--secondary" onclick="gaEvent('register', 'facebook register', 'Facebook Register')">Facebook</a>
              <a href="{{ route('site.social.login',['provider'=>'google']) }}" class="btn btn--triary" onclick="gaEvent('register', 'google register', 'Google Register')">Google</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection