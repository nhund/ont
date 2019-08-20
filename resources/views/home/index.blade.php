@extends('layout')

@section('content')
	@include('home.slider')
	@include('home.about')                   
	@include('home.course')   
	{{-- @include('home.download_app')      --}}
	@include('home.service')    
	@include('home.teacher')                           
	<div class="clearbox"></div> 
	
@stop

@push('js')
	
		<!-- Your customer chat code -->
		<div class="fb-customerchat"
		attribution=setup_tool
		page_id="673036986432952"
		theme_color="#ff7e29"
		logged_in_greeting="Hi! How can we help you?"
		logged_out_greeting="Hi! How can we help you?">
	</div>
@endpush

