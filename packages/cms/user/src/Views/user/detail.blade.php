@extends('cms.layouts.default')

@section('content')

<section class="content-header">
  <h1>
    Detail User
    <small>{{ $user->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li>User</li>
    <li><a href="{{ route('cms.user.view') }}">User</a></li>
    <li class="active">detail</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
          <strong>Photo Profile</strong>    
          <p class="text-muted">
            @if($user->photo)
            <a href="{{ url($user->photo) }}" target="_blank">
              <img src="{{ url($user->photo) }}" alt="logo" width="150">
            </a>              
            @endif
          </p>
          <hr>          
          <strong>Name</strong>    
          <p class="text-muted"> {{ $user->name }}</p>
          <hr>                      
          <strong>Email</strong>    
          <p class="text-muted"> {{ $user->email }}</p>
          <hr>                      
          <strong>Phone</strong>    
          <p class="text-muted"> {{ $user->phone }}</p>
          <hr>          
          <strong>Address</strong>    
          <p class="text-muted"> {{ $user->address }}</p>
          <hr>          

        </div>

      </div>
      <!-- /.box -->
    </div>
    <!--/.col (left) -->        
  </div>
  <!-- /.row -->
</section>

@endsection