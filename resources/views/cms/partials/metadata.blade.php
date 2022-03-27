  @section('metadata')
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  
    <title> {{ (!empty($title) ? $title.' | ' : '') }} {{ setting('admin.title') }}</title>
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @show
    <link href="{{ asset('cms/dist/css/vendor.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('cms/dist/css/app.min.css') }}" rel="stylesheet" type="text/css">
  </head>