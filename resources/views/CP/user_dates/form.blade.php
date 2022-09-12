<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('users.'.$module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-md-12" for="date">@lang($module.'.date') <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" class="form-control my-daterangepicker-time" name="date" id="date" placeholder="@lang($module.'.date')" @if($record) value="{{\Carbon\Carbon::parse($record->date_from)->format('Y-m-d H:i')}} - {{\Carbon\Carbon::parse($record->date_to)->format('Y-m-d H:i')}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="date_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="user_id" value="{{$parent->id}}">
                @if($record)
                    <input type="hidden" name="id" value="{{$record->id}}">
                @endif
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('constants.cancel')</button>
                <button type="button" class="btn btn-primary submit_btn">@lang('constants.submit')</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#add_edit_form').validate({
        rules: {
            date: {
                required: true,
            },
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        errorPlacement: function (error, element) {
            $(element).addClass("is-invalid");
            $(element).parents('.dropdown.bootstrap-select.form-control').addClass("is-invalid");
            error.appendTo('#' + $(element).attr('id') + '_error');
        },
        success: function (label, element) {
            $(element).removeClass("is-invalid");
            $(element).parents('.dropdown.bootstrap-select.form-control').removeClass("is-invalid");
        }
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

    $('.submit_btn').click(function(e){
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;

        postData(new FormData($('#add_edit_form').get(0)), '{{route('users.'.$module.'.add_edit')}}');
    });

</script>
