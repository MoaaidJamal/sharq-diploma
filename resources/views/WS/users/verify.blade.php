@extends('WS.layouts.min_main')

@section('title') Set password @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/style_login.css" rel="stylesheet" />
@endsection

@section('body')
<section style="height: 100vh;" data-aos="fade-down">
    <div class="container d-flex justify-content-between align-items-center flex-wrap h-100">
        <!-- left box -->
        <div class="col-12 col-lg-6 left-box">
            <div class="d-flex flex-column justify-content-center">
                <div class="col-12 col-sm-4 logo"><img src="{{url('/')}}/assets/images/logo.svg" alt=""/></div>
                <div class="login-img col-sm-11"><img src="{{url('/')}}/ws_assets/images/auth/login.png" alt=""/></div>
            </div>
        </div>
        <!-- end left box -->

        <!-- rigth box -->
        <div class="col-12 col-lg-6 d-flex justify-content-center">
            <div class="d-flex flex-column right-box justify-content-center">
                <h2 class="font-inter font-bold700">Welcome to Al-Sharq Followship Program</h2>
                <p class="font-inter font-bold700">Please set your account password below</p>
                <form action="{{route('ws.users.verify_post')}}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label font-inter font-bold700">Email</label>
                        <div class="input-group mb-3" style="background: #EEEEEE;">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control font-inter small-text" name="email" id="email" aria-describedby="emailHelp" value="{{$user->email}}" readonly>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label font-bold700 font-inter">Password</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img src="{{url('/')}}/ws_assets/images/auth/Vector.svg" alt=""/></span>
                            <input type="password" class="form-control" name="password" placeholder="Password" id="password" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="text-danger" id="password_error"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password_confirmation" class="form-label font-inter font-bold700">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><img src="{{url('/')}}/ws_assets/images/auth/Vector.svg" alt=""/></span>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="text-danger" id="password_confirmation_error"></div>
                    </div>
                    <button type="submit" class="btn w-100 font-inter font-bold700 setpass">Set Password</button>
                </form>
            </div>
        </div>
        <!-- end right box -->
    </div>
</section>
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
