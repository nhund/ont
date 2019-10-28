@extends('backend.layout')
@section('title', 'Chi tiết tài khoản')
@section('content')
    @include('backend.include.breadcrumb')
    <div class="container-fluid">
        <div id="panel-advancedoptions">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body panel-no-padding">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Họ và tên</th>
                                        <th>Tài khoản trước giao dịch</th>
                                        <th>Số tiền thay đổi</th>
                                        <th>Loại giao dịch</th>
                                        <th>Ghi chú</th>
                                        <th width="150">Ngày giao dịch</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($var['histories']))
                                        @foreach ($var['histories'] as $item)
                                            <tr>
                                                <td data-title="Họ tên :">{{ $item->user->name_full }}</td>
                                                <td data-title="Tài khoảnn :">{{ number_format($item->xu_current) }}</td>
                                                <td data-title="Tiền thay đổi :">{{ number_format($item->xu_change) }}</td>
                                                <td data-title="Giao dịch :">
                                                    @if($item->type == App\Models\WalletLog::TYPE_NAP_XU)
                                                        Nạp mã thẻ
                                                    @endif
                                                    @if($item->type == App\Models\WalletLog::TYPE_MUA_KHOA_HOC)
                                                        Mua khóa học
                                                    @endif
                                                </td>
                                                <td data-title="Ghi chú :">
                                                    {{ $item->note }}
                                                </td>
                                                <td data-title="Ngày tạo :">{{ date('d/m/Y H:i',$item->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">Tài khoản chưa có giao dịch</td>
                                        </tr>
                                    @endif
                                    </tbody>

                                </table>
                                <div class="pagination">
                                    {{ $var['histories']->links('vendor.pagination.default') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@stop