<div class="modal fade" id="registerModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">              
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="login">
            <div class="title">Đăng ký</div>
            <div class="box-social">
                <div class="title-social">Đăng ký với tài khoản</div>  
                <div class="box-icon">
                    <a href="{{ route('login.facebook') }}" class="login-fb">
                      <img src="{{ web_asset('public/images/icon_fb.png') }}" />
                      Facebook
                  </a>
                  <a href="{{ route('auth.gglogin') }}" class="login-gg">
                      <img src="{{ web_asset('public/images/icon_gg.png') }}" />
                      Google
                  </a>
              </div>
              <div class="login-or">Hoặc đăng ký bằng</div>
          </div>
          <form class="form" role="form" autocomplete="off" id="formRegister"  method="POST">
            <div class="form-group">
                <label for="uname1">Email</label>
                <input type="text" class="form-control form-control-lg rounded-0" name="email" required="">
            </div>
                            {{-- <div class="form-group">
                                    <label for="uname1">Tên tài khoản</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="name" required="">
                                </div> --}}
                            {{-- <div class="form-group">
                                    <label for="uname1">Họ tên</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="full_name" required="">
                                </div> --}}
                                <div class="form-group">
                                    <label>Mật khẩu</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" required="" autocomplete="new-password">
                                    
                                </div>  
                                <div class="form-group">
                                    <label>Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password_confirmation" required="" autocomplete="new-password">
                                    
                                </div>                         
                                <div class="box-action">
                                    <label class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input">
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description small text-dark">Đồng ý với điều khoản</span>
                                  </label>
                                  <button type="submit" class="btn btn-success btn-lg float-right" id="btnRegister">Đăng ký</button>
                              </div>                                
                              
                          </form>
                          @include('include.loadding')
                          <div class="register-now">
                            <span>Bạn đã có tài khoản? </span><a href="#" class="login-redirect">Đăng nhập ngay</a>
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
