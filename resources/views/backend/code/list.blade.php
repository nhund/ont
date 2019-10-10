@extends('backend.layout')
@section('title', $page_title)
@push('css')
    <link href="{{asset('/public/admintrator/assets/css/animate.min.css')}}" type="text/css" rel="stylesheet">
@endpush
@push('js')
    <script src="{{ asset('/public/admintrator/assets/js/bootstrap-notify.min.js?ver=1') }}"></script>
    <script src="{{ asset('/public/admintrator/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript">
        $('.price').keyup(function () {
            $(this).val(number_format($(this).val()));
        });
        $('#datepicker').datepicker({
            todayHighlight: true,
            startDate: "-0d",
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
        function checkData() {
            var quantity        = $.trim($('#handleCode input[name="quantity"]').val());
            var price           = $.trim($('#handleCode input[name="price"]').val());
            price.replace('.', '');
            //validate
            if (!quantity || parseInt(quantity) > 1000 || parseInt(quantity) < 1) {
                showErrorMsg('Số lượng phải lớn hơn 0 và nhỏ hơn 1000');
                return false;
            }
            if (!price || parseInt(price) > 10000000 || parseInt(quantity) <1) {
                showErrorMsg('Vui lòng nhập giá < 10.000.000');
                return false;
            }
            $('#handleCode').submit();
        }
        $('#handleDocument').on('hidden.bs.modal', function () {
            window.location.reload();
        })
    </script>
@endpush
@section('content')
    @include('include.backend.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading">
                        <h2>#Code</h2>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="#handleDocument" data-toggle="modal">Tạo code</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form action="" method="GET">
                            <div class="col-sm-8">&nbsp;</div>
                            <div class="input-group col-sm-4">
                                <input type="text" autocomplete="off" name="search_code" placeholder="Nhập mã code" class="form-control" value="{{ $search_code ?? '' }}">
                                <span class="input-group-btn">
                                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                              </span>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="3%">STT</th>
                                    <th width="10%">Ngày tạo</th>
                                    <th width="10%">Code</th>
                                    <th>Giá</th>
                                    <th>Nguồn</th>
                                    <th>Email</th>
                                    <th>Người dùng</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian kích hoạt</th>
                                    <th>Ngày hết hạn</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if ($code->total())
                                        @foreach($code as $co)
                                            @if (file_exists(public_path().'/document/file/'.$co->document))
                                                <tr class="row-doc">
                                                    <td>{{ $loop->iteration  }}</td>
                                                    <td align="left">
                                                        {{ date('d/m/Y', $co->created_at) }}
                                                    </td>
                                                    <td>
                                                        {{ $co->cCode }}
                                                    </td>
                                                    <td>{{  number_format($co->price,0,',','.') }}</td>

                                                    <td>
                                                        @if(empty($co->social_type))
                                                            Web
                                                        @else
                                                            @if($co->social_type == \App\User::LOGIN_FB)
                                                                FaceBook
                                                            @else
                                                                Google
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>{{$co->email}}</td>
                                                    <td>{{$co->full_name}}</td>
                                                    <td>
                                                        @if ($co->status)
                                                            <span class="color-red">Đã sử dụng</span>
                                                        @else
                                                            <span class="color-green">Chưa sử dụng</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ (empty($co->dateActive)) ? '' : date('d/m/Y H:i:s', $co->dateActive) }}</td>
                                                    <td>@if($co->end_date) {{ date('d/m/Y', $co->end_date) }} @else Không thời hạn @endif</td>
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
                            {{ $code->appends(Request::except('page'))->render() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="handleDocument" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h1 class="modal-title">Tạo code</h1>
                </div>
                <form id="handleCode" method="POST" action="{{ route('code.handle') }}">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group row">
                            <div class="col-sm-3">Số lượng (Tối đa: 1000/lần)</div>
                            <div class="col-sm-5">
                                <input type="number" autocomplete="off" class="form-control" placeholder="Số lượng" name="quantity">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">Mệnh giá</div>
                            <div class="col-sm-5">
                                <input type="text" autocomplete="off" class="form-control price" placeholder="Giá" name="price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">Ngày hết hạn</div>
                            <div class="col-sm-5">
                                <input type="text" autocomplete="off" class="form-control" id="datepicker" name="end_date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-5">
                                <input type="checkbox" name="excel"> Xuất Excel
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="checkData()">Tạo</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection