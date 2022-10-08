@extends('WS.layouts.min_main')

@section('title') @lang('ws.login') @endsection

@section('body')


    <div class="loginBodySec">
        <div class="loginBodySecImg" style="background-image: url('{{url('/')}}/ws_assets/images/bglogin.png')"></div>
        <div class="loginPageBody">
            <form action="{{route('ws.login_post')}}" class="loginForm loginPageForm" method="POST" id="form">
                @csrf
                <div class="loginLogo">
                    <img src="{{url('/')}}/ws_assets/images/loginLogo.png" alt="">
                </div>
                <div class="loginTitle"><h6>@lang('ws.welcome_to_fellowship')</h6><p></p></div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="@lang('ws.your_email')" value="{{old('email')}}">
                    <div class="text-danger" id="email_error"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="@lang('ws.password')" id="password">
                    <div class="text-danger" id="password_error"></div>
                </div>
                <a href="{{route('ws.forget_password')}}" class="forgetLink">
                    @lang('ws.forget_password')?
                </a>
                <button type="submit" class="signBtn btn loginBtns loginLink"> <span>@lang('ws.login')</span></button>
                <label class="loginCheck">
                    <input type="checkbox" checked="checked" value="1" name="remember">
                    <span class="checkmark"></span>
                    @lang('ws.keep_me_signed_in')
                </label>
            </form>
        </div>
    </div>


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
