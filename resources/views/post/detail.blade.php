@extends('layout')

@section('content')
	<div class="header-navigate clearfix mb15">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
					<ol class="breadcrumb breadcrumb-arrow">
						<li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
						<li><i class="fa fa-angle-right"></i></li>
						<li><a href="{{ route('post.detail',['title'=>str_slug($post->name),'id'=>$post->id]) }}" target="_self">{{ $post->name }}</a></li>                       
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div id="article" class="clearfix">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 pd5">
					{{-- <h1>{{ $post->name }}</h1> --}}
					<p class="info-created-at-article">
						Ngày: {{ date('d-m-Y H:i',$post->create_date) }}
					</p>
					<div class="info-description-article clearfix">
						{!! $post->content !!}
					</div>
					{{-- <div class="info-author-article">Business Platform</div> --}}														
				</div>
				
			</div>
		</div>
	</div>
@stop