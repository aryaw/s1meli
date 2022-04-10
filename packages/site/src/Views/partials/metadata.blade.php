
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

	<link rel="icon" href="{{ asset('assetss/img/favicons.png') }}" />

	<link href="{{ asset(mix('assetss/css/style.css')) }}" rel="stylesheet" type="text/css">
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
	