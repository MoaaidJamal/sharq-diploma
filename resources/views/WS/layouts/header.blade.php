<!DOCTYPE html>
<html lang="{{locale()}}">

<head>
    <meta charset="UTF-8"/>
    <title>Al-Sharq - @yield('title')</title>
    <link rel="icon" href="{{url('assets/images/icon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;600;700&family=Raleway:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"
          integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
          integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="{{url('/')}}/ws_assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="{{url('/')}}/ws_assets/css/main.css" rel="stylesheet"/>
    <link href="{{url('/')}}/ws_assets/css/media.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/custom/toastr/build/toastr.min.css">
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/custom/custom.css">
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/plugins/photoswipe/photoswipe.css">
    <style>
        .pswp__button,
        .pswp__button--arrow--left:before,
        .pswp__button--arrow--right:before {
            background: url({{url('/')}}/ws_assets/plugins/photoswipe/default-skin/default-skin.png) 0 0 no-repeat;
            background-size: 264px 88px;
            width: 44px;
            height: 44px;
        }

        .pswp__preloader--active .pswp__preloader__icn {
            /* We use .gif in browsers that don't support CSS animation */
            background: url({{url('/')}}/ws_assets/plugins/photoswipe/default-skin/preloader.gif) 0 0 no-repeat; }

        .pswp__bg {
            opacity: 0.8 !important;
        }

        @media (-webkit-min-device-pixel-ratio: 1.1), (-webkit-min-device-pixel-ratio: 1.09375), (min-resolution: 105dpi), (min-resolution: 1.1dppx) {
            /* Serve SVG sprite if browser supports SVG and resolution is more than 105dpi */
            .pswp--svg .pswp__button,
            .pswp--svg .pswp__button--arrow--left:before,
            .pswp--svg .pswp__button--arrow--right:before {
                background-image: url({{url('/')}}/ws_assets/plugins/photoswipe/default-skin/default-skin.svg);
            }

            .pswp--svg .pswp__button--arrow--left,
            .pswp--svg .pswp__button--arrow--right {
                background: none;
            }
        }

        @if(locale() == 'ar')
            .rtl {
                text-align: right;
                direction: rtl;
            }

            . * {
                text-align: right;
                direction: rtl;
            }
        @endif
    </style>
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/plugins/photoswipe/default-skin.css">
    @yield('style')
</head>
<body>
