@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section($module . '_menu')
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
                                <a href="{{route($module)}}" class="text-muted">@lang($module.'.title')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="javascript:;" class="text-muted">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route($module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@if($record) @lang($module.'.update') @else @lang($module.'.new') @endif</h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($module)}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary btn-submit" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($record)
                                        <input type="hidden" name="id" value="{{$record->id}}">
                                    @endif
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="title_en">@lang($module.'.title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="title[en]" id="title_en" class="form-control" placeholder="@lang($module.'.title_en')" @if($record) value="{{$record->getTranslation('title', 'en')}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="title_ar">@lang($module.'.title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="title[ar]" id="title_ar" class="form-control" placeholder="@lang($module.'.title_ar')" @if($record) value="{{$record->getTranslation('title', 'ar')}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="title_ar_error"></div>
                                            </div>
                                        </div>

                                        @if(!session('dashboard_phase_id'))
                                            <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                                <div class="row">
                                                    <label class="col-12" for="phase_id">@lang($module.'.phase_id') <span class="text-danger">*</span></label>
                                                    <div class="col-12">
                                                        <select name="phase_id" id="phase_id" class="selectpicker form-control" data-live-search="true">
                                                            <option selected value="">--</option>
                                                            @foreach($phases as $item)
                                                                <option value="{{$item->id}}" @if(isset($record) && $record->phase_id == $item->id) selected @endif>{{$item->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 text-danger" id="phase_id_error"></div>
                                                </div>
                                            </div>
                                        @else
                                            <input type="hidden" name="phase_id" value="{{session('dashboard_phase_id')}}">
                                        @endif

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="user_id">@lang($module.'.user_id')</label>
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

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="start_date">@lang($module.'.start_date')</label>
                                                <div class="col-12">
                                                    <input type="text" readonly name="start_date" id="start_date" class="form-control my-datetimepicker" placeholder="@lang($module.'.start_date')" @if($record) value="{{$record->start_date}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="start_date_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="end_date">@lang($module.'.end_date')</label>
                                                <div class="col-12">
                                                    <input type="text" readonly name="end_date" id="end_date" class="form-control my-datetimepicker" placeholder="@lang($module.'.end_date')" @if($record) value="{{$record->end_date}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="end_date_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="hours">@lang($module.'.hours')</label>
                                                <div class="col-12">
                                                    <input type="number" min="0" name="hours" id="hours" class="form-control" placeholder="@lang($module.'.hours')" @if($record) value="{{$record->hours}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="hours_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="tags">@lang($module.'.tags')</label>
                                                <div class="col-12">
                                                    <input type="text" name="tags" id="tags" data-role="tagsinput" class="form-control" placeholder="@lang($module.'.tags')" @if($record) value="{{$record->tags}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="tags_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="image">@lang($module.'.image') @if(!$record)<span class="text-danger">*</span>@endif</label>
                                                <div class="col-12 ">
                                                    <input type="file" name="image" id="image" accept="image/*" @if(!$record) required @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="image_error"></div>
                                            </div>
                                        </div>

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
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.lectures_groups')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12" id="lectures_groups">
                                            <div class="repeater" data-repeater-list="lectures_groups">
                                                @if($record && count($record->all_lectures_groups))
                                                    @include('CP.courses.lecture_groups', ['is_template' => true, 'item' => null])
                                                    @foreach($record->all_lectures_groups as $item)
                                                        @include('CP.courses.lecture_groups', ['item' => $item])
                                                    @endforeach
                                                @else
                                                    @include('CP.courses.lecture_groups', ['item' => null])
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
                                        <a href="{{route($module)}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
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
                phase_id: {
                    required: true,
                },
                image: {
                    accept: 'image/*',
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

        $('#lectures_groups').repeater({
            initEmpty: false,

            show: function () {
                $(this).slideDown();
            },

            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        @if($record)
            file_input('#image', {
                initialPreview: ['{{$record->image}}'],
            });
        @else
            file_input('#image');
        @endif
    </script>
@endsection
