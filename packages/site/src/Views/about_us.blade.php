@extends('site::layouts.default')

@section('content')

<main class="general-page">
	<section class="gnr">
		<div class="container con-about">
			<h1>About Us</h1>
			{!! setting('content.about_us') !!}
		</div>
  </section>
  
	<!-- include('site::partials.custom') -->
  
  @include('site::partials.simple')
  
</main>

@endsection