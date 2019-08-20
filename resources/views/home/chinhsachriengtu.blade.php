@extends('layout')

@section('content')
<main>
	<div class="container">
		<div class="row">
			<h2>Chính sách riêng tư</h2>
			<div class="box-body">
				{!! $var['about']->privacy_policy !!}
			</div>
		</div>
	</div>
</main>

@stop