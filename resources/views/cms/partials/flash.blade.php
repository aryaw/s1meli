	
	@if(Session::has('message'))
		<div class="alert alert-success alert-dismissible auto-close-alert">
	      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      	<i class="icon fa fa-check"></i> {{ Session::get('message') }} 
    	</div>
	@endif

	@if(Session::has('error'))
		<div class="alert alert-danger alert-dismissible auto-close-alert">
	      	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	      	<i class="icon fa fa-ban"></i> {{ Session::get('error') }}
    	</div>
	@endif