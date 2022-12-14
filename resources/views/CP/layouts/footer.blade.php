
<script>var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
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
<script src="{{url("/")}}/assets/js/axios.js"></script>
<script src="{{url("/")}}/assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4"></script>
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/jquery.validate.min.js"></script>
@if(locale() != 'en')
    <script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/localization/messages_{{locale()}}.min.js" type="text/javascript"></script>
@endif
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/additional-methods.min.js"></script>
<script src="{{url('/')}}/assets/plugins/ckeditor/ckeditor.js"></script>
<script src="{{url("/")}}/assets/plugins/ckeditor/adapters/jquery.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/plugins/fancybox/source/jquery.fancybox.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/plugins/tags-input/bootstrap-tagsinput.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/plugins/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="{{url("/")}}/assets/plugins/bootstrap-fileinput/fileinput-theme.js" type="text/javascript"></script>
@if(isRTL())
    <script src="{{url("/")}}/assets/plugins/i18n/defaults-ar_AR.js" type="text/javascript"></script>
@endif
@include('CP.layouts.shared.js')
@yield('js')
</body>
</html>
