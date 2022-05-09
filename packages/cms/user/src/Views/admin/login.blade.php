<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Log in</title>  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="{{ asset('cms/dist/css/login.min.css') }}" rel="stylesheet" type="text/css" />    

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <h4>Sistem Informasi Manajemen Sarana Prasarana</h4>
  <div class="login-logo">
    <a href="javascript:void(0)"><b>SMP PGRI 2 Denpasar</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Maaf email & password tidak sesuai</p>
    
    {!! Form::open(['route' => 'cms.dologin', 'id'=>'form-login']) !!}
      
      <div class="form-group has-feedback">
        <input type="email" name="username" class="form-control" placeholder="Email" value="{{ old('username') }}" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required id="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <br>
        <input type="checkbox"  onclick="showPasswd()"> Show Password
      </div>
      
      @if(session('message'))
      <label class="error" for="password">{{ session('message') }}</label>
      @endif

      <div class="row">
        <div class="col-xs-8">          
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>

    {!! Form::close() !!}

    @php
    /*
    <a href="{{ route('user.forgotpassword') }}">I forgot my password</a><br>
    */
    @endphp

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<script src="{{ asset('cms/dist/js/login.min.js') }}"></script>
<script>
  function showPasswd() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
</body>
</html>
