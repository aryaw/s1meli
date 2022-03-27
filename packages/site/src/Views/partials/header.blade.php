<div id="top-wrapper">
  <header>
    <div class="container">
      <a href="{{ route('site.index') }}" class="logo"><img src="{{ asset('assets/img/logo.png') }}" alt="logo"></a>
      <div class="user">
        <button class="user__btn">
          <img src="{{ asset('assets/img/user.png') }}" alt="user logo">
        </button>
        <div class="user__wrapper">          
          
          @if(!getUser())
            <!-- NOT LOGIN -->
            <form action="" id="formLogin">
            <div class="input">
              <input type="text" class="input__text" placeholder="e-mail" id="signEmail" required data-parsley-trigger="keyup focusout">
              <p class="error" id="inputLoginEmail"></p>
            </div>
            <div class="input">
              <input type="password" class="input__text" placeholder="password" id="signPassword" required data-parsley-trigger="keyup focusout">
              <p class="error" id="inputLoginPassword"></p>
            </div>
            <p>
              <a href="{{ route('site.forgot_password') }}">Lupa Password?</a>
            </p>
            <div class="input" id="btnLoginWrapper">
              <button class="btn btn--primary" type="submit" onclick="gaEvent('login', 'email login', 'Email Login')">masuk</button>
            </div>
            
            <div class="input" id="btnLoadingWrapper" style="display: none;">
              <button class="btn btn--primary btn--loading">
                <span class="loading">loading</span>
              </button>
            </div>

            </form>
            
            <hr class="separator"></hr>
            <div class="input">
              <a href="{{ route('site.social.login',['provider'=>'facebook']) }}" class="btn btn--secondary" onclick="gaEvent('login', 'facebook login', 'Facebook Login')">Facebook</a>              
            </div>
            <div class="input">
                <a href="{{ route('site.social.login',['provider'=>'google']) }}" class="btn btn--triary" onclick="gaEvent('login', 'google login', 'Google Login')">Google</a>
            </div>        
          @else
            <!-- LOGGED IN -->
            <h3>Welcome</h3>
            <h1>{{ getUser()->first_name }}</h1>
            <a href="{{ route('site.logout') }}" class="btn btn--primary">sign out</a>
          @endif

        </div>
      </div>
      <div class="clear"></div>
    </div>
  </header>