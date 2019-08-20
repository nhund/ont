@extends('backend.layout')
@section('title', $page_title)
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/form-ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        function confirmDelete(id) {
            $('.delDoc').attr('id-doc', id);
            $('#delDocument').modal('show');
        }
        function delDoc(e) {
            var id = $(e).attr('id-doc');
            window.location.href = '/admin/document/delete/'+id;
        }
        function handleDoc(id) {
            $.ajax({
                url: '/admin/document/infor',
                data: { id: id, _token: '{{ csrf_token() }}'},
                dataType: 'json',
                method: 'POST',
                success: function (response) {
                    if (response.status) {
                        $('#editDocument .modal-content').html(response.tpl);
                        $('#editDocument').modal('show');
                        CKEDITOR.replace('ckeditor')
                    }
                }
            });
        }
    </script>
@endpush
@section('content')
    @include('include.backend.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                        <h2>Tài liệu</h2>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="#handleDocument" data-toggle="modal">Thêm mới</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="10%">STT</th>
                                    <th width="25%">Tên</th>
                                    <th>Kích thước</th>
                                    <th>Thời gian</th>
                                    <th>#Tải</th>
                                    <th>Tải</th>
                                    <th>Xóa</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if ($documents->total())
                                        @foreach($documents as $doc)
                                            @if (file_exists(public_path().'/document/file/'.$doc->document))
                                                <tr class="row-doc" onclick="handleDoc('{{ $doc->id }}')">
                                                    <td>{{ $loop->iteration  }}</td>
                                                    <td align="left">
                                                        <img class="doc_img"
                                                                     @if(!$doc->avatar) src="{{ asset('public/document/avatar/avatardefault.jpg') }}" @else src="{{ asset('public/document/avatar/'.$doc->avatar) }}" @endif     >
                                                        {{ $doc->title }}
                                                    </td>
                                                    <td>
                                                        {{ File::size(public_path('document/file/'.$doc->document))/1000000 }} MB
                                                    </td>
                                                    <td>{{ date('d/m/Y', $doc->created_at) }}</td>
                                                    <td>{{ $doc->download or '0' }}</td>
                                                    <td><a href="{{ route('document.download', ['id' => $doc->id]) }}"
                                                           title="Tải xuống"><i class="fa fa-download documentBtn"></i></a>
                                                    </td>
                                                    <td><a onclick="confirmDelete('{{ $doc->id }}')"
                                                           title="Tải xuống"><i class="fa fa-times documentBtn"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                Chưa có dữ liệu
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{ $documents->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.backend.document.document_modal')
@endsection