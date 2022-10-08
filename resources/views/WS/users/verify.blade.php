@extends('WS.layouts.min_main')

@section('title') Set password @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/style_login.css" rel="stylesheet" />
@endsection

@section('body')
    <div class="loginBodySec forgetPassBody">
        <div class="loginBodySecImg" style="background-image: url('{{url('/')}}/ws_assets/images/bglogin.png')"></div>
        <div class="loginPageBody">
            <form action="{{route('ws.users.verify_post')}}" class="loginForm loginPageForm" method="POST" id="form">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <div class="loginLogo">
                    <img src="{{url('/')}}/ws_assets/images/loginLogo.png" alt="">
                </div>
                <div class="loginTitle">
                    <h6>Welcome to Al-Sharq Followship Program</h6>
                    <p>Please set your account password below</p>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" readonly style="background-color: #dcdcdc">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password">
                    <div class="text-danger" id="password_error"></div>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                    <div class="text-danger" id="password_confirmation_error"></div>
                </div>
                <button type="submit" class="signBtn btn loginBtns loginLink"> <span>Set Password</span></button>
            </form>
        </div>

    </div>

@endsection
@section('js')
<script>
    $('#form').validate({
        rules: {
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                required: true,
                equalTo: '#password',
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
