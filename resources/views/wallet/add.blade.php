@extends('layout')

@section('content')
    <div class="header-navigate clearfix mb15">
       <div class="container">
          <div class="row">
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd5">
                <ol class="breadcrumb breadcrumb-arrow">
                   <li><a href="{{ route('home') }}" target="_self">Trang chủ</a></li>
                   <li><i class="fa fa-angle-right"></i></li>
                   <li>Nạp ví</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <section id="collection" class="clearfix">
       <div class="container">
          <div class="row">             
             <div class="box_wallet col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row">
                   <div class="col-xs-12 pd5">
                      <div class="group-collection mb15">
                         <div class="title-block">
                            <h1 class="title-group">
                               Nạp ví
                            </h1>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row wallet clearfix" id="event-grid">
                    <div class="box_user">
                        <p>Thông tin tài khoản</p>
                        <div>
                            <p>Họ tên : <span>{{ $var['user']->name_full }}</span> </p>
                            <p>Ví : <span>{{ number_format($var['user_wallet']->xu) }}</span><a class="history" href="{{ route('user.wallet.history') }}"> (Xem lịch sử ví)</a></p>
                        </div>                        
                    </div> 
                    <div class="box_wallet">
                        <form accept-charset='UTF-8' action='{{ route('user.wallet.addPost') }}' class='contact-form' method='post'>
                                {{ csrf_field() }}    
                                <div class="clearfix">
                                        <div class="col-sm-12 col-xs-12 box-input">
                                           <div class="col-md-3">
                                                Nhập mã code
                                           </div>
                                            <div class="col-md-4">
                                                    <div class="input-group">                                                
                                                        <input type="text" name="code" class="form-control" placeholder="mã code" aria-describedby="basic-addon1">
                                                    </div>
                                            </div>                                       
                                        </div>
                                        <div class="col-sm-12 col-xs-12 box-submit">
                                             <div class="col-md-3">
                                                   
                                              </div>
                                              <div class="col-md-4" style="text-align: center;">
                                                   <button>
                                                         Xác nhận
                                                   </button>
                                              </div>                                             
                                        </div>  
                                        <div class="col-sm-12 col-xs-12 box-note">
                                             <p>Chú ý : </p>
                                             <ul>
                                                <li>Nhập sai mã code 5 lần liên tiếp tài khoản của bạn sẽ bị khóa</li>
                                             </ul>
                                        </div>
                                </div>
                        </form>
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