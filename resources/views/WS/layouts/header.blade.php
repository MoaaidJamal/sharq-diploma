<!DOCTYPE html>
<html lang="{{locale()}}">

<head>
    <meta charset="UTF-8"/>
    <title>Al-Sharq - @yield('title')</title>
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <link rel="icon" href="{{url('assets/images/icon.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('seo_description')">
    <meta name="author" content="@yield('seo_author')">
    <link href="{{url('/')}}/ws_assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">
    <link rel="shortcut icon" href="{{url('/')}}/assets/images/icon.png">
    <link href="{{url('/')}}/ws_assets/css/owl.carousel.css" rel="stylesheet">
    <link href="{{url('/')}}/ws_assets/css/owl.carousel.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">
    <link href="{{url('/')}}/ws_assets/lib/rating/css/star-rating-svg.css" rel="stylesheet">
    <link href="{{url('/')}}/ws_assets/css/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <link href="{{url('/')}}/ws_assets/css/selectric.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/custom/toastr/build/toastr.min.css">
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/custom/custom.css">
    <script type="text/javascript" src="{{url('/')}}/ws_assets/js/jquery.js"></script>
    @yield('style')
    <link href="{{url('/')}}/ws_assets/css/style{{locale()=='ar'?'Ar':''}}.css" rel="stylesheet">
</head>
<body>
