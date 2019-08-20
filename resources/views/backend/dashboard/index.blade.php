@extends('backend.layout')

@section('content')
	
	@include('backend.include.breadcrumb',['var'=>$breadcrumb])
{{-- <form action="{{ route('admin.testSave') }}" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}    
	<input type="file" name="file" class="form-control file">
	<br>
	<button class="btn btn-success import">Import User Data</button> --}}
	{{-- <a class="btn btn-warning" href="{{ route('admin.testSave') }}">Export User Data</a> --}}
{{-- </form> --}}
@endsection
@push('js')   
<script type="text/javascript">
	
</script>
@endpush