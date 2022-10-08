@extends('CP.layouts.main')
@php
    $module = 'settings';
@endphp
@section('title')
    @lang($module.'.title')
@endsection

@section($module.'_menu')
    menu-item-active
@endsection

@section('all_settings_menu')
    menu-item-active
@endsection

@section('body')


    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-2 py-lg-4 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline mr-5">
                        <h5 class="text-dark font-weight-bold my-2 mr-5">@lang($module.'.title')</h5>
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{route($module)}}" class="text-muted">@lang($module.'.title')</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route($module.'.update')}}" method="post" id="{{$module}}" enctype="multipart/form-data">
                            @csrf
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.basic_info')</h3>
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-success update">@lang('constants.save')</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="email">@lang($module.'.email') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="@lang($module.'.email')" value="{{$settings->email}}">
                                                </div>
                                                <div class="col-12 text-danger" id="email_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="mobile">@lang($module.'.mobile') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="@lang($module.'.mobile')" value="{{$settings->mobile}}">
                                                </div>
                                                <div class="col-12 text-danger" id="mobile_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="facebook">@lang($module.'.facebook')</label>
                                                <div class="col-12">
                                                    <input type="text" name="facebook" id="facebook" class="form-control" placeholder="@lang($module.'.facebook')" value="{{$settings->facebook}}">
                                                </div>
                                                <div class="col-12 text-danger" id="facebook_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="twitter">@lang($module.'.twitter')</label>
                                                <div class="col-12">
                                                    <input type="text" name="twitter" id="twitter" class="form-control" placeholder="@lang($module.'.twitter')" value="{{$settings->twitter}}">
                                                </div>
                                                <div class="col-12 text-danger" id="twitter_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="instagram">@lang($module.'.instagram')</label>
                                                <div class="col-12">
                                                    <input type="text" name="instagram" id="instagram" class="form-control" placeholder="@lang($module.'.instagram')" value="{{$settings->instagram}}">
                                                </div>
                                                <div class="col-12 text-danger" id="instagram_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="slack">@lang($module.'.slack')</label>
                                                <div class="col-12">
                                                    <input type="text" name="slack" id="slack" class="form-control" placeholder="@lang($module.'.slack')" value="{{$settings->slack}}">
                                                </div>
                                                <div class="col-12 text-danger" id="slack_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="home_video_id">@lang($module.'.home_video_id')</label>
                                                <div class="col-12">
                                                    <input type="text" name="home_video_id" id="home_video_id" class="form-control" placeholder="@lang($module.'.home_video_id')" value="{{$settings->home_video_id}}">
                                                </div>
                                                <div class="col-12 text-danger" id="home_video_id_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">@lang($module.'.website_content')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="home_menu_title_en">@lang($module.'.home_menu_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="home_menu_title[en]" id="home_menu_title_en" class="form-control" placeholder="@lang($module.'.home_menu_title_en')" value="{{$settings->getTranslation('home_menu_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="home_menu_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="home_menu_title_ar">@lang($module.'.home_menu_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="home_menu_title[ar]" id="home_menu_title_ar" class="form-control" placeholder="@lang($module.'.home_menu_title_ar')" value="{{$settings->getTranslation('home_menu_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="home_menu_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_menu_title_en">@lang($module.'.learning_paths_menu_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="learning_paths_menu_title[en]" id="learning_paths_menu_title_en" class="form-control" placeholder="@lang($module.'.learning_paths_menu_title_en')" value="{{$settings->getTranslation('learning_paths_menu_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_menu_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_menu_title_ar">@lang($module.'.learning_paths_menu_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="learning_paths_menu_title[ar]" id="learning_paths_menu_title_ar" class="form-control" placeholder="@lang($module.'.learning_paths_menu_title_ar')" value="{{$settings->getTranslation('learning_paths_menu_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_menu_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="mentors_menu_title_en">@lang($module.'.mentors_menu_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="mentors_menu_title[en]" id="mentors_menu_title_en" class="form-control" placeholder="@lang($module.'.mentors_menu_title_en')" value="{{$settings->getTranslation('mentors_menu_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="mentors_menu_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="mentors_menu_title_ar">@lang($module.'.mentors_menu_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="mentors_menu_title[ar]" id="mentors_menu_title_ar" class="form-control" placeholder="@lang($module.'.mentors_menu_title_ar')" value="{{$settings->getTranslation('mentors_menu_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="mentors_menu_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_menu_title_en">@lang($module.'.find_your_mate_menu_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="find_your_mate_menu_title[en]" id="find_your_mate_menu_title_en" class="form-control" placeholder="@lang($module.'.find_your_mate_menu_title_en')" value="{{$settings->getTranslation('find_your_mate_menu_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_menu_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_menu_title_ar">@lang($module.'.find_your_mate_menu_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="find_your_mate_menu_title[ar]" id="find_your_mate_menu_title_ar" class="form-control" placeholder="@lang($module.'.find_your_mate_menu_title_ar')" value="{{$settings->getTranslation('find_your_mate_menu_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_menu_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="schedule_menu_title_en">@lang($module.'.schedule_menu_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="schedule_menu_title[en]" id="schedule_menu_title_en" class="form-control" placeholder="@lang($module.'.schedule_menu_title_en')" value="{{$settings->getTranslation('schedule_menu_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="schedule_menu_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="schedule_menu_title_ar">@lang($module.'.schedule_menu_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="schedule_menu_title[ar]" id="schedule_menu_title_ar" class="form-control" placeholder="@lang($module.'.schedule_menu_title_ar')" value="{{$settings->getTranslation('schedule_menu_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="schedule_menu_title_ar_error"></div>
                                            </div>
                                        </div>
{{--                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">--}}
{{--                                            <div class="row">--}}
{{--                                                <label class="col-12" for="messages_menu_title">@lang($module.'.messages_menu_title') <span class="text-danger">*</span></label>--}}
{{--                                                <div class="col-12">--}}
{{--                                                    <input type="text" name="schedule_menu_title[ar]" id="messages_menu_title" class="form-control" placeholder="@lang($module.'.messages_menu_title')" value="{{$settings->getTranslation('schedule_menu_title', 'ar')}}">--}}
{{--                                                </div>--}}
{{--                                                <div class="col-12 text-danger" id="messages_menu_title_error"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="follow_us_on_social_media_en">@lang($module.'.follow_us_on_social_media_en')</label>
                                                <div class="col-12">
                                                    <input type="text" name="follow_us_on_social_media[en]" id="follow_us_on_social_media_en" class="form-control" placeholder="@lang($module.'.follow_us_on_social_media_en')" value="{{$settings->getTranslation('follow_us_on_social_media', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="follow_us_on_social_media_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="follow_us_on_social_media_ar">@lang($module.'.follow_us_on_social_media_ar')</label>
                                                <div class="col-12">
                                                    <input type="text" name="follow_us_on_social_media[ar]" id="follow_us_on_social_media_ar" class="form-control" placeholder="@lang($module.'.follow_us_on_social_media_ar')" value="{{$settings->getTranslation('follow_us_on_social_media', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="follow_us_on_social_media_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="header_title_en">@lang($module.'.header_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="header_title[en]" id="header_title_en" class="form-control" placeholder="@lang($module.'.header_title_en')" value="{{$settings->getTranslation('header_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="header_title_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="header_title_ar">@lang($module.'.header_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="header_title[ar]" id="header_title_ar" class="form-control" placeholder="@lang($module.'.header_title_ar')" value="{{$settings->getTranslation('header_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="header_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="header_description_en">@lang($module.'.header_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="header_description[en]" id="header_description_en" class="form-control" rows="6" placeholder="@lang($module.'.header_description_en')">{{$settings->getTranslation('header_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="header_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="header_description_ar">@lang($module.'.header_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="header_description[ar]" id="header_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.header_description_ar')">{{$settings->getTranslation('header_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="header_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="home_video_title_en">@lang($module.'.home_video_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="home_video_title[en]" id="home_video_title_en" class="form-control" placeholder="@lang($module.'.home_video_title_en')" value="{{$settings->getTranslation('home_video_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="home_video_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="home_video_title_ar">@lang($module.'.home_video_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="home_video_title[ar]" id="home_video_title_ar" class="form-control" placeholder="@lang($module.'.home_video_title_ar')" value="{{$settings->getTranslation('home_video_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="home_video_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="home_video_description_en">@lang($module.'.home_video_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="home_video_description[en]" id="home_video_description_en" class="form-control" rows="6" placeholder="@lang($module.'.home_video_description_en')">{{$settings->getTranslation('home_video_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="home_video_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="home_video_description_ar">@lang($module.'.home_video_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="home_video_description[ar]" id="home_video_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.home_video_description_ar')">{{$settings->getTranslation('home_video_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="home_video_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_title_en">@lang($module.'.find_your_mate_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="find_your_mate_title[en]" id="find_your_mate_title_en" class="form-control" placeholder="@lang($module.'.find_your_mate_title_en')" value="{{$settings->getTranslation('find_your_mate_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_title_ar">@lang($module.'.find_your_mate_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="find_your_mate_title[ar]" id="find_your_mate_title_ar" class="form-control" placeholder="@lang($module.'.find_your_mate_title_ar')" value="{{$settings->getTranslation('find_your_mate_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_description_en">@lang($module.'.find_your_mate_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="find_your_mate_description[en]" id="find_your_mate_description_en" class="form-control" rows="6" placeholder="@lang($module.'.find_your_mate_description_en')">{{$settings->getTranslation('find_your_mate_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="find_your_mate_description_ar">@lang($module.'.find_your_mate_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="find_your_mate_description[ar]" id="find_your_mate_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.find_your_mate_description_ar')">{{$settings->getTranslation('find_your_mate_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="find_your_mate_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="popular_mentors_title_en">@lang($module.'.popular_mentors_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="popular_mentors_title[en]" id="popular_mentors_title_en" class="form-control" placeholder="@lang($module.'.popular_mentors_title_en')" value="{{$settings->getTranslation('popular_mentors_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="popular_mentors_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="popular_mentors_title_ar">@lang($module.'.popular_mentors_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="popular_mentors_title[ar]" id="popular_mentors_title_ar" class="form-control" placeholder="@lang($module.'.popular_mentors_title_ar')" value="{{$settings->getTranslation('popular_mentors_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="popular_mentors_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="popular_mentors_description_en">@lang($module.'.popular_mentors_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="popular_mentors_description[ar]" id="popular_mentors_description_en" class="form-control" rows="6" placeholder="@lang($module.'.popular_mentors_description_en')">{{$settings->getTranslation('popular_mentors_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="popular_mentors_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="popular_mentors_description_ar">@lang($module.'.popular_mentors_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="popular_mentors_description[ar]" id="popular_mentors_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.popular_mentors_description_ar')">{{$settings->getTranslation('popular_mentors_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="popular_mentors_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_title_en">@lang($module.'.learning_paths_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="learning_paths_title[en]" id="learning_paths_title_en" class="form-control" placeholder="@lang($module.'.learning_paths_title_en')" value="{{$settings->getTranslation('learning_paths_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_title_ar">@lang($module.'.learning_paths_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="learning_paths_title[ar]" id="learning_paths_title_ar" class="form-control" placeholder="@lang($module.'.learning_paths_title_ar')" value="{{$settings->getTranslation('learning_paths_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_description_en">@lang($module.'.learning_paths_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="learning_paths_description[en]" id="learning_paths_description_en" class="form-control" rows="6" placeholder="@lang($module.'.learning_paths_description_en')">{{$settings->getTranslation('learning_paths_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="learning_paths_description_ar">@lang($module.'.learning_paths_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="learning_paths_description[ar]" id="learning_paths_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.learning_paths_description_ar')">{{$settings->getTranslation('learning_paths_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="learning_paths_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="gallery_title_en">@lang($module.'.gallery_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="gallery_title[en]" id="gallery_title_en" class="form-control" placeholder="@lang($module.'.gallery_title_en')" value="{{$settings->getTranslation('gallery_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="gallery_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="gallery_title_ar">@lang($module.'.gallery_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="gallery_title[ar]" id="gallery_title_ar" class="form-control" placeholder="@lang($module.'.gallery_title_ar')" value="{{$settings->getTranslation('gallery_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="gallery_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="gallery_description_en">@lang($module.'.gallery_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="gallery_description[en]" id="gallery_description_en" class="form-control" rows="6" placeholder="@lang($module.'.gallery_description_en')">{{$settings->getTranslation('gallery_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="gallery_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="gallery_description_ar">@lang($module.'.gallery_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="gallery_description[ar]" id="gallery_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.gallery_description_ar')">{{$settings->getTranslation('gallery_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="gallery_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="partners_title_en">@lang($module.'.partners_title_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="partners_title[en]" id="partners_title_en" class="form-control" placeholder="@lang($module.'.partners_title_en')" value="{{$settings->getTranslation('partners_title', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="partners_title_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="partners_title_ar">@lang($module.'.partners_title_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="partners_title[ar]" id="partners_title_ar" class="form-control" placeholder="@lang($module.'.partners_title_ar')" value="{{$settings->getTranslation('partners_title', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="partners_title_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="partners_description_en">@lang($module.'.partners_description_en')</label>
                                                <div class="col-12">
                                                    <textarea name="partners_description[en]" id="partners_description_en" class="form-control" rows="6" placeholder="@lang($module.'.partners_description_en')">{{$settings->getTranslation('partners_description', 'en')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="partners_description_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <div class="row">
                                                <label class="col-12" for="partners_description_ar">@lang($module.'.partners_description_ar')</label>
                                                <div class="col-12">
                                                    <textarea name="partners_description[ar]" id="partners_description_ar" class="form-control" rows="6" placeholder="@lang($module.'.partners_description_ar')">{{$settings->getTranslation('partners_description', 'ar')}}</textarea>
                                                </div>
                                                <div class="col-12 text-danger" id="partners_description_ar_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="copyright_en">@lang($module.'.copyright_en') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="copyright[en]" id="copyright_en" class="form-control" placeholder="@lang($module.'.copyright_en')" value="{{$settings->getTranslation('copyright', 'en')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="copyright_en_error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-4 col-md-6 col-sm-12">
                                            <div class="row">
                                                <label class="col-12" for="copyright_ar">@lang($module.'.copyright_ar') <span class="text-danger">*</span></label>
                                                <div class="col-12">
                                                    <input type="text" name="copyright[ar]" id="copyright_ar" class="form-control" placeholder="@lang($module.'.copyright_ar')" value="{{$settings->getTranslation('copyright', 'ar')}}">
                                                </div>
                                                <div class="col-12 text-danger" id="copyright_ar_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>

        let form = $('#{{$module}}');
        $('textarea.editor').ckeditor({
            language: '{{locale()}}',
            filebrowserBrowseUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserUploadUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
            filebrowserImageBrowseUrl : '{{url('/')}}/assets/plugins/responsive_filemanager/filemanager/dialog.php?type=2&editor=ckeditor&fldr='
        });
        form.validate({
            rules: {
                email: {
                    required: true,
                },
                mobile: {
                    required: true,
                },
                'home_video_title[en]': {
                    required: true,
                },
                'find_your_mate_title[en]': {
                    required: true,
                },
                'header_title[en]': {
                    required: true,
                },
                'popular_mentors_title[en]': {
                    required: true,
                },
                'learning_paths_title[en]': {
                    required: true,
                },
                'gallery_title[en]': {
                    required: true,
                },
                'partners_title[en]': {
                    required: true,
                },
                'home_menu_title[en]': {
                    required: true,
                },
                'learning_paths_menu_title[en]': {
                    required: true,
                },
                'mentors_menu_title[en]': {
                    required: true,
                },
                'find_your_mate_menu_title[en]': {
                    required: true,
                },
                'schedule_menu_title[en]': {
                    required: true,
                },
                'copyright[en]': {
                    required: true,
                },


                'home_video_title[ar]': {
                    required: true,
                },
                'find_your_mate_title[ar]': {
                    required: true,
                },
                'header_title[ar]': {
                    required: true,
                },
                'popular_mentors_title[ar]': {
                    required: true,
                },
                'learning_paths_title[ar]': {
                    required: true,
                },
                'gallery_title[ar]': {
                    required: true,
                },
                'partners_title[ar]': {
                    required: true,
                },
                'home_menu_title[ar]': {
                    required: true,
                },
                'learning_paths_menu_title[ar]': {
                    required: true,
                },
                'mentors_menu_title[ar]': {
                    required: true,
                },
                'find_your_mate_menu_title[ar]': {
                    required: true,
                },
                'schedule_menu_title[ar]': {
                    required: true,
                },
                'copyright[ar]': {
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

        $(document).on('click', '.update', function () {
            if (!form.valid())
                return false;
            $.ajax({
                url : '{{route($module.'.update')}}',
                data : new FormData(form.get(0)),
                type: "POST",
                processData: false,
                contentType: false,
                beforeSend(){
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: '@lang('constants.please_wait') ...'
                    });
                },
                success:function(data) {
                    if(data.success)
                        showAlertMessage('success', data.message);
                    else
                        showAlertMessage('error', '@lang('constants.unknown_error')');
                    KTApp.unblockPage();
                },
                error:function(data) {
                    console.log(data);
                } ,
                statusCode: {
                    500: function(data) {
                        console.log(data);
                    }
                }
            });
        });

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        $('.update').trigger('click');
                        break;
                }
            }
        });
    </script>
@endsection
