<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://coco-factory.jp/ugokuweb/wp-content/themes/ugokuweb/data/6-1-7/js/6-1-7.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="{{url('/')}}/ws_assets/js/progress.js"></script>
<script src="{{url('/')}}/ws_assets/js/jQuery.js"></script>
<script src="{{url('/')}}/ws_assets/js/main.js"></script>
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/additional-methods.min.js"></script>
<script src="{{url('/')}}/ws_assets/custom/toastr/build/toastr.min.js"></script>
<script src="{{url('/')}}/ws_assets/custom/custom.js"></script>
<script src="{{url('/')}}/ws_assets/custom/jquery.blockUI.js"></script>
<script src="{{url('/')}}/ws_assets/plugins/photoswipe/photoswipe.min.js"></script>
<script src="{{url('/')}}/ws_assets/plugins/photoswipe/photoswipe-ui-default.min.js"></script>
<script src="{{url('/')}}/ws_assets/plugins/photoswipe/jqPhotoSwipe.min.js"></script>
<script>
    // You can also pass an optional settings object
    // below listed default settings
    AOS.init({
        // Global settings:
        disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
        startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
        initClassName: 'aos-init', // class applied after initialization
        animatedClassName: 'aos-animate', // class applied on animation
        useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
        disableMutationObserver: false, // disables automatic mutations' detections (advanced)
        debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
        throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


        // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
        offset: 120, // offset (in px) from the original trigger point
        delay: 0, // values from 0 to 3000, with step 50ms
        duration: 700, // values from 0 to 3000, with step 50ms
        easing: 'ease', // default easing for AOS animations
        once: true, // whether animation should happen only once - while scrolling down
        mirror: false, // whether elements should animate out while scrolling past them
        anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

    });

    $('.carousel-slide').slick({
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: true,
        autoplaySpeed: 2000,
        dots:true,
        centerMode: true,
        responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                centerMode: true,

            }

        }, {
            breakpoint: 1000,
            settings: {
                slidesToShow:2,
                slidesToScroll: 3,
                dots: true,
                infinite: false,

            }
        },  {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: true,
                infinite: true,
                autoplay: true,
                autoplaySpeed: 2000,
            },

        },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                },

            }]
    });

    function getChildren(select, child, route) {
        $.ajax({
            url: route,
            data: {id: select.val(), _token: '{{csrf_token()}}'},
            type: "POST",
            beforeSend() {
                blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
            },
            success: function (data) {
                if (data.success) {
                    $(select).parents('form').find(child).html(data.page);
                } else {
                    showAlertMessage('error', '@lang('constants.unknown_error')');
                }
                unblockPage();
            },
            error: function (data) {
                console.log(data);
            },
        });
    }

    function showModal(id,modal_id,url){
        $.ajax({
            url : url,
            data : {'id':id, '_token': '{{csrf_token()}}'},
            type: "POST",
            beforeSend(){
                blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
            },
            success:function(data) {
                if (data.success) {
                    $('#'+modal_id).html(data.page).modal('show', {backdrop: 'static', keyboard: false});
                } else {
                    showAlertMessage('error', '@lang('constants.unknown_error')');
                }
                unblockPage();
            },
            error:function(data) {
                unblockPage();
            } ,
            statusCode: {
                500: function(data) {
                    unblockPage();
                }
            }
        });
    }

    @if(session('success'))
        showAlertMessage('success', '{{session('success')}}');
    @elseif(session('error'))
        showAlertMessage('error', '{{session('error')}}');
    @elseif(session('warning'))
        showAlertMessage('warning', '{{session('warning')}}');
    @endif

    $(document).on('submit', 'form', function (event) {
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
    });
</script>
@yield('js')
</body>

</html>
