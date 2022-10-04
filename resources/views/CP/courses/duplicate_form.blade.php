<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">@lang($module.'.duplicate')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group col-12">
                    <div class="row">
                        <label class="col-12" for="phase_id">@lang($module.'.phase_id') <span class="text-danger">*</span></label>
                        <div class="col-12">
                            <select name="phase_id" id="phase_id" class="selectpicker form-control" data-live-search="true">
                                <option selected value="">--</option>
                                @foreach($phases as $item)
                                    <option value="{{$item->id}}">{{$item->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 text-danger" id="phase_id_error"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('constants.cancel')</button>
            <button type="button" class="btn btn-primary submit_btn">@lang($module.'.duplicate')</button>
        </div>
    </div>
</div>
<script>
    $('#add_edit_form').validate({
        rules: {
            phase_id: {
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
    $('.selectpicker').selectpicker();

    $('.submit_btn').click(function(e){
        Swal.fire({
            title: '@lang($module.'.duplicate')',
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
                    url: '{{route($module.'.duplicate', ['id' => $id])}}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'phase_id': $('#phase_id').val()
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
                        if (data.success) {
                            $('#page_modal').modal('hide');
                            $('#items_table').DataTable().ajax.reload(null, false);
                            showAlertMessage('success', data.message);
                        } else {
                            showAlertMessage('error', '@lang('constants.unknown_error')');
                        }
                        KTApp.unblockPage();
                    },
                    error: function (data) {
                        KTApp.unblockPage();
                    },
                });
            }
        });
    });

</script>
