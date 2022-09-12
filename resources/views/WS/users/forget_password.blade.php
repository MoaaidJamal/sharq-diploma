@extends('WS.layouts.min_main')

@section('title') @lang('ws.forget_password') @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/main.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/quiz.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/media.css" rel="stylesheet" />
@endsection

@section('body')

    <header class="d-flex justify-content-center">
        <nav class="container navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="javascript:void(0);">
                    <img alt="img" src="{{url('/')}}/assets/images/logo.svg" style="margin-right: 20px;height: 60px; margin-top: -14px;" />
                </a>
            </div>
        </nav>
    </header>

    <div class="container-fluid reset-pass" style="background-color: #f7f5fa !important;">
        <div class="d-flex justify-content-center mt-0 py-5 h-100vh">
            <div class="col-10 col-lg-5 text-center p-0 mt-3 mb-2" data-aos="fade-down">
                <form action="{{route('ws.forget_password_post')}}" method="POST" id="form">
                    @csrf
                    <div>
                        <div class="d-flex flex-column mb-4">
                            <h2 class="font-inter font-bold700 small mb-4 font28">
                                @lang('ws.reset_password')
                            </h2>
                            <h3 class="font-inter font-bold700 small mb-4">
                                @lang('ws.reset_password_desc')
                            </h3>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label font-inter tc-gray-1">@lang('ws.enter_email')</label>
                                <input type="email" class="form-control font-inter small-text font-bold700" name="email" id="email" aria-describedby="basic-addon1">
                                <div class="text-danger" id="email_error"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="next" class="btn next action-button next-btn" value="Reset Password">@lang('ws.reset_password')</button>
                </form>
            </div>
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
