@extends('frontend_tp3.layouts.master')
@section('head_css')
@endsection
@section('content')
    @include('frontend_tp.layouts.breadcrumb')
    @if (!auth()->user())

    <section class="auth-section">
      <h2>Đăng nhập</h2>
      <form method="POST" action="{{ route('front.login') }}">
          @csrf
          <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required="">
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group">
              <label for="password">Mật khẩu</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required="">
          </div>
          <div class="form-group">
              @if (Route::has('password.request'))
                  <a class="btn-link" href="{{ route('password.request') }}">
                      Quên mật khẩu?
                  </a>
              @endif
          </div>
          <div class="form-group">
              <button type="submit" class="btn btn-solid">Đăng nhập</button>
          </div>
          
      </form>
    </section>
  

@endif

           

@endsection
