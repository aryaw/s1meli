@extends('site::layouts.default')

@section('metadata')
@parent
<style>
	ol li{
		list-style: decimal !important;
	}
</style>
@endsection

@section('content')
<main class="global">
	<section>
		<div class="container">
			<div class="ct">				
				<!-- <span class="love-text">
					<img src="{{ asset('assets/img/heart.png') }}" alt="heart">
					HeartsPrints
				</span> -->
				<h2>
					Syarat & Ketentuan
				</h2>
			</div>
			{!! setting('content.term') !!}
		</div>
	</section>
</main>
@endsection