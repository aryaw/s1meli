@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Edit Admin
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>Admin</li>
			<li><a href="{{ route('cms.admin.view') }}">Admin</a></li>			
			<li class="active">Edit</li>
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
					{!! Form::open(['route' => ['cms.admin.update', 'id'=>$user->id], 'role'=>'form', 'autocomplete'=>'off']) !!}	
						<div class="box-body">
                        <input type="hidden" class="form-control" name="post_id" value="{{ $user->id }}" required>
							
							<div class="form-group {{ ($errors->first('email')) ? 'has-error' : '' }}">
								<label for="femail">Email</label>
								<input type="text" class="form-control" id="femail" name="email" value="{{ (old('email')) ? old('email') : $user->email }}" required>
								@if($errors->has('email'))										
									<span class="help-block">{{ $errors->first('email') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('name')) ? 'has-error' : '' }}">
								<label for="fname">Name</label>
								<input type="text" class="form-control" id="fname" name="name" value="{{ (old('full_name')) ? old('full_name') : $user->email }}" required>
								@if($errors->has('name'))										
									<span class="help-block">{{ $errors->first('name') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('address')) ? 'has-error' : '' }}">
								<label for="faddress">Address</label>
								<input type="text" class="form-control" id="faddress" name="address" value="{{ (old('address')) ? old('address') : $user->address }}" required>
								@if($errors->has('address'))										
									<span class="help-block">{{ $errors->first('address') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('gender')) ? 'has-error' : '' }}">
								<label for="fgender">Gender</label>
                                @php
                                $selected_gender = (isset($user->gender)) ? $user->gender : old('gender');
                                @endphp
								<select name="gender" class="form-control" id="fgender">
									<option value="">-- Select Gender --</option>
									<option value="male" {{ ($selected_gender=='male') ? 'selected' : '' }}>Male</option>
									<option value="female" {{ ($selected_gender=='female') ? 'selected' : '' }}>Female</option>
								</select>
								@if($errors->has('gender'))										
									<span class="help-block">{{ $errors->first('gender') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('phone')) ? 'has-error' : '' }}">
								<label for="fphone">Phone</label>
								<input type="text" class="form-control" id="fphone" name="phone" value="{{ (old('phone')) ? old('phone') : $user->phone }}" required>
								@if($errors->has('phone'))										
									<span class="help-block">{{ $errors->first('phone') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('status')) ? 'has-error' : '' }}">
								<label for="fstatus">Status</label>
                                @php
                                $selected_status = (isset($activation)) ? $activation : old('status');
                                @endphp
								<select name="status" class="form-control" id="fstatus">
									<option value="">-- Select Status --</option>
									<option value="0" {{ ($selected_status=='0') ? 'selected' : '' }}>Inactive</option>
									<option value="1" {{ ($selected_status=='1') ? 'selected' : '' }}>Active</option>
								</select>
								@if($errors->has('status'))										
									<span class="help-block">{{ $errors->first('status') }}</span>
								@endif
							</div>

							<div class="form-group {{ ($errors->first('role')) ? 'has-error' : '' }}">
								<label for="frole">Role</label>
								<select name="role" class="form-control" id="frole">
                                    <option value="">-- Select Option --</option>
                                    @foreach($roles as $role)
                                        @php
                                            $selected = ( isset($user->role->role_id) && $role->id == $user->role->role_id) ? 'selected' : '';
                                            if(old('role') && old('role')==$role->id){
                                                $selected = 'selected';
                                            }
                                        @endphp
                                        <option value="{{ $role->id }}" {{ $selected }}>{{ $role->name }}</option>
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