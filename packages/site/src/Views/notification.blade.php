@extends('site::layouts.default')

@section('content')
<script>
  gtag('event', 'conversion', {
    'allow_custom_scripts': true,
    'send_to': '{!! env('FLOODLIGHT_ID','') !!}/thank0/mkid_00+standard'
  });
</script>
<noscript>
<img src="https://ad.doubleclick.net/ddm/activity/src=9031671;type=thank0;cat=mkid_00;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;tfua=;npa=;ord=1?" width="1" height="1" alt=""/>
</noscript>
<!-- End of event snippet: Please do not remove -->

<main class="global">
	<section>
		<div class="container">
			<div class="ct">				
				<!-- <span class="love-text">
					<img src="{{ asset('assets/img/heart.png') }}" alt="heart">
					HeartsPrints
				</span> -->
				<h2>
					{!! $message !!}
				</h2>
			</div>
			<p>
				
			</p>
		</div>
	</section>
</main>

@endsection