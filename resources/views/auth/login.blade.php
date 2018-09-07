@extends('layouts.app')

@section('content')
    <section class="height-100vh d-flex align-items-center page-section-ptb login" style="background-image: url({{ asset('images/login-bg.jpg') }});">
        <div class="container">
            <div class="justify-content-center no-gutters vertical-align row">
                <div class="login-fancy-bg bg col-md-6 col-lg-4" style="background-image: url({{ asset('images/login-inner-bg.jpg') }});">
                    <div class="login-fancy">
                        <h2 class="text-white mb-20">{{ __('Cầm Đồ Cà Mau') }}</h2>
                        <p class="mb-20 text-white">Chào mừng đến với hệ thống quản lý cầm đồ cà mau.</p>
                        <ul class="list-unstyled  pos-bot pb-30">
                            <li class="list-inline-item"><a class="text-white" href="#">{{ __('Điều khoản dịch vụ') }}</a> </li>
                            <li class="list-inline-item"><a class="text-white" href="#">{{ __('Chính sách bảo mật') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white col-md-6 col-lg-4">
                    <div class="login-fancy pb-40 clearfix">
                        <h3 class="mb-30">{{ __('Đăng nhập vào Cầm Đồ Cà Mau') }}</h3>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="section-field mb-20{{ $errors->has('email') ? ' is-invalid' : '' }}">
                                <label class="mb-10" for="name">{{ __('Địa chỉ email') }} <span class="text-danger">(*)</span></label>
                                <input id="email" class="web form-control" type="text" placeholder="Ex: user01@example.com" name="email" value="{{ old('email') }}">
                                <div class="col s12 row">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="section-field mb-20{{ $errors->has('password') ? ' is-invalid' : '' }}">
                                <label class="mb-10" for="Password">{{ __('Mật khẩu') }} <span class="text-danger">(*)</span></label>
                                <input id="password" class="Password form-control" type="password" placeholder="Ex: 12345678@Ab" name="password" value="{{ old('password') }}">
                                <div class="col s12 row">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="section-field">
                                <div class="remember-checkbox mb-30">
                                    <input type="checkbox" class="form-control" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label for="remember"> {{ __('Ghi nhớ đăng nhập') }}</label>
                                </div>
                            </div>
                            <p class="mb-15 remember-checkbox"><a href="{{ route('password.request') }}"> {{ __('Quên mật khẩu') }}</a></p>
                            <button class="button button-login">
                                <i class="fa fa-check text-white"></i>
                                <span class="text-white">{{ __('ĐĂNG NHẬP') }}</span>
                            </button>
                            <p class="mt-15 mb-0 remember-checkbox">{{ __('Chưa có tài khoản') }}? <a href="{{ route('register') }}"> {{ __('Tạo tài khoản mới') }} </a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
