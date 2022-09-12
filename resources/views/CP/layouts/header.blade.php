<!DOCTYPE html>
<html lang="{{locale()}}" @if(isRTL()) direction="rtl" dir="rtl" style="direction: rtl" @endif>

<head>
    <base href="{{localURL('/')}}">
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta name="description" content="Login page example"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{url("/")}}/assets/css/pages/login/classic/login-4.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{url("/")}}/assets/plugins/global/plugins.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/css/style.bundle.css?v=7.0.4" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/tags-input/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
    <link href="{{url("/")}}/assets/plugins/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="icon" href="{{url('assets/images/icon.png')}}">

    @if(isRTL())
        <link href="{{url("/")}}/assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/global/plugins.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/css/style.bundle.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/skin.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/skin.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/skin.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/skin.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide-dark/content.inline.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.mobile.min.rtl.css" rel="stylesheet" type="text/css"/>
        <link href="{{url("/")}}/assets/plugins/custom/tinymce/skins/ui/oxide/content.inline.min.rtl.css" rel="stylesheet" type="text/css"/>
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
            transform: scale(3); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
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

            .was-validated .form-control:invalid, .form-control.is-invalid {
                padding-right: 1rem;
            }

            .filter-option-inner-inner {
                text-align: right;
            }

        @else
            * {
                font-family: 'Poppins';
            }

            h1, h2, h3, h4, h5, h6, label {
                font-family: 'Poppins';
            }
        @endif

        td.dataTables_empty {
            text-align: center;
        }

        .dropdown-item.active, .dropdown-item:active > i {
            color: #fff;
        }

        .modal .modal-header .close span {
            display: block;
        }

        .header-menu .menu-nav > .menu-item.menu-item-here > .menu-link .menu-text > i, .header-menu .menu-nav > .menu-item.menu-item-active > .menu-link .menu-text > i {
            color: #3699FF;
            transition: all 0.3s ease;
        }

        .header-menu .menu-nav > .menu-item:hover:not(.menu-item-here):not(.menu-item-active) > .menu-link .menu-text > i, .header-menu .menu-nav > .menu-item.menu-item-hover:not(.menu-item-here):not(.menu-item-active) > .menu-link .menu-text > i {
            color: #3699FF;
            transition: all 0.3s ease;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .header-menu .menu-nav > .menu-item > .menu-link .menu-text {
            font-size: 1rem;
        }

        #items_table thead th {
            font-weight: bolder;
        }

        .bootstrap-timepicker-widget table td a {
            margin: auto;
        }

        .header .header-top {
            background-color: #F2F3F7;
        }

        .dataTables_info {
            text-align: right;
        }

        span.help-block.help-block-error {
            display: block;
            padding: 5px 0 0 5px;
        }
    </style>
    @yield('style')
</head>
