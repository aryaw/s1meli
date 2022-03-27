<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Set password account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{ asset('cms/pages/ico/60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('cms/pages/ico/76.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('cms/pages/ico/120.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('cms/pages/ico/152.png') }}">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ asset('cms/assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cms/assets/plugins/bootstrapv3/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cms/assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cms/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" media="screen" />    
    <link href="{{ asset('cms/pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="{{ asset('cms/pages/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
        <link href="{{ asset('cms/pages/css/ie9.css') }}" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript">
    window.onload = function()
    {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="{{ asset('cms/pages/css/windows.chrome.fix.css') }}" />'
    };
    </script>
  </head>
  <body class="fixed-header ">
    
    @if($message)
    
    <div class="container-xs-height full-height">
      <div class="row-xs-height">
        <div class="col-xs-height col-middle">
          <div class="error-container text-center">            
            <h2 class="semi-bold">{{ $message }}</h2>
          </div>
        </div>
      </div>
    </div>
    
    @else 

    <div class="register-container full-height sm-p-t-30">
      <div class="container-sm-height full-height">
        <div class="row row-sm-height">
          <div class="col-sm-12 col-sm-height col-middle">
            <h3>Set Password</h3>            
            {!! Form::open([
                'route' => ['cms.admin.activate', $code],
                'class'=>'p-t-15',
                'role'=>'form',
                'id'=>'form-register'
            ]) !!}                        

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group form-group-default">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
                    </div>
                    <span class="help-block">At least 6 characters, with number and text</span>
                    @if($errors->has('password'))
                        <p class="error">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group form-group-default">
                        <label>Password Confirmation</label>
                        <input type="password" class="form-control" placeholder="Konfirmasi password" name="password_confirmation" value="{{ old('password_confirmation') }}">
                    </div>
                    @if($errors->has('password_confirmation'))
                        <p class="error">
                            {{ $errors->first('password_confirmation') }}
                        </p>
                    @endif
                </div>
            </div>        

            <button class="btn btn-primary btn-cons m-t-10" type="submit">Active Account</button>

            {!! Form::close() !!}
            
          </div>
        </div>
      </div>
    </div>

    @endif

    <!-- BEGIN VENDOR JS -->
    <script src="{{ asset('cms/assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('cms/assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('cms/assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>    
    <script src="{{ asset('cms/assets/plugins/bootstrapv3/js/bootstrap.min.js') }}" type="text/javascript"></script>    
    <script src="{{ asset('cms/assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>    
    <script src="{{ asset('cms/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>    
    <!-- END VENDOR JS -->
    <script src="{{ asset('cms/pages/js/pages.min.js') }}"></script>    
  </body>
</html>