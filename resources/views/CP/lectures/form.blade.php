@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section($parent_module . '_menu')
    menu-item-active
@endsection

@section('style')
    <style>
    </style>
@endsection

@section('body')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route($parent_module)}}" class="text-muted">@lang($parent_module.'.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route($parent_module.'.'.$module, ['id' => $parent->id])}}" class="text-muted">@lang($module.'.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:;" class="text-muted">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('courses.'.$module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($parent_module.'.'.$module, ['id' => $parent->id])}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary btn-submit" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="course_id" value="{{$parent->id}}">
                                    @if($record)
                                        <input type="hidden" name="id" value="{{$record->id}}">
                                    @endif
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="category_id">@lang($module.'.category_id') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <select name="category_id" id="category_id" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        @foreach(\App\Models\Lecture::CATEGORIES as $id => $name)
                                                            <option value="{{$id}}" @if(isset($record) && $record->category_id == $id) selected @endif>{{$name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="category_id_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="title_en">@lang($module.'.title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="title[en]" id="title_en" class="form-control" placeholder="@lang($module.'.title_en')"
                                                           @if($record) value="{{$record->getTranslation('title', 'en')}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="title_en_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="title_ar">@lang($module.'.title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="title[ar]" id="title_ar" class="form-control" placeholder="@lang($module.'.title_ar')"
                                                           @if($record) value="{{$record->getTranslation('title', 'ar')}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="title_ar_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="group_id">@lang($module.'.group_id') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <select name="group_id" id="group_id" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        @foreach($groups as $item)
                                                            <option value="{{$item->id}}" @if(isset($record) && $record->group_id == $item->id) selected @endif>{{$item->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="group_id_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-md-12" for="date">@lang($module.'.date')</label>
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control my-daterangepicker-time" name="date" id="date" placeholder="@lang($module.'.date')" @if($record) value="{{\Carbon\Carbon::parse($record->start_date)->format('Y-m-d H:i')}} - {{\Carbon\Carbon::parse($record->end_date)->format('Y-m-d H:i')}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="date_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="minutes">@lang($module.'.minutes')</label>
                                                <div class="col-12">
                                                    <input type="number" min="0" name="minutes" id="minutes" class="form-control" placeholder="@lang($module.'.minutes')" @if($record) value="{{$record->minutes}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="minutes_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if($record && $record->category_id == \App\Models\Lecture::CATEGORY_QUIZ) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="embedded_code">@lang($module.'.embedded_code')</label>
                                                <div class="col-12">
                                                    <input type="text" name="embedded_code" id="embedded_code" class="form-control" placeholder="@lang($module.'.embedded_code')" @if($record) value="{{$record->embedded_code}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="embedded_code_error"></div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="description_div" @if($record && $record->category_id == \App\Models\Lecture::CATEGORY_QUIZ) style="display: none" @endif>
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <div class="row">
                                                        <label class="col-12" for="description_en">@lang($module.'.description_en')</label>
                                                        <div class="col-12">
                                                            <textarea rows="6" name="description[en]" id="description_en" class="form-control editor">@if($record){{$record->getTranslation('description', 'en')}}@endif</textarea>
                                                        </div>
                                                        <div class="col-12 text-danger" id="description_en_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-12">
                                                    <div class="row">
                                                        <label class="col-12" for="description_ar">@lang($module.'.description_ar')</label>
                                                        <div class="col-12">
                                                            <textarea rows="6" name="description[ar]" id="description_ar" class="form-control editor">@if($record){{$record->getTranslation('description', 'ar')}}@endif</textarea>
                                                        </div>
                                                        <div class="col-12 text-danger" id="description_ar_error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-12" id="assignment_div" @if(!$record || $record->category_id != \App\Models\Lecture::CATEGORY_ASSIGNMENT) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="assignment_en">@lang($module.'.assignment_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <textarea rows="6" name="assignment[en]" id="assignment_en" class="form-control editor">@if($record){{$record->getTranslation('assignment', 'en')}}@endif</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="assignment_en_error"></div>
                                            </div>
                                            <div class="row">
                                                <label class="col-12" for="assignment_ar">@lang($module.'.assignment_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <textarea rows="6" name="assignment[ar]" id="assignment_ar" class="form-control editor">@if($record){{$record->getTranslation('assignment', 'ar')}}@endif</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="assignment_ar_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" style="display: none">
                                            <div class="row">
                                                <label class="col-12" for="zoom_account">@lang($module.'.zoom_account') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <select name="zoom_account" id="zoom_account" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        @foreach(\App\Models\Lecture::ZOOM_ACCOUNTS as $email => $name)
                                                            <option value="{{$email}}">{{$email}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="zoom_account_error"></div>
                                            </div>
                                        </div>

                                        <div class="col-12" id="lecture_content" @if($record && $record->category_id == \App\Models\Lecture::CATEGORY_QUIZ) style="display: none" @endif>
                                            <div class="row">
                                                <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                    <div class="row">
                                                        <label class="col-12" for="file_type">@lang($module.'.file_type') <span class="text-danger">*</span></label>
                                                        <div class="col-12">
                                                            <select name="file_type" id="file_type" class="selectpicker form-control" data-live-search="true">
                                                                <option selected value="">--</option>
                                                                <option value="1" @if(isset($record) && $record->file_type == 1) selected @endif>@lang($module.'.youtube')</option>
                                                                <option value="2" @if(isset($record) && $record->file_type == 2) selected @endif>@lang($module.'.vimeo')</option>
                                                                <option value="3" @if(isset($record) && $record->file_type == 3) selected @endif>@lang($module.'.pdf')</option>
                                                                <option value="4" @if(isset($record) && $record->file_type == 4) selected @endif>@lang($module.'.powerpoint')</option>
                                                                <option value="5" @if(isset($record) && $record->file_type == 5) selected @endif>@lang($module.'.text')</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 text-danger" id="file_type_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-6 col-sm-12" id="video_div" @if(!isset($record) || !in_array($record->file_type, [1, 2])) style="display: none" @endif>
                                                    <div class="row">
                                                        <label class="col-12" for="video_id">@lang($module.'.video_id') <span class="text-danger">*</span></label>
                                                        <div class="col-12">
                                                            <input type="text" name="video_id" id="video_id" class="form-control" placeholder="@lang($module.'.video_id')"
                                                                   @if($record) value="{{$record->video_id}}" @endif>
                                                        </div>
                                                        <div class="col-12 text-danger" id="video_id_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-lg-4 col-md-6 col-sm-12" id="file_div" @if(!isset($record) || $record->file_type == 5 || $record->file_type == 1 || $record->file_type == 2) style="display: none" @endif>
                                                    <div class="row">
                                                        <label class="col-12" for="file">@lang($module.'.file') @if(!$record)<span class="text-danger">*</span>@endif</label>
                                                        <div class="col-12 ">
                                                            <input type="file" name="file" id="file" @if(!$record) required @endif>
                                                        </div>
                                                        <div class="col-12 text-danger" id="file_error"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-12" id="content_div" @if(!isset($record) || $record->file_type != 5) style="display: none" @endif>
                                                    <div class="row">
                                                        <label class="col-12" for="content">@lang($module.'.content') <span class="text-danger">*</span></label>
                                                        <div class="col-12">
                                                            <textarea rows="6" name="content" id="content" class="form-control editor">@if($record){{$record->content}}@endif</textarea>
                                                        </div>
                                                        <div class="col-12 text-danger" id="content_error"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between" id="second_actions">
                                    <h3 class="card-title"></h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($parent_module.'.'.$module, ['id' => $parent->id])}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary btn-submit" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="quiz_div"  @if(!$record || $record->category_id != \App\Models\Lecture::CATEGORY_QUIZ) style="display: none" @endif>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.quiz_questions')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12" id="quiz_questions">
                                            <div class="repeater" data-repeater-list="quiz_questions">
                                                @if($record && count($record->questions))
                                                    @include('CP.lectures.quiz_questions', ['is_template' => true, 'item' => null])
                                                    @foreach($record->questions as $item)
                                                        @include('CP.lectures.quiz_questions', ['item' => $item])
                                                    @endforeach
                                                @else
                                                    @include('CP.lectures.quiz_questions', ['item' => null])
                                                @endif
                                            </div>
                                            <div class="form-group mt-5">
                                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                                    <i class="la la-plus"></i>@lang('constants.new')
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <h3 class="card-title"></h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($parent_module.'.'.$module, ['id' => $parent->id])}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary btn-submit" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        $('textarea.editor').ckeditor({
            language: '{{locale()}}',
            filebrowserBrowseUrl: '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl: '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl: '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr='
        });

        $('#add_edit_form').validate({
            rules: {
                'title[en]': {
                    required: true,
                },
                'title[ar]': {
                    required: true,
                },
                category_id: {
                    required: true,
                },
                zoom_account: {
                    required: true,
                },
                group_id: {
                    required: true,
                },
                course_id: {
                    required: true,
                },
                'description[en]': {
                    required: true,
                },
                'description[ar]': {
                    required: true,
                },
                'assignment[en]': {
                    required: true,
                },
                'assignment[ar]': {
                    required: true,
                },
                content: {
                    required: true,
                },
                file_type: {
                    required: true,
                },
                video_id: {
                    required: true,
                },
            },
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: true,
            ignore: ':hidden',
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

        $('.btn-submit').click(function () {
            if ($('#add_edit_form').valid()) {
                KTApp.blockPage({
                    overlayColor: '#000000',
                    type: 'v2',
                    state: 'success',
                    message: '@lang('constants.please_wait') ...'
                });
                $('#add_edit_form').submit();
            }
        });

        @if($record)
            file_input('#image', {
                initialPreview: ['{{$record->image}}'],
            });
            file_input('#file', {
                initialPreview: ['{{$record->file}}'],
                @if($record->file_type == 3)
                    initialPreviewConfig: [
                        {type: 'pdf'}
                    ]
                @elseif($record->file_type == 4)
                    initialPreviewConfig: [
                        {type: 'office'}
                    ]
                @endif
            });
        @else
            file_input('#image');
            file_input('#file');
        @endif

        $('#file_type').change(function () {
            if ($(this).val() == 1 || $(this).val() == 2) {
                $('#content_div').hide();
                $('#file_div').hide();
                $('#video_div').show();
            } else if ($(this).val() == 5) {
                $('#content_div').show();
                $('#file_div').hide();
                $('#video_div').hide();
            } else if ($(this).val() == 3 || $(this).val() == 4) {
                $('#content_div').hide();
                $('#file_div').show();
                $('#video_div').hide();
            } else {
                $('#content_div').hide();
                $('#file_div').hide();
                $('#video_div').hide();
            }
        });

        $('#category_id').change(function () {
            if ($(this).val() == {{\App\Models\Lecture::CATEGORY_ASSIGNMENT}}) {
                $('#zoom_account').parents('.form-group').hide();
                $('#description_div').show();
                $('#second_actions').addClass('d-flex').show();
                $('#assignment_div').show();
                $('#lecture_content').show();
                $('#quiz_div').hide();
                $('#embedded_code').parents('.form-group').show();
                $('#minutes').prop('required', false);
                $('#date').prop('required', false);
            } else if ($(this).val() == {{\App\Models\Lecture::CATEGORY_QUIZ}}) {
                $('#zoom_account').parents('.form-group').hide();
                $('#description_div').hide();
                $('#second_actions').removeClass('d-flex').hide();
                $('#quiz_div').show();
                $('#lecture_content').hide();
                $('#embedded_code').parents('.form-group').hide();
                $('#assignment_div').hide();
                $('#minutes').prop('required', false);
                $('#date').prop('required', false);
            } else if ($(this).val() == {{\App\Models\Lecture::CATEGORY_ZOOM}}) {
                $('#description_div').hide();
                $('#second_actions').addClass('d-flex').show();
                $('#lecture_content').hide();
                $('#embedded_code').parents('.form-group').hide();
                $('#assignment_div').hide();
                $('#quiz_div').hide();
                $('#minutes').prop('required', true);
                $('#date').prop('required', true);
                $('#zoom_account').parents('.form-group').show();
            } else {
                $('#zoom_account').parents('.form-group').hide();
                $('#second_actions').addClass('d-flex').show();
                $('#description_div').show();
                $('#assignment_div').hide();
                $('#quiz_div').hide();
                $('#lecture_content').show();
                $('#embedded_code').parents('.form-group').show();
                $('#minutes').prop('required', false);
                $('#date').prop('required', false);
            }
        });

        $('#quiz_questions').repeater({
            initEmpty: false,

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endsection
