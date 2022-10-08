@extends('WS.layouts.min_main')

@section('title') @lang('ws.forget_password') @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/main.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/quiz.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/media.css" rel="stylesheet" />
@endsection

@section('body')


    <div class="loginBodySec forgetPassBody">
        <div class="loginBodySecImg" style="background-image: url('{{url('/')}}/ws_assets/images/bglogin.png')"></div>
        <div class="loginPageBody">
            <form action="{{route('ws.forget_password_post')}}" class="loginForm loginPageForm" method="POST" id="form">
                @csrf
                <div class="loginLogo">
                    <img src="{{url('/')}}/ws_assets/images/loginLogo.png" alt="">
                </div>
                <div class="loginTitle">
                    <h6>@lang('ws.reset_password')</h6>
                    <p>
                        @lang('ws.reset_password_desc')
                    </p>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="E-mail address">
                    <div class="text-danger" id="email_error"></div>
                </div>

                <button type="submit" class="signBtn btn loginBtns loginLink"> <span>@lang('ws.reset_password')</span></button>

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
