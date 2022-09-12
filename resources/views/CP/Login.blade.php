<!DOCTYPE html>
<html lang="{{locale()}}" @if(isRTL()) direction="rtl" dir="rtl" style="direction: rtl" @endif>

<head>
    <base href="{{localURL('/')}}">
    <meta charset="utf-8"/>
    <title>@lang('constants.signInBtn')</title>
    <meta name="description" content="Login page"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link href="{{url("/")}}/assets/css/pages/login/classic/login-4.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/global/plugins.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/css/style.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link rel="icon" href="{{url('assets/images/icon.png')}}">

    @if(isRTL())
        <link href="{{url("/")}}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/skin.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/skin.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/skin.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/skin.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.inline.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.inline.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/global/fonts/keenthemes-icons/ki.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/leaflet/leaflet.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/cropper/cropper.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/uppy/uppy.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/kanban/kanban.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/jqvmap/jqvmap.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/jstree/jstree.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/prismjs/prismjs.bundle.rtl.css" rel="stylesheet" type="text/css"/>
    @endif

    <style>
        .zoom:hover {
            transform: scale(3);
        }

        .zoom {
            transition: transform .2s; /* Animation */
        }

        @if(locale() == 'ar')
            @font-face {
            font-family: "ns";
            src: url('{{url('/')}}/assets/fonts/Tajawal-Regular.ttf');
            font-weight: normal;
            font-style: normal;
        }

        * {
            font-family: "ns";
        }

        h1, h2, h3, h4, h5, h6, label {
            font-family: "ns";
        }

        @else
            * {
            font-family: 'Poppins';
        }

        h1, h2, h3, h4, h5, h6, label {
            font-family: 'Poppins';
        }
        @endif

    </style>
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled page-loading">

<div class="d-flex flex-column flex-root">
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{url('/')}}/assets/media/bg/bg-3.jpg');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <div class="d-flex flex-center mb-15">
                    <a href="javascript:;">
                        <img src="{{url('assets/images/logo.svg')}}" style="width: 300px;"/>
                    </a>
                </div>
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>@lang('constants.signIn')</h3>
                    </div>
                    @if (session('validationErr'))
                        <div class="alert alert-danger">
                            {{ session('validationErr') }}
                        </div>
                    @endif
                    <form id="login_form" action="{{route('admin.login')}}" method="post">
                        @csrf
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="@lang('constants.email')" name="email" autocomplete="off"/>
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="@lang('constants.password')" name="password" autocomplete="off"/>
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <label class="checkbox m-0 text-muted">
                                <input type="checkbox" name="remember" value="1"/>@lang('constants.remember')
                                <span></span>
                            </label>
                        </div>
                        <button class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">@lang('constants.signInBtn')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<script src="{{url("/")}}/assets/plugins/global/plugins.bundle.js?v=7.0.4"></script>
<script src="{{url("/")}}/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4"></script>
<script src="{{url("/")}}/assets/js/scripts.bundle.js?v=7.0.4"></script>
<script>

</script>
</body>
</html>
