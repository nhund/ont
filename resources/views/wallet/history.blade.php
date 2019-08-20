@extends('layout')

@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li>Lịch sử ví</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="collection" class="clearfix">
       <div class="container">
          <div class="row">             
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                   <div class="col-xs-12 pd5">
                      <div class="group-collection mb15">
                         <div class="title-block">
                            <h1 class="title-group">
                                Lịch sử dùng ví
                            </h1>                            
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row product-lists product-item box-product-lists clearfix " id="event-grid">
                        <table class="table table-bordered table-hover table-responsive table-customize">          
                                <thead>
                                  <tr>
                                    {{-- <th>STT</th> --}}
                                    <th>Họ tên</th>
                                    <th>Tài khoản trước giao dịch</th>
                                    <th>Số tiền thay đổi</th>
                                    <th>Loại giao dịch</th>
                                    <th>Ghi chú</th>
                                    <th>Ngày giao dịch</th>
                                  </tr>
                                </thead>
                                <tbody>
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
                                                
                                </tbody>
                        </table>

                        <div class="clearfix loadmore clear-ajax">
                                <div class="paginations">
                                    {{ $var['histories']->links('vendor.pagination.default') }}
                                </div>
                        </div>
                </div>
             </div>
          </div>
       </div>
    </section>    
@stop
@push('js')
    {{-- <script src='{{ web_asset('public/js/list/list.js') }}?v=1' type='text/javascript'></script> --}}
@endpush