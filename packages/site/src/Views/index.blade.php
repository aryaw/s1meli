@extends('site::layouts.default')


@section('metadata')
@parent
<link href="{{ asset('assetss/css/swiper.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
@endsection

@section('site_script')
@parent
<script type="text/javascript" src="{{ asset('assets/js/swiper.min.js') }}"></script>
@endsection