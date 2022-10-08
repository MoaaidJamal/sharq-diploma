<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/owl.carousel.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/lib/rating/jquery.star-rating-svg.js"></script>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/jquery.selectric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/main{{locale()=='ar'?'Ar':''}}.js"></script>
<script type="text/javascript" src="{{url('/')}}/ws_assets/js/counter.js"></script>
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="{{url("/")}}/assets/plugins/custom/jquery-validation/dist/additional-methods.min.js"></script>
<script src="{{url('/')}}/ws_assets/custom/toastr/build/toastr.min.js"></script>
<script src="{{url('/')}}/ws_assets/custom/custom.js"></script>
<script src="{{url('/')}}/ws_assets/custom/jquery.blockUI.js"></script>
<script>

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
