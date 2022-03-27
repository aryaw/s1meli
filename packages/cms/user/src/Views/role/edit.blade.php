@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Edit Role
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>User</li>
      <li><a href="{{ route('cms.role.view') }}">Roles</a></li>
      <li class="active">User</li>
    </ol>
  </section>

  <!-- Main content -->
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

          <!-- form start -->          
         	{!! Form::open(['route' => ['cms.role.update', $role->id], 'method'=>'PUT', 'role'=>'form', 'autocomplete'=>'off']) !!}
            <div class="box-body">
              <div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
                <label for="fname">Name</label>
                <input type="text" class="form-control" id="fname" placeholder="Name" name="name" value="{{ (old('name')) ? old('name') : $role->name }}" required>
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
              </div>
              <div class="form-group">
                <label for="fslug">Slug</label>                  
                <input type="text" class="form-control" id="fslug" placeholder="Slug" name="slug" value="{{ (old('slug')) ? old('slug') : $role->slug }}" required>
                @if($errors->has('slug'))										
									<span class="help-block">{{ $errors->first('slug') }}</span>
								@endif
              </div>                
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          {!! Form::close() !!}

        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->        
    </div>
    <!-- /.row -->
  </section>
    
@endsection