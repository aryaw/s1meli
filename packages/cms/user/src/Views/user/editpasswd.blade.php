@extends('cms.layouts.default')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Edit User Password
			<small></small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			<li>User</li>
			<li><a href="{{ route('cms.user.view') }}">Admin</a></li>			
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
					{!! Form::open(['route' => ['cms.user.updatepasswd', 'id'=>$user->id], 'role'=>'form', 'autocomplete'=>'off']) !!}	
						<div class="box-body">
                            <input type="hidden" class="form-control" name="post_id" value="{{ $user->id }}" required>
                                
                            <div class="form-group {{ ($errors->first('password')) ? 'has-error' : '' }}">
                                <label for="fpassword">Password</label>
                                <input type="password" class="form-control" id="fpassword" name="password" value="" >
                                @if($errors->has('password'))										
                                    <span class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group {{ ($errors->first('confirm_password')) ? 'has-error' : '' }}">
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