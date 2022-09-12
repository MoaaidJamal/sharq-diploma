<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('courses.lectures.'.$module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="question">@lang($module.'.question') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <textarea rows="6" name="question" id="question" class="form-control editor">@if($record){{$record->question}}@endif</textarea>
                            </div>
                            <div class="col-12 text-danger" id="question_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="answer1">@lang($module.'.answer1') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="text" name="answer1" id="answer1" class="form-control" placeholder="@lang($module.'.answer1')" @if($record) value="{{$record->answer1}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="answer1_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="answer2">@lang($module.'.answer2') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <input type="text" name="answer2" id="answer2" class="form-control" placeholder="@lang($module.'.answer2')" @if($record) value="{{$record->answer2}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="answer2_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="answer3">@lang($module.'.answer3')</label>
                            <div class="col-12">
                                <input type="text" name="answer3" id="answer3" class="form-control" placeholder="@lang($module.'.answer3')" @if($record) value="{{$record->answer3}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="answer3_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="answer4">@lang($module.'.answer4')</label>
                            <div class="col-12">
                                <input type="text" name="answer4" id="answer4" class="form-control" placeholder="@lang($module.'.answer4')" @if($record) value="{{$record->answer4}}" @endif>
                            </div>
                            <div class="col-12 text-danger" id="answer4_error"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <div class="row">
                            <label class="col-12" for="correct_answer">@lang($module.'.correct_answer') <span class="text-danger">*</span></label>
                            <div class="col-12">
                                <select name="correct_answer" id="correct_answer" class="selectpicker form-control" data-live-search="true">
                                    <option selected value="">--</option>
                                    <option value="1" @if(isset($record) && $record->correct_answer == 1) selected @endif>@lang($module.'.answer1')</option>
                                    <option value="2" @if(isset($record) && $record->correct_answer == 2) selected @endif>@lang($module.'.answer2')</option>
                                    <option value="3" @if(isset($record) && $record->correct_answer == 3) selected @endif>@lang($module.'.answer3')</option>
                                    <option value="4" @if(isset($record) && $record->correct_answer == 4) selected @endif>@lang($module.'.answer4')</option>
                                </select>
                            </div>
                            <div class="col-12 text-danger" id="correct_answer_error"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="course_id" value="{{$course_id}}">
                <input type="hidden" name="lecture_id" value="{{$lecture_id}}">
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
    $('textarea.editor').ckeditor({
        language: '{{locale()}}',
        filebrowserBrowseUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserUploadUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
        filebrowserImageBrowseUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr='
    });
    $('#add_edit_form').validate({
        rules: {
            question: {
                required: true,
            },
            answer1: {
                required: true,
            },
            answer2: {
                required: true,
            },
            correct_answer: {
                required: true,
            },
        },
        errorElement: 'span',
        errorClass: 'help-block help-block-error',
        focusInvalid: true,
        ignore: [],
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

        postData(new FormData($('#add_edit_form').get(0)), '{{route('courses.lectures.'.$module.'.add_edit')}}');
    });

</script>
