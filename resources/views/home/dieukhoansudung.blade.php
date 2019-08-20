@extends('layout')

@section('content')
<main>
	<div class="container">
		<div class="row">
			<h2>Điều khoản sử dụng</h2>
			<div class="box-body">
				{!! $var['about']->terms !!}
			</div>
		</div>
	</div>
</main>
@stop