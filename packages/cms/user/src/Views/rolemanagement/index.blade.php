@extends('cms.layouts.default')

@section('metadata')
	@parent
    <style type="text/css">
		.parent{
			font-weight: bold;
		}
		.child{
			padding-left: 10px;
		}
	</style>
@endsection

@section('content')
	<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Roles
      <small>data</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('cms.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li>User</li>
      <li class="active">Role Management</li>
    </ol>    
  </section>		

	<!-- Main content -->
    <section class="content">
    	@include('cms.partials.flash')
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">

            <!-- /.box-header -->
            <div class="box-body">
							{!! Form::open(['route' => 'cms.rolemanagement.store','autocomplete'=>'off']) !!}			
                <table class="table table-hover table-condensed no-outline">
                  <thead>
                    <tr>
                        <th>Module</th>
                        @foreach($roles as $role)
                        <th>{{ $role->name }}</th>
                        @endforeach
                    </tr>
                  </thead>

                  <tbody>
                    
                    @foreach($permissions as $index=>$permission)
											
											<tr>
												@if($permission['parent'] === '0')
													<td>
		                				<span class="parent"> {{ $permission['name'] }}</span>                				 			
		                			</td>	
		                			@else
		                			<td>
		                				<span class="child"> {{ $permission['name'] }}</span>                				 			
		                			</td>	
		                		@endif
									
												@foreach($permission['roles'] as $indx=>$role)
												<td>
													<div class="checkbox check-success">
													
														<input 	
														type="checkbox" value="true"
														id="{{ $role['slug'].'.'.$permission['code'] }}"
														{{ ($permission['parent'] !== '0') ? 'name='.$role['slug'].'['.$permission['code'].']' : '' }}													
														data-parent="{{ $permission['parent'] }}"
														data-parentindex="{{ $index }}"
														data-roleindex="{{ $indx }}"
														{{ ($role['checked']===true) ? 'checked' : '' }}>

							                <label for="{{ $role['slug'].'.'.$permission['code'] }}"></label>
							            </div>
		                    </td>
												@endforeach

											</tr>

	                 		@endforeach                    	
                  </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Save</button>
							{!! Form::close() !!}

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
	@parent	
    <script>    
    	var	permissions = {!! json_encode($permissions) !!};    	
			$('input[type="checkbox"]').change(function(){
				var parent = $(this).data('parent');			
				var parentIndex = $(this).data('parentindex');
				var roleIndex = $(this).data('roleindex');			

				if(typeof permissions[parentIndex] !== undefined){
					var dataParent = permissions[parentIndex];
					var dataRole = dataParent['roles'][roleIndex];				
					var checked = this.checked;

					if(parent === 0){				
						$.each( permissions, function( key, value ) {
							if(value.parent == dataParent.code){							
								$.each(value['roles'], function(k, v){								
									if(v.slug == dataRole.slug){									
										var id = v.slug + '.' + value.code;
										$('input[id="'+id+'"]').prop('checked', checked);									
									}
								});													
							}
						});
					}else{
						$.each( permissions, function( key, value ) {						
							if(value.parent != 0){
								$.each(value.roles, function(k, v){
									if(v.slug == dataRole.slug && dataParent.parent == value.parent){									
										var id = v.slug + '.' + value.code;
										var yes = $('input[id="'+id+'"]').is(':checked');
										if(yes){
											checked = true;
										}
									}
								});
							}	
						});
						
						var parentId = dataRole.slug + '.' + dataParent.parent;
						$('input[id="'+parentId+'"]').prop('checked', checked);					
					}
				}
			});
    </script>
@endsection