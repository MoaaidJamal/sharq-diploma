@extends('CP.layouts.main')

@section('title')
    @lang($module.'.title')
@endsection

@section($module . '_menu')
    menu-item-active
@endsection

@section('style')
    <style>
        #random {
            cursor: pointer;
        }
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
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <form action="{{route($module.'.add_edit')}}" method="post" id="add_edit_form" enctype="multipart/form-data">
                    @csrf
                    @if($record)
                        <input type="hidden" name="id" value="{{$record->id}}">
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.basic_info')</h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($module)}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary submit_btn" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="type">@lang($module.'.type') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <select name="type" id="type" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        <option value="1" @if(isset($record) && $record->type == 1) selected @endif>@lang($module.'.admin')</option>
                                                        <option value="2" @if(isset($record) && $record->type == 2) selected @endif>@lang($module.'.user')</option>
                                                        <option value="3" @if(isset($record) && $record->type == 3) selected @endif>@lang($module.'.mentor')</option>
                                                        <option value="4" @if(isset($record) && $record->type == 4) selected @endif>@lang($module.'.team')</option>
                                                        <option value="5" @if(isset($record) && $record->type == 5) selected @endif>@lang($module.'.lecturer')</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="type_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="name">@lang($module.'.name')</label>
                                                <div class="col-12">
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="@lang($module.'.name')" @if($record) value="{{$record->name}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="name_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || $record->type != 3) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="name_en">@lang($module.'.name_en')</label>
                                                <div class="col-12">
                                                    <input type="text" name="name_en" id="name_en" class="form-control" placeholder="@lang($module.'.name_en')"
                                                           @if($record) value="{{$record->name_en}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="name_en_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="email">@lang($module.'.email') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="@lang($module.'.email')"
                                                           @if($record) value="{{$record->email}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="email_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || $record->type != 2) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="mobile">@lang($module.'.mobile')</label>
                                                <div class="col-12">
                                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="@lang($module.'.mobile')"
                                                           @if($record) value="{{$record->mobile}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="mobile_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || !in_array($record->type, [2, 3])) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="dob">@lang($module.'.dob')</label>
                                                <div class="col-12">
                                                    <input type="text" name="dob" id="dob" readonly class="form-control my-dob-datepicker" placeholder="@lang($module.'.dob')" @if($record) value="{{Carbon\Carbon::parse($record->dob)->toDateString()}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="dob_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="country_id">@lang($module.'.country_id')</label>
                                                <div class="col-12">
                                                    <select name="country_id" id="country_id" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        @foreach($countries as $item)
                                                            <option value="{{$item->id}}" @if(isset($record) && $record->country_id == $item->id) selected @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="country_id_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || $record->type != 4) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="position">@lang($module.'.position')</label>
                                                <div class="col-12">
                                                    <input type="text" name="position" id="position" class="form-control" placeholder="@lang($module.'.position')" @if($record) value="{{$record->position}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="position_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || $record->type != 5) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="course_id">@lang($module.'.course_id')</label>
                                                <div class="col-12">
                                                    <select name="course_id" id="course_id" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        @foreach($courses as $item)
                                                            <option value="{{$item->id}}" @if(isset($record) && $item->user_id == $record->id) selected @endif>{{$item->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="position_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || !in_array($record->type, [1, 2, 5])) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="password">@lang($module.'.password')</label>
                                                <div class="col-12 input-group">
                                                    <input type="password" name="password" id="password" class="form-control" placeholder="@lang($module.'.password')">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="random">Random</span>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-danger" id="password_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || !in_array($record->type, [1, 2, 5])) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="password_confirmation">@lang($module.'.password_confirmation')</label>
                                                <div class="col-12">
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                                           placeholder="@lang($module.'.password_confirmation')">
                                                </div>
                                                <div class="col-12 text-danger" id="password_confirmation_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="image">@lang($module.'.image')</label>
                                                <div class="col-12 ">
                                                    <input type="file" name="image" id="image" accept="image/*">
                                                </div>
                                                <div class="col-12 text-danger" id="image_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="user_info" @if(!$record || !in_array($record->type, [2, 3])) style="display: none" @endif>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.user_info')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="bio">@lang($module.'.bio')</label>
                                                <div class="col-12">
                                                    <textarea name="bio" id="bio" class="form-control" rows="6" placeholder="@lang($module.'.bio')">@if($record){{$record->bio}}@endif</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="bio_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-12" @if(!$record || $record->type != 3) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="request_session_description">@lang($module.'.request_session_description')</label>
                                                <div class="col-12">
                                                    <textarea name="request_session_description" id="request_session_description" class="form-control" rows="6" placeholder="@lang($module.'.request_session_description')">@if($record){{$record->request_session_description}}@endif</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="request_session_description_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="gender">@lang($module.'.gender')</label>
                                                <div class="col-12">
                                                    <select name="gender" id="gender" class="selectpicker form-control" data-live-search="true">
                                                        <option selected value="">--</option>
                                                        <option value="1" @if(isset($record) && $record->gender == 1) selected @endif>@lang($module.'.male')</option>
                                                        <option value="2" @if(isset($record) && $record->gender == 2) selected @endif>@lang($module.'.female')</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="gender_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="work">@lang($module.'.work')</label>
                                                <div class="col-12">
                                                    <input type="text" name="work" id="work" class="form-control" placeholder="@lang($module.'.work')" @if($record) value="{{$record->work}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="work_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="study">@lang($module.'.study')</label>
                                                <div class="col-12">
                                                    <input type="text" name="study" id="study" class="form-control" placeholder="@lang($module.'.study')" @if($record) value="{{$record->study}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="study_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12" @if(!$record || $record->type != 2) style="display: none" @endif>
                                            <div class="row">
                                                <label class="col-12" for="interests">@lang($module.'.interests')</label>
                                                <div class="col-12">
                                                    <select name="interests[]" id="interests" class="selectpicker form-control" multiple data-live-search="true" data-actions-box="true">
                                                        @foreach($interests as $item)
                                                            <option value="{{$item->id}}" @if(isset($record) && $record->interests->contains($item->id)) selected @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="interests_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="languages">@lang($module.'.languages')</label>
                                                <div class="col-12">
                                                    <select name="languages[]" id="languages" class="selectpicker form-control" multiple data-live-search="true" data-actions-box="true">
                                                        @foreach($languages as $item)
                                                            <option value="{{$item->id}}" @if(isset($record) && $record->languages->contains($item->id)) selected @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 text-danger" id="languages_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="user_personality" @if(!$record || $record->type != 2) style="display: none" @endif>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.personality')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="extrovert">@lang($module.'.introvert') - @lang($module.'.extrovert')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="extrovert" id="extrovert" class="form-control" @if($record) value="{{$record->extrovert}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="extrovert_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="feeling">@lang($module.'.thinking') - @lang($module.'.feeling')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="feeling" id="feeling" class="form-control" @if($record) value="{{$record->feeling}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="feeling_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="intuition">@lang($module.'.sensing') - @lang($module.'.intuition')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="intuition" id="intuition" class="form-control" @if($record) value="{{$record->intuition}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="intuition_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="perceiving">@lang($module.'.judging') - @lang($module.'.perceiving')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="perceiving" id="perceiving" class="form-control" @if($record) value="{{$record->perceiving}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="perceiving_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="user_roles" @if(!$record || $record->type != 2) style="display: none" @endif>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.roles')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="maker">@lang($module.'.maker')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="maker" id="maker" class="form-control" @if($record) value="{{$record->maker}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="maker_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="connector">@lang($module.'.connector')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="connector" id="connector" class="form-control" @if($record) value="{{$record->connector}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="connector_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="idea_generator">@lang($module.'.idea_generator')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="idea_generator" id="idea_generator" class="form-control" @if($record) value="{{$record->idea_generator}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="idea_generator_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="collaborator">@lang($module.'.collaborator')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="collaborator" id="collaborator" class="form-control" @if($record) value="{{$record->collaborator}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="collaborator_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="finisher">@lang($module.'.finisher')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="finisher" id="finisher" class="form-control" @if($record) value="{{$record->finisher}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="finisher_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="evaluator">@lang($module.'.evaluator')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="evaluator" id="evaluator" class="form-control" @if($record) value="{{$record->evaluator}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="evaluator_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="organiser">@lang($module.'.organiser')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="organiser" id="organiser" class="form-control" @if($record) value="{{$record->organiser}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="organiser_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <div class="row">
                                                <label class="col-12" for="moderator">@lang($module.'.moderator')</label>
                                                <div class="col-12">
                                                    <input type="hidden" name="moderator" id="moderator" class="form-control" @if($record) value="{{$record->moderator}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="moderator_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" id="social_media" @if(!$record || in_array($record->type, [1, 5])) style="display: none" @endif>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.social_media')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="facebook">@lang($module.'.facebook')</label>
                                                <div class="col-12">
                                                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="@lang($module.'.facebook')"
                                                           @if($record) value="{{$record->facebook}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="facebook_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="twitter">@lang($module.'.twitter')</label>
                                                <div class="col-12">
                                                    <input type="text" name="twitter" id="twitter" class="form-control" placeholder="@lang($module.'.twitter')"
                                                           @if($record) value="{{$record->twitter}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="twitter_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="linkedin">@lang($module.'.linkedin')</label>
                                                <div class="col-12">
                                                    <input type="text" name="linkedin" id="linkedin" class="form-control" placeholder="@lang($module.'.linkedin')"
                                                           @if($record) value="{{$record->linkedin}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="linkedin_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="instagram">@lang($module.'.instagram')</label>
                                                <div class="col-12">
                                                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="@lang($module.'.instagram')"
                                                           @if($record) value="{{$record->instagram}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="instagram_error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="slack">@lang($module.'.slack')</label>
                                                <div class="col-12">
                                                    <input type="text" name="slack" id="slack" class="form-control" placeholder="@lang($module.'.slack')"
                                                           @if($record) value="{{$record->slack}}" @endif>
                                                </div>
                                                <div class="col-12 text-danger" id="slack_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <h3 class="card-title"></h3>
                                    <div class="card-toolbar">
                                        <a href="{{route($module)}}" class="btn btn-secondary" style="margin: 0 5px">@lang('constants.cancel')</a>
                                        <button type="button" class="btn btn-primary submit_btn" style="margin: 0 5px">@lang('constants.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                email: {
                    required: true,
                },
                type: {
                    required: true,
                },
                image: {
                    accept: 'image/*',
                },
                password_confirmation: {
                    equalTo: '#password',
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

        $('#extrovert, #feeling, #intuition, #perceiving').ionRangeSlider({
            min: 0,
            max: 100,
        });

        $('#maker, #connector, #idea_generator, #collaborator, #finisher, #evaluator, #organiser, #moderator').ionRangeSlider({
            min: 0,
            max: 100,
            postfix: "%",
        });

        @if($record)
            file_input('#image', {
                initialPreview: ['{{$record->full_path_image}}'],
            });
        @else
            file_input('#image');
        @endif

        $('.submit_btn').click(function (e) {
            e.preventDefault();

            if (!$("#add_edit_form").valid())
                return false;

            check_unique();
        });

        $('#type').change(function (e) {
            if ($(this).val() == 1 || $(this).val() == 5) {
                $('#password').parents('.form-group').show();
                $('#password_confirmation').parents('.form-group').show();
                $('#request_session_description').parents('.form-group').hide();
                $('#mobile').parents('.form-group').hide();
                $('#dob').parents('.form-group').hide();
                $('#position').parents('.form-group').hide();
                $('#interests').parents('.form-group').hide();
                $('#user_info').hide();
                $('#user_personality').hide();
                $('#user_roles').hide();
                $('#social_media').hide();
                $('#name_en').parents('.form-group').hide();
                if ($(this).val() == 5) {
                    $('#course_id').parents('.form-group').show();
                } else {
                    $('#course_id').parents('.form-group').hide();
                }
            } else if ($(this).val() == 2) {
                $('#password').parents('.form-group').show();
                $('#password_confirmation').parents('.form-group').show();
                $('#request_session_description').parents('.form-group').hide();
                $('#mobile').parents('.form-group').show();
                $('#dob').parents('.form-group').show();
                $('#position').parents('.form-group').hide();
                $('#interests').parents('.form-group').show();
                $('#user_info').show();
                $('#user_personality').show();
                $('#user_roles').show();
                $('#social_media').show();
                $('#course_id').parents('.form-group').hide();
                $('#name_en').parents('.form-group').hide();
            } else if ($(this).val() == 3) {
                $('#password').parents('.form-group').hide();
                $('#password_confirmation').parents('.form-group').hide();
                $('#mobile').parents('.form-group').hide();
                $('#dob').parents('.form-group').show();
                $('#position').parents('.form-group').hide();
                $('#interests').parents('.form-group').hide();
                $('#request_session_description').parents('.form-group').show();
                $('#user_info').show();
                $('#user_personality').hide();
                $('#user_roles').hide();
                $('#social_media').show();
                $('#course_id').parents('.form-group').hide();
                $('#name_en').parents('.form-group').show();
            } else if ($(this).val() == 4) {
                $('#password').parents('.form-group').hide();
                $('#password_confirmation').parents('.form-group').hide();
                $('#mobile').parents('.form-group').hide();
                $('#dob').parents('.form-group').show();
                $('#position').parents('.form-group').show();
                $('#interests').parents('.form-group').hide();
                $('#request_session_description').parents('.form-group').hide();
                $('#user_info').show();
                $('#user_personality').hide();
                $('#user_roles').hide();
                $('#social_media').show();
                $('#course_id').parents('.form-group').hide();
                $('#name_en').parents('.form-group').hide();
            }
        });

        $('.selectpicker').selectpicker();

        function check_unique() {
            $.ajax({
                url: '{{route($module.'.check_unique')}}',
                data: {
                    _token: '{{csrf_token()}}',
                    email: $('#email').val(),
                    @if($record)
                    id: {{$record->id}},
                    @endif
                },
                type: "POST",
                beforeSend() {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success: function (data) {
                    if (data.success) {
                        $('#add_edit_form').submit();
                    } else {
                        if (data.errors) {
                            for (let i = 0; i < data.errors.length; i++) {
                                showAlertMessage('error', data.errors[i]);
                            }
                        }
                        KTApp.unblockPage();
                    }
                },
            });
        }

        $('#random').click(function () {
            let str = random_str(6);
            $('#password').val(str);
            $('#password_confirmation').val(str);
        });

        function random_str(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() *
                    charactersLength));
            }
            return result;
        }

    </script>
@endsection
