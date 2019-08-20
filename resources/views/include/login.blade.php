<div class="modal fade" id="loginModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">              
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login">
          <div class="title">Đăng nhập</div>
          <div class="box-social">
            <div class="title-social">Đăng nhập với tài khoản</div>  
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
            <div class="login-or">Hoặc đăng nhập bằng</div>
          </div>
          <div id="formLogin" method="POST">
            <div class="form-group">
              <label for="uname1">Email</label>
              <input type="text" class="form-control form-control-lg rounded-0" name="email" required="">
            </div>
            <div class="form-group">
              <label>Mật khẩu</label>
              <input type="password" class="form-control form-control-lg rounded-0" name="password" required="" autocomplete="new-password">

            </div>                           
            <div class="box-action">
              <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description small text-dark">Lưu mật khẩu</span>
              </label>
              <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin">Đăng nhập</button>
            </div>                                
          </div>
          @include('include.loadding')
          <div class="forgot">
            <a href="javascript:void(0)">Quên mật khẩu</a>
          </div>
          <div class="register-now">
            <span>Bạn chưa có tài khoản? </span><a href="#" class="register-redirect">Đăng ký ngay</a>
          </div>
        </div>                
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
