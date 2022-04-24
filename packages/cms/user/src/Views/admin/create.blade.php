@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Create Admin
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Admin</li>
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
							<div class="form-group {{ ($errors->first('role')) ? 'has-error' : '' }}">
								<label for="frole">Role</label>
								<select name="role" class="form-control" id="frole">
									<option value="">-- Select Role --</option>
									@foreach($roles as $role)
										<option value="{{ $role->id }}" {{ (old('role')==$role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
									@endforeach
								</select>
								@if($errors->has('role'))										
									<span class="help-block">{{ $errors->first('role') }}</span>
								@endif
							</div>
							
							<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
								<label for="femail">Email</label>
								<input type="text" class="form-control" id="femail" name="email" value="{{ old('email') }}" required>
								@if($errors->has('email'))										
									<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
								<label for="fname">Name</label>
								<input type="text" class="form-control" id="fname" name="name" value="{{ old('full_name') }}" required>
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('address')) ? 'has-error' : '' }}">
								<label for="faddress">Address</label>
								<input type="text" class="form-control" id="faddress" name="address" value="{{ old('address') }}" required>
								@if($errors->has('address'))										
									<span class="help-block">{{ $errors->first('address') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('gender')) ? 'has-error' : '' }}">
								<label for="fgender">Gender</label>
								<select name="gender" class="form-control" id="fgender">
									<option value="">-- Select Gender --</option>
									<option value="male" {{ (old('gender')=='male') ? 'selected' : '' }}>Male</option>
									<option value="female" {{ (old('gender')=='female') ? 'selected' : '' }}>Female</option>
								</select>
								@if($errors->has('gender'))										
									<span class="help-block">{{ $errors->first('gender') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('phone')) ? 'has-error' : '' }}">
								<label for="fphone">Phone</label>
								<input type="text" class="form-control" id="fphone" name="phone" value="{{ old('phone') }}" required>
								@if($errors->has('phone'))										
									<span class="help-block">{{ $errors->first('phone') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('jabatan')) ? 'has-error' : '' }}">
								<label for="fjabatan">Jabatan</label>
								<input type="text" class="form-control" id="fjabatan" name="jabatan" value="{{ old('jabatan') }}" required>
								@if($errors->has('jabatan'))										
									<span class="help-block">{{ $errors->first('jabatan') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
								<label for="fstatus">Status</label>
								<select name="status" class="form-control" id="fstatus">
									<option value="">-- Select Status --</option>
									<option value="0" {{ (old('status')=='0') ? 'selected' : '' }}>Inactive</option>
									<option value="1" {{ (old('status')=='1') ? 'selected' : '' }}>Active</option>
								</select>
								@if($errors->has('status'))										
									<span class="help-block">{{ $errors->first('status') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('password')) ? 'has-error' : '' }}" id="fgruppassword">
								<label for="fpassword">Password</label>
								<input type="password" class="form-control" id="fpassword" name="password" value="" >
								@if($errors->has('password'))										
									<span class="help-block">{{ $errors->first('password') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('confirm_password')) ? 'has-error' : '' }}" id="fgrupcpassword">
								<label for="fcpassword">Confirm Password</label>
								<input type="password" class="form-control" id="fcpassword" name="confirm_password" value="" >
								@if($errors->has('password'))										
									<span class="help-block">{{ $errors->first('confirm_password') }}</span>
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

@section('script')
  @parent  
  <script>
    $(document).ready(function(){
      	$('body').on('change', '#frole', function(evt) {
			_role = $('#frole option:selected').val();
			if(_role == '2') {
				$('#fgruppassword').hide();
				$('#fgrupcpassword').hide();
			} else {
				$('#fgruppassword').show();
				$('#fgrupcpassword').show();
			}
	  	});
    });
  </script>
@endsection