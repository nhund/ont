<ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Trang chủ</a></li>
    @if($var['breadcrumb'] && count($var['breadcrumb']) > 0)
        @foreach($var['breadcrumb'] as $breadcrumb)
            <li class="active"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
        @endforeach
    @endif
</ol>