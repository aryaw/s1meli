
	@section('metadata')
	<meta http-equiv="content-type" content="text/html" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
	<meta name="author" content="admin" />
	<meta name="description" content="{{ !empty($meta_description) ? $meta_description : setting('site.meta_description') }}">
	<meta name="keywords" content="{{  setting('site.meta_keyword') }}">
	<meta name="language" content="{{ setting('site.meta_language') }}">
	<meta name="robot" content="{{ setting('site.meta_robot') }}">
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="{{ !empty($meta_title) ? $meta_title : setting('site.title') }}" />
	<meta property="og:description" content="{{ !empty($meta_description) ? $meta_description : setting('site.meta_description') }}" />
	<meta property="og:image" itemprop="image" content="{{ !empty($meta_image) ? $meta_image : ((setting('site.og_image')) ? Storage::url(setting('site.og_image')) : '') }}" />

	<title>{{ (!empty($title) ? $title.' | ' : '') }} {{ setting('site.title') }}</title>

	<link rel="icon" href="{{ asset('assets/img/favicons.png') }}" />

	<link href="{{ asset(mix('assets/css/style.css')) }}" rel="stylesheet" type="text/css">
	@show

	<style id="antiClickjack">body{display:none !important;}</style>
	<script type="text/javascript">
		if (self === top) {
				var antiClickjack = document.getElementById("antiClickjack");
				antiClickjack.parentNode.removeChild(antiClickjack);
		} else {
				top.location = self.location;
		}
	</script>
	
	<script async id="scriptGA"></script>
	<script>
		var LGN = '{{ (getUser()) ? true : false }}';
		var SITE_URL = '{!! url("/") !!}';
		var GA_TRACKING_ID = '{!! env('GA_TRACKING_ID','') !!}';
		var FACEBOOK_CLIENT_ID = '{!! env('FACEBOOK_CLIENT_ID','') !!}';

		document.getElementById('scriptGA').src = 'https://www.googletagmanager.com/gtag/js?id=' + GA_TRACKING_ID;
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', GA_TRACKING_ID);    
	</script>

	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)	
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?	
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};	
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';	
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];	
		s.parentNode.insertBefore(t,s)}(window,document,'script',	
		'https://connect.facebook.net/en_US/fbevents.js');	
		fbq('init', '429428797618769');	
		fbq('track', 'PageView');	
		</script>	
		<noscript>
		<img height="1" width="1"	
		src="https://www.facebook.com/tr?id=429428797618769&ev=PageView	
		&noscript=1"/>	
	</noscript>
	<!-- End Facebook Pixel Code -->


	<!-- 
	Start of global snippet: Please do not remove
	Place this snippet between the <head> and </head> tags on every page of your site.
	-->
	<!-- Global site tag (gtag.js) - Google Marketing Platform -->
	<script async src="https://www.googletagmanager.com/gtag/js?id={!! env('FLOODLIGHT_ID','') !!}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', '{!! env('FLOODLIGHT_ID','') !!}');
	</script>
	<!-- End of global snippet: Please do not remove -->

	