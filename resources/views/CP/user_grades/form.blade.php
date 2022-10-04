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
                    @if(auth()->user()->type == \App\Models\User::TYPE_ADMIN)
                        <div class="form-group col-lg-6 col-sm-12">
                            <div class="row">
                                <label class="col-12" for="lecturer_id">@lang($module.'.lecturer_id') <span class="text-danger">*</span></label>
                                <div class="col-12">
                                    <select name="lecturer_id" id="lecturer_id" class="selectpicker form-control" data-live-search="true">
                                        <option selected value="">--</option>
                                        @foreach($lecturers as $item)
                                            <option value="{{$item->id}}" @if(isset($record) && $record->lecturer_id == $item->id) selected @endif>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 text-danger" id="user_id_error"></div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="user_id">@lang($module.'.user_id') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <select name="user_id" id="user_id" class="selectpicker form-control" data-live-search="true">
                                    <option selected value="">--</option>
                                    @foreach($users as $item)
                                        <option value="{{$item->id}}" @if(isset($record) && $record->user_id == $item->id) selected @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="user_id_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="course_id">@lang($module.'.course_id') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <select name="course_id" id="course_id" class="selectpicker form-control" data-live-search="true">
                                    <option selected value="">--</option>
                                    @foreach($courses as $item)
                                        <option value="{{$item->id}}" @if(isset($record) && $record->course_id == $item->id) selected @endif>{{$item->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="course_id_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="grade1">@lang($module.'.grade1')</label>
                            <div class="col-12">
                                <input type="number" min="0" max="100" name="grade1" step="0.1" id="grade1" class="form-control" placeholder="@lang($module.'.grade1')" @if($record) value="{{$record->grade1}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="grade1_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="grade2">@lang($module.'.grade2')</label>
                            <div class="col-12">
                                <input type="number" min="0" max="100" name="grade2" step="0.1" id="grade2" class="form-control" placeholder="@lang($module.'.grade2')" @if($record) value="{{$record->grade2}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="grade2_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="grade3">@lang($module.'.grade3')</label>
                            <div class="col-12">
                                <input type="number" min="0" max="100" name="grade3" step="0.1" id="grade3" class="form-control" placeholder="@lang($module.'.grade3')" @if($record) value="{{$record->grade3}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="grade3_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="grade4">@lang($module.'.grade4')</label>
                            <div class="col-12">
                                <input type="number" min="0" max="100" name="grade4" step="0.1" id="grade4" class="form-control" placeholder="@lang($module.'.grade4')" @if($record) value="{{$record->grade4}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="grade4_error"></div>
                        </div>
                    </div>

                    <div class="form-group col-lg-6 col-sm-12">
                        <div class="row">
                            <label class="col-12" for="grade5">@lang($module.'.grade5')</label>
                            <div class="col-12">
                                <input type="number" min="0" max="100" name="grade5" step="0.1" id="grade5" class="form-control" placeholder="@lang($module.'.grade5')" @if($record) value="{{$record->grade5}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="grade5_error"></div>
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
            lecturer_id: {
                required: true,
            },
            user_id: {
                required: true,
            },
            course_id: {
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
        e.preventDefault();

        if (!$("#add_edit_form").valid())
            return false;

        postData(new FormData($('#add_edit_form').get(0)), '{{route($module.'.add_edit')}}');
    });

</script>
