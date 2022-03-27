<!DOCTYPE HTML>
<html lang="en">
<head>
	@include('site::partials.metadata')
</head>
<body>

	@include('site::partials.header')

	@yield('content')

	@include('site::partials.footer')	
	
	@include('site::partials.script')    

</body>
</html>