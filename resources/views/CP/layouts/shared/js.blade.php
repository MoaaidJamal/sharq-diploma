<script>
    function showModal(url, callback = null){
        $.ajax({
            url : url,
            type: "GET",
            beforeSend(){
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
            },
            success:function(data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        $('#page_modal').html(data.page).modal('show', {backdrop: 'static', keyboard: false});
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    KTApp.unblockPage();
                }
            },
            error:function(data) {
                KTApp.unblockPage();
            },
        });
    }

    function showAlertMessage(type, message) {
        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        if(type === 'success') {
            toastr.success(message);
        } else if(type === 'warning') {
            toastr.warning(message);
        } else if(type === 'error' || type === 'danger') {
            toastr.error(message);
        } else {
            toastr.info(message);
        }
    }

    function change_status(id, url, status = null, callback = null) {
        $.ajax({
            url: url,
            data: {id: id, status: status, _token: '{{csrf_token()}}'},
            type: "POST",
            beforeSend(){
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
            },
            success: function (data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        showAlertMessage('success', data.message);
                        $('#items_table').DataTable().ajax.reload(null, false);
                    } else {
                        showAlertMessage('error', data.message);
                    }
                    KTApp.unblockPage();
                }
            },
            error: function (data, textStatus, jqXHR) {
                console.log(data);
            },
        });
    }

    function file_input(selector, options) {
        let defaults  = {
            theme: "fas",
            showDrag: false,
            deleteExtraData: {
                '_token': '{{csrf_token()}}',
            },
            browseClass: "btn btn-info",
            browseLabel: "@lang('constants.browse')",
            browseIcon: "<i class='la la-file'></i>",
            removeClass: "btn btn-danger",
            removeLabel: "@lang('constants.delete')",
            removeIcon: "<i class='la la-trash-o'></i>",
            showRemove: false,
            showCancel: false,
            showUpload: false,
            showPreview: true,
            msgPlaceholder: "@lang('constants.select_files') {files}...",
            msgSelected: "@lang('constants.selected') {n} {files}",
            fileSingle: "@lang('constants.one_files')",
            filePlural: "@lang('constants.multi_files')",
            dropZoneTitle: "@lang('constants.drag_drop_files_here') &hellip;",
            msgZoomModalHeading: "@lang('constants.file_details')",
            dropZoneClickTitle: '<br>(@lang('constants.click_to_browse'))',
            initialPreview: [],
            initialPreviewShowDelete: false,
            initialPreviewAsData: true,
            initialPreviewConfig: [],
            initialPreviewFileType: 'image',
            overwriteInitial: true,
            browseOnZoneClick: true,
            @if(locale() == 'ar')
                rtl: true,
            @endif
        };
        let settings = $.extend( {}, defaults, options );
        $(selector).fileinput(settings);
    }

    function getChildren(select, child, route, model = '', callback = null) {
        $.ajax({
            url: route,
            data: {id: select.val(), _token: '{{csrf_token()}}'},
            type: "POST",
            beforeSend() {
                if (model) {
                    KTApp.block(model, {
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                } else {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                }
            },
            success: function (data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        $(child).html(data.page);
                        $(child).selectpicker('refresh');
                    } else {
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    }
                    if (model) {
                        KTApp.unblock(model);
                    } else {
                        KTApp.unblockPage();
                    }
                }
            },
            error: function (data) {
                console.log(data);
            },
        });
    }

    function delete_items(id, url, callback = null) {
        let data = [];
        if (id) {
            data = [id];
        } else {
            if ($('input.select:checked').length > 0) {
                $.each($("input.select:checked"), function () {
                    data.push($(this).val());
                });
            }
        }
        if (data.length <= 0) {
            showAlertMessage('error', '@lang('constants.noSelectedItems')');
        } else {
            Swal.fire({
                title: data.length === 1 ? '@lang('constants.deleteItem')' : '@lang('constants.delete') ' + data.length + ' @lang('constants.items')',
                text: "@lang('constants.sure')",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#84dc61',
                cancelButtonColor: '#d33',
                confirmButtonText: '@lang('constants.yes')',
                cancelButtonText: '@lang('constants.no')'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'ids': data
                        },
                        beforeSend(){
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: '@lang('constants.please_wait') ...'
                            });
                        },
                        success: function (data) {
                            if (callback && typeof callback === "function") {
                                callback(data);
                            } else {
                                if (data.success) {
                                    $('#items_table').DataTable().ajax.reload(null, false);
                                    showAlertMessage('success', data.message);
                                } else {
                                    showAlertMessage('error', '@lang('constants.unknown_error')');
                                }
                                KTApp.unblockPage();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }
            });
        }
    }

    function postData(data, url, callback = null){
        $.ajax({
            url : url,
            data : data,
            type: "POST",
            processData: false,
            contentType: false,
            beforeSend(){
                KTApp.block('#page_modal', {
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
            },
            success:function(data) {
                if (callback && typeof callback === "function") {
                    callback(data);
                } else {
                    if (data.success) {
                        $('#page_modal').modal('hide');
                        $('#items_table').DataTable().ajax.reload(null, false);
                        showAlertMessage('success', data.message);
                    } else {
                        if (data.message) {
                            showAlertMessage('error', data.message);
                        } else {
                            showAlertMessage('error', '@lang('constants.unknown_error')');
                        }
                    }
                    KTApp.unblock('#page_modal');
                }
                KTApp.unblockPage();
            },
            error:function(data) {
                console.log(data);
                KTApp.unblock('#page_modal');
                KTApp.unblockPage();
            },
        });
    }

    $.fn.datetimepicker.dates['ar'] = {
        days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
        daysShort: ["أح", "اث", "ثلا", "أر", "خم", "جم", "سب", "أح"],
        daysMin: ["أح", "اث", "ثلا", "أر", "خم", "جم", "سب", "أح"],
        months: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        monthsShort: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        meridiem: '',
        today: "اليوم",
        clear: "إلفاء"
    };

    $.fn.datepicker.dates['ar'] = {
        days: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت", "الأحد"],
        daysShort: ["أح", "اث", "ثلا", "أر", "خم", "جم", "سب", "أح"],
        daysMin: ["أح", "اث", "ثلا", "أر", "خم", "جم", "سب", "أح"],
        months: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        monthsShort: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"],
        today: "اليوم"
    };

    $('.my-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        language: '{{locale()}}'
    });

    $('.my-dob-datepicker').datepicker({
        format: 'yyyy-mm-dd',
        endDate: new Date(),
        language: '{{locale()}}'
    });

    $('.my-datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        language: '{{locale()}}'
    });

    $('.my-daterangepicker').daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        autoUpdateInput: false,
        locale: {
            format: 'YYYY-MM-DD',
            "applyLabel": '@lang('constants.apply')',
            "cancelLabel": "@lang('constants.cancel')",
            "fromLabel": "@lang('constants.from')",
            "toLabel": "@lang('constants.to')",
            "customRangeLabel": "@lang('constants.custom')",
            @if(locale() == 'ar')
                "daysOfWeek": [
                    "أح",
                    "اث",
                    "تلا",
                    "أر",
                    "خم",
                    "جم",
                    "سب"
                ],
                "monthNames": [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "ابريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
            @endif
        },
    });

    $('.my-daterangepicker').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('.my-daterangepicker').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $('.my-daterangepicker-time').daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm',
            "applyLabel": '@lang('constants.apply')',
            "cancelLabel": "@lang('constants.cancel')",
            "fromLabel": "@lang('constants.from')",
            "toLabel": "@lang('constants.to')",
            "customRangeLabel": "@lang('constants.custom')",
            @if(locale() == 'ar')
            "daysOfWeek": [
                "أح",
                "اث",
                "تلا",
                "أر",
                "خم",
                "جم",
                "سب"
            ],
            "monthNames": [
                "يناير",
                "فبراير",
                "مارس",
                "ابريل",
                "مايو",
                "يونيو",
                "يوليو",
                "أغسطس",
                "سبتمبر",
                "أكتوبر",
                "نوفمبر",
                "ديسمبر"
            ],
            @endif
        },
    });

    $('.my-daterangepicker-time').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD HH:mm') + ' - ' + picker.endDate.format('YYYY-MM-DD HH:mm'));
    });

    $('.my-daterangepicker-time').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    $(function () {
        $('input').attr('autocomplete', 'off');
    });

    let isMobile = false;
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
    }
    if(!isMobile){
        $('#items').on('show.bs.dropdown', function () {
            $('.dataTables_scrollBody').addClass('dropdown-visible');
        }).on('hide.bs.dropdown', function () {
            $('.dataTables_scrollBody').removeClass('dropdown-visible');
        });
    }

    CKEDITOR.on('instanceReady', function () {
        $.each(CKEDITOR.instances, function (instance) {
            CKEDITOR.instances[instance].document.on("keyup", CK_jQ);
            CKEDITOR.instances[instance].document.on("paste", CK_jQ);
            CKEDITOR.instances[instance].document.on("keypress", CK_jQ);
            CKEDITOR.instances[instance].document.on("blur", CK_jQ);
            CKEDITOR.instances[instance].document.on("change", CK_jQ);
        });
    });

    function CK_jQ() {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }

    $(document).on('click', 'input#selectAll', function () {
        if ($(this).prop('checked') == false) {
            $('input.select').prop('checked', false);
        } else {
            $('input.select').prop('checked', true);
        }
    });

    function check_collapse() {
        let label = '';
        if ($('#collapseExample').hasClass('show')) {
            label = '<i class="flaticon-search"></i> @lang("constants.showSearch")';
            $('#btn_show_search_box').html(label);
        } else {
            label = '<i class="flaticon-search"></i> @lang("constants.hideSearch")';
            $('#btn_show_search_box').html(label);
        }
    }

    $(document).on('keydown', 'input[type=number]', function() {
        if (parseInt($(this).val()) > parseInt($(this).attr('max'))) $(this).val($(this).attr('max'));
        if (parseInt($(this).val()) < parseInt($(this).attr('min'))) $(this).val($(this).attr('min'));
    });

    $(document).on('keyup', 'input[type=number]', function() {
        if (parseInt($(this).val()) > parseInt($(this).attr('max'))) $(this).val($(this).attr('max'));
        if (parseInt($(this).val()) < parseInt($(this).attr('min'))) $(this).val($(this).attr('min'));
    });

    $('.selectpicker').selectpicker();

    @if(session('success'))
        showAlertMessage('success', '{{session('success')}}');
    @elseif(session('error'))
        showAlertMessage('error', '{{session('error')}}');
    @endif

    function copyToClipboard(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
