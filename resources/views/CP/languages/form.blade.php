<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route($module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="name_en">@lang($module.'.name_en') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="text" name="name[en]" id="name_en" class="form-control" placeholder="@lang($module.'.name_en')" @if($record) value="{{$record->getTranslation('name', 'en')}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="name_en_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="name_ar">@lang($module.'.name_ar') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="text" name="name[ar]" id="name_ar" class="form-control" placeholder="@lang($module.'.name_ar')" @if($record) value="{{$record->getTranslation('name', 'ar')}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="name_ar_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
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
            'name[en]': {
                required: true,
            },
            'name[ar]': {
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

    $('.submit_btn').click(function(e){
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;

        postData(new FormData($('#add_edit_form').get(0)), '{{route($module.'.add_edit')}}');
    });

</script>
