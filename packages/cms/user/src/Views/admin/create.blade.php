@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Create Role
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>User</li>
			<li><a href="{{ route('cms.admin.view') }}">Admin</a></li>			
			<li class="active">Create</li>
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
					
					<!-- form start -->
					{!! Form::open(['route' => 'cms.admin.store', 'role'=>'form', 'autocomplete'=>'off']) !!}	
						<div class="box-body">
							
							<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
								<label for="femail">Email</label>
								<input type="text" class="form-control" id="femail" placeholder="Email" name="email" value="{{ old('email') }}" required>
								@if($errors->has('email'))										
									<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
								<label for="fname">Name</label>
								<input type="text" class="form-control" id="fname" placeholder="Name" name="name" value="{{ old('name') }}" required>
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('role')) ? 'has-error' : '' }}">
								<label for="frole">Role</label>
								<select name="role" class="form-control" id="frole">
									<option value="">-- Select Option --</option>
									@foreach($roles as $role)
										<option value="{{ $role->id }}" {{ (old('role')==$role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
									@endforeach
								</select>
								@if($errors->has('role'))										
									<span class="help-block">{{ $errors->first('role') }}</span>
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