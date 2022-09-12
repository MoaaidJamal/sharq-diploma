@extends('WS.layouts.min_main')

@section('title') @lang('ws.login') @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/style_login.css" rel="stylesheet" />
@endsection

@section('body')
<section style="height: 100vh;" class="overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap h-100">
        <div class="col-12 col-lg-5 d-flex justify-content-center login-box" data-aos="fade-down">
            <div class="d-flex flex-column left-box justify-content-center">
                <div class="col-12 col-sm-4 logo p-0 m-0"><img src="{{url('/')}}/assets/images/logo.svg"/></div>
                <h2 class="font-inter font-bold700 mb-49 tc-black-1">@lang('ws.welcome_to_fellowship')</h2>
                <form action="{{route('ws.login_post')}}" method="POST" id="form">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email" class="form-label font-bold700 font-inter tc-black-2">@lang('ws.your_email')</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                            <input type="email" class="form-control tc-gray-1" name="email" id="email" placeholder="@lang('ws.your_email')" value="{{old('email')}}" aria-describedby="basic-addon1">
                        </div>
                        <div class="text-danger" id="email_error"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label font-bold700 font-inter">@lang('ws.password')</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img src="{{url('/')}}/ws_assets/images/auth/Vector.svg" alt=""/></span>
                            <input type="password" class="form-control" name="password" placeholder="@lang('ws.password')" id="password" aria-label="Password" aria-describedby="basic-addon1">
                        </div>
                        <div class="text-danger" id="password_error"></div>
                    </div>
                    <button type="submit" class="btn w-100 font-inter font-bold700 btn-login">@lang('ws.login')</button>
                    <div class="mb-3 d-flex justify-content-between forget-password">
                        <div class="form-check my-3 my-lg-4 d-flex align-items-center login-check">
                            <input class="form-check-input" type="checkbox" value="1" name="remember" id="flexCheckChecked">
                            <label class="form-check-label font-bold700 font-inter s-small tc-gray" for="flexCheckChecked">
                                @lang('ws.keep_me_signed_in')
                            </label>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{route('ws.forget_password')}}" class="btn font-bold700 font-inter s-small tc-gray">@lang('ws.forget_password')?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-7 h-100 right-login">
            <div class="d-flex flex-column justify-content-center h-100 w-100 bg-login">
                <div class="login-img col-sm-11 d-flex flex-column justify-content-center align-items-center"><img src="{{url('/')}}/ws_assets/images/auth/loginC.svg"/></div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
    <script>
        $('#form').validate({
            rules: {
                email: {
                    required: true,
                },
                password: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error is-invalid',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                $(element).parents('.input-group').addClass("input-is-invalid");
                $(element).addClass("is-invalid");
                error.appendTo('#' + $(element).attr('id') + '_error');
            },
            success: function (label, element) {
                $(element).parents('.input-group').removeClass("input-is-invalid");
                $(element).removeClass("is-invalid");
            }
        });
    </script>
@endsection
