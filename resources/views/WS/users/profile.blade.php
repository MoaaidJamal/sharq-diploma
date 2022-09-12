@extends('WS.layouts.main')

@section('title') @lang('ws.profile') @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/profile_style.css" rel="stylesheet"/>
    <link href="{{url('/')}}/ws_assets/css/userprofile.css" rel="stylesheet"/>
    <style>
        .is-invalid {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('body')
    <section class="h-100" data-aos="fade-down">
        <form action="{{route('ws.profile_post')}}" method="POST" enctype="multipart/form-data" id="form" style="margin: 0">
            @csrf
            <div class="container">
                <div class="container-box"><img src="{{url('/')}}/ws_assets/images/profile/bg-profile.jpeg"/></div>
                <div class="row info-box px-4 justify-content-between" style="margin: 0">
                    <div class="col-lg-6 d-flex justify-content-start align-items-end">
                        <div style="width: 170px; height: 170px">
                            <div class="h-100 w-100">
                                <img class="h-100 w-100" src="{{auth()->user()->full_path_image}}" alt="person" id="profile_image" style="border-radius: 10px"/>
                            </div>
                            <div class="d-flex flex-column add-photo">
                                <div class="upload-btn-wrapper">
                                    <button class="btn"><img alt="icon" src="{{url('/')}}/ws_assets/images/profile/add_a_photo_24px.png"/></button>
                                    <input type="file" name="image" id="image" accept="image/*" @if(!auth()->user()->image) required @endif/>
                                </div>
                            </div>
                        </div>
                        <div class="font-bold700 font-inter text-name">{{auth()->user()->name}}</div>
                    </div>
                </div>
                <!-- tabs -->
                <div>
                    <ul class="nav nav-tabs justify nav-customer rtl" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-btn active" style="text-transform:initial !important;" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile"
                                    type="button" role="tab" aria-controls="profile-tab" aria-selected="true">
                                @lang('ws.profile')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-btn" style="text-transform:initial;" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                    type="button" role="tab" aria-controls="contact-tab" aria-selected="false">
                                @lang('ws.contact_links')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-btn" style="text-transform:initial;" id="contact2-tab" data-bs-toggle="tab" data-bs-target="#reset_password"
                                    type="button" role="tab" aria-controls="contact-tab" aria-selected="false">
                                @lang('ws.account')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-btn" style="text-transform:initial;" id="personality-tab" data-bs-toggle="tab"
                                    data-bs-target="#personality" type="button" role="tab" aria-controls="personality-tab"
                                    aria-selected="false">
                                @lang('ws.personality')
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link nav-btn" style="text-transform:initial;" id="role-tab" data-bs-toggle="tab"
                                    data-bs-target="#role" type="button" role="tab" aria-controls="role-tab" aria-selected="false">
                                @lang('ws.role')
                            </button>
                        </li>
                        @if(auth()->user()->grades)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-btn" style="text-transform:initial;" id="role-tab" data-bs-toggle="tab"
                                        data-bs-target="#grades" type="button" role="tab" aria-controls="role-tab" aria-selected="false">
                                    @lang('ws.grades')
                                </button>
                            </li>
                        @endif
                    </ul>

                    <div class="tab-content" id="myTab">
                        <!-- Profile -->
                        <div class="tab-pane rtl show fade active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="d-flex flex-column mb-0 pb-5">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <h2 class="font-bold700 font-inter my-4">@lang('ws.personal_info')</h2>
                                            <div class="mb-3">
                                                <label for="name" class="form-label font-inter tc-gray-1">@lang('ws.name')</label>
                                                <input type="text" class="form-control font-inter small-text font-bold700" name="name" id="name"
                                                       value="{{auth()->user()->name}}" placeholder="@lang('ws.your_name')">
                                                <div class="text-danger" id="name_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label font-inter tc-gray-1">@lang('ws.email')</label>
                                                <input type="email" class="form-control font-inter small-text font-bold700" name="email" id="email"
                                                       value="{{auth()->user()->email}}" placeholder="@lang('ws.your_email')">
                                                <div class="text-danger" id="email_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label font-inter">@lang('ws.gender')</label>
                                                <div class="d-flex align-items-center tags">
                                                    <div class="form-check p-0 d-flex align-items-center">
                                                        <input class="form-check-input m-auto" type="radio" name="gender" value="1" id="male"
                                                               @if(auth()->user()->gender == 1) checked @endif>
                                                        <label for="male" class="form-check-label font-inter font-bold700">
                                                            @lang('ws.male')
                                                        </label>
                                                    </div>
                                                    <div class="form-check p-0 mx-5 d-flex align-items-center">
                                                        <input class="form-check-input m-auto" type="radio" name="gender" value="2" id="female"
                                                               @if(auth()->user()->gender == 2) checked @endif>
                                                        <label for="female" class="form-check-label font-inter font-bold700">
                                                            @lang('ws.female')
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="text-danger" id="male_error"></div>
                                                <div class="text-danger" id="female_error"></div>
                                            </div>
                                            <div class="mb-3 d-flex flex-column">
                                                <label class="form-label font-inter tc-gray-1">@lang('ws.nationality')</label>
                                                <div class="dropdown">
                                                    <input type="hidden" name="country_id" id="country_id" value="{{auth()->user()->country_id}}"/>
                                                    <input type="checkbox" class="dropdown__switch" id="filter-switch" hidden/>
                                                    <label for="filter-switch" class="dropdown__options-filter">
                                                        <ul class="dropdown__filter" role="listbox" tabindex="-1">
                                                            <li class="dropdown__filter-selected" aria-selected="true">
                                                                @if(auth()->user()->country)
                                                                    <div class="option-img">
                                                                        <img src="{{auth()->user()->country->image}}"/>
                                                                    </div>
                                                                    {{auth()->user()->country->name}}
                                                                @endif
                                                            </li>
                                                            <li>
                                                                <ul class="dropdown__select" style="height: 300px; overflow-y: scroll">
                                                                    @foreach($countries as $country)
                                                                        <li class="dropdown__select-option small-text">
                                                                            <div class="option-img ordersubmitbytable" data-id="{{ $country->id }}"><img
                                                                                    src="{{ $country->image }}"/></div>
                                                                            {{ $country->name }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dob" class="form-label font-inter tc-gray-1 ">@lang('ws.dob')</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                                                    <input type="text" name="dob" id="dob" class="form-control font-inter font-bold700 s-small"
                                                           placeholder="1993-03-21"
                                                           value="{{auth()->user()->dob ? Carbon\Carbon::parse(auth()->user()->dob)->toDateString() : ''}}"
                                                           style="margin: 0; border: none !important;">
                                                </div>
                                                <div class="text-danger" id="dob_error"></div>
                                            </div>
                                            <h2 class="font-bold700 font-inter my-5">@lang('ws.about_me')</h2>
                                            <div class="mb-3">
                                                <label class="form-label font-inter tc-gray-1">@lang('ws.interests')</label>
                                                <div class="d-flex tags flex-wrap">
                                                    @foreach($interests as $key => $interest)
                                                        <input class="checkbox" type="checkbox" name="interests[]" id="interest{{$key}}" value="{{$interest->id}}"
                                                               @if(auth()->user()->interests->contains($interest->id)) checked @endif/>
                                                        <label for="interest{{$key}}" class="tc-black-2 font-inter small-text tag">{{$interest->name}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bio" class="form-label">@lang('ws.bio')</label>
                                                <textarea name="bio" class="form-control font-inter small-text font-bold700" id="bio" rows="4"
                                                          style="resize: none;border: none;border-bottom: 1px solid #00000030 !important;background: none;">{{auth()->user()->bio}}</textarea>
                                                <div class="text-danger" id="bio_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <h2 class="font-bold700 font-inter my-4">@lang('ws.experience')</h2>
                                            <div class="mb-3">
                                                <label for="work" class="form-label font-inter tc-gray-1">@lang('ws.work')</label>
                                                <input type="text" class="form-control font-inter small-text font-bold700" name="work" id="work"
                                                       value="{{auth()->user()->work}}" placeholder="@lang('ws.work')">
                                                <div class="text-danger" id="work_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="study" class="form-label font-inter tc-gray-1">@lang('ws.study')</label>
                                                <input type="text" class="form-control font-inter small-text font-bold700" name="study" id="study"
                                                       value="{{auth()->user()->study}}" placeholder="@lang('ws.study')">
                                                <div class="text-danger" id="study_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label font-inter tc-gray-1">@lang('ws.languages')</label>
                                                <div class="d-flex tags flex-wrap">
                                                    @foreach($languages as $key => $language)
                                                        <input class="checkbox" type="checkbox" name="languages[]" id="language{{$key}}" value="{{$language->id}}"
                                                               @if(auth()->user()->languages->contains($language->id)) checked @endif/>
                                                        <label for="language{{$key}}" class="tc-black-2 font-inter small-text tag">{{$language->name}}</label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-5">
                                    <button class="btn" type="submit">@lang('ws.save_changes')</button>
                                </div>
                            </div>
                        </div>
                        <!-- end profile -->

                        <!-- Contact Links -->
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="d-flex flex-column mb-0 pb-5">
                                <div class="row d-flex justify-content-between">
                                    <h2 class="font-bold700 font-inter my-4 rtl">@lang('ws.contact_links')</h2>
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <label for="slack" class="form-label font-inter tc-gray-1">Slack</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-slack"></i></span>
                                                    <input type="url" class="form-control font-inter small-text" name="slack" id="slack" placeholder="www.slack.com"
                                                           value="{{auth()->user()->slack}}">
                                                </div>
                                                <div class="text-danger" id="slack_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="facebook" class="form-label font-inter tc-gray-1">Facebook</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-facebook-f"></i></span>
                                                    <input type="url" class="form-control font-inter small-text" name="facebook" id="facebook"
                                                           placeholder="www.facebook.com" value="{{auth()->user()->facebook}}">
                                                </div>
                                                <div class="text-danger" id="facebook_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="instagram" class="form-label font-inter tc-gray-1">Instagram</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-instagram"></i></span>
                                                    <input type="url" class="form-control font-inter small-text" name="instagram" id="instagram"
                                                           placeholder="www.instagram.com" value="{{auth()->user()->instagram}}">
                                                </div>
                                                <div class="text-danger" id="instagram_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <label for="twitter" class="form-label font-inter tc-gray-1">Twitter</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-twitter"></i></span>
                                                    <input type="url" class="form-control font-inter small-text" name="twitter" id="twitter"
                                                           placeholder="www.twitter.com" value="{{auth()->user()->twitter}}">
                                                </div>
                                                <div class="text-danger" id="twitter_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="linkedin" class="form-label font-inter tc-gray-1">LinkedIn</label>
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fab fa-linkedin-in"></i></span>
                                                    <input type="url" class="form-control font-inter small-text" name="linkedin" id="linkedin"
                                                           placeholder="www.linkedin.com" value="{{auth()->user()->linkedin}}">
                                                </div>
                                                <div class="text-danger" id="linkedin_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-5">
                                    <button class="btn" type="submit">@lang('ws.save_changes')</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade rtl" id="reset_password" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="d-flex flex-column mb-0 pb-5">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <h2 class="font-bold700 font-inter my-4">@lang('ws.email')</h2>

                                            <div class="mb-3">
                                                <label for="exampleInputEmail" class="form-label font-inter font-bold700">@lang('ws.email')</label>
                                                <div class="input-group mb-3" style="background: #EEEEEE;">
                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope-fill"></i></span>
                                                    <input type="email" disabled class="form-control font-inter small-text" id="exampleInputEmail"
                                                           aria-describedby="emailHelp" placeholder="{{auth()->user()->email}}"
                                                           style="margin: 0; border: 0 !important;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="mx-3">
                                            <h2 class="font-bold700 font-inter my-4">@lang('ws.password')</h2>
                                            <div class="font-inter mb-3 tc-gray-1">
                                                @lang('ws.change_password_desc')
                                            </div>
                                            <div class="mb-3">
                                                <label for="old_password" class="form-label font-inter tc-gray-1">@lang('ws.current_password')</label>
                                                <input type="password" class="form-control font-inter small-text font-bold700" id="old_password" name="old_password">
                                                <div class="text-danger" id="old_password_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label font-inter tc-gray-1">@lang('ws.new_password')</label>
                                                <input type="password" class="form-control font-inter small-text font-bold700" id="password" name="password">
                                                <div class="text-danger" id="password_error"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation"
                                                       class="form-label font-inter tc-gray-1">@lang('ws.new_password_confirmation')</label>
                                                <input type="password" class="form-control font-inter small-text font-bold700" id="password_confirmation"
                                                       name="password_confirmation">
                                                <div class="text-danger" id="password_confirmation_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-5">
                                    <button class="btn" type="submit">@lang('ws.save_changes')</button>
                                </div>
                            </div>
                        </div>
                        <!-- end Contact Links -->

                        <!-- personality -->
                        <div class="tab-pane fade" id="personality" role="tabpanel" aria-labelledby="personality-tab">
                            <div class="d-flex flex-column mb-0 pb-5">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-lg-6 mt-4">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.introvert')</div>
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.extrovert')</div>
                                                </div>
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="content">
                                                            <input type="range" id="introvert" name="extrovert" min="1" max="100"
                                                                   value="{{auth()->user()->extrovert ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.thinking')</div>
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.feeling')</div>
                                                </div>
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="content">
                                                            <input type="range" id="thinking" name="feeling" min="1" max="100" value="{{auth()->user()->feeling ?: 0}}"
                                                                   data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-0 mt-lg-4 ">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.intuition')</div>
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.perceiving')</div>
                                                </div>
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="content">
                                                            <input type="range" id="extrovert" name="perceiving" min="1" max="100"
                                                                   value="{{auth()->user()->perceiving ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.sensing')</div>
                                                    <div class="font-bold600 font-inter text-prog">@lang('ws.intuition')</div>
                                                </div>
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="content">
                                                            <input type="range" id="sensing" name="intuition" min="1" max="100"
                                                                   value="{{auth()->user()->intuition ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end my-5">
                                    <button class="btn" type="submit">@lang('ws.save_changes')</button>
                                </div>
                            </div>
                        </div>
                        <!-- end Personality -->

                        <!-- Role -->
                        <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
                            <div class="d-flex flex-column mb-0 pb-5">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-12 col-lg-6 mt-4">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.maker')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="maker"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-maker" name="maker" min="1" max="100" value="{{auth()->user()->maker ?: 0}}"
                                                                   data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.connector')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="connector"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-connector" name="connector" min="1" max="100"
                                                                   value="{{auth()->user()->connector ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.idea_generator')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="generator"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-generator" name="idea_generator" min="1" max="100"
                                                                   value="{{auth()->user()->idea_generator ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.collaborator')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="collaborator"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-collaborator" name="collaborator" min="1" max="100"
                                                                   value="{{auth()->user()->collaborator ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 mt-0 mt-lg-4">
                                        <div class="mx-3">
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.finisher')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="finisher"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-finisher" name="finisher" min="1" max="100"
                                                                   value="{{auth()->user()->finisher ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.evaluator')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="evaluator"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-evaluator" name="evaluator" min="1" max="100"
                                                                   value="{{auth()->user()->evaluator ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.organiser')
                                                            </div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="organiser"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-organiser" name="organiser" min="1" max="100"
                                                                   value="{{auth()->user()->organiser ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="budget-wrap">
                                                    <div class="budget">
                                                        <div class="header d-flex justify-content-between mb-2">
                                                            <div class="font-bold600 font-inter text-prog">@lang('ws.moderator')</div>
                                                            <div class="font-bold600 font-inter text-prog pull-right" id="moderator"></div>
                                                        </div>
                                                        <div class="content">
                                                            <input type="range" id="range-moderator" name="moderator" min="1" max="100"
                                                                   value="{{auth()->user()->moderator ?: 0}}" data-rangeslider>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end my-5">
                                    <button class="btn" type="submit">@lang('ws.save_changes')</button>
                                </div>
                            </div>
                        </div>
                        <!-- end Role -->

                    @if(auth()->user()->grades)
                        <!-- Role -->
                            <div class="tab-pane fade rtl" id="grades" role="tabpanel" aria-labelledby="role-tab">
                                <div class="d-flex flex-column mb-0 pb-5">
                                    <div class="row d-flex justify-content-between mt-4">
                                        <table class="table table-striped text-center">
                                            <thead>
                                            <tr>
                                                <th>@lang('ws.course_id')</th>
                                                <th>@lang('ws.grade1')</th>
                                                <th>@lang('ws.grade2')</th>
                                                <th>@lang('ws.grade3')</th>
                                                <th>@lang('ws.grade4')</th>
                                                <th>@lang('ws.grade5')</th>
                                                <th>@lang('ws.total')</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(auth()->user()->grades as $item)
                                                <tr>
                                                    <td>{{optional($item->course)->title}}</td>
                                                    <td>{{$item->grade1}}</td>
                                                    <td>{{$item->grade2}}</td>
                                                    <td>{{$item->grade3}}</td>
                                                    <td>{{$item->grade4}}</td>
                                                    <td>{{$item->grade5}}</td>
                                                    <td>{{$item->grade1 + $item->grade2 + $item->grade3 + $item->grade4 + $item->grade5}}</td>
                                                    <td>{{($item->grade1 + $item->grade2 + $item->grade3 + $item->grade4 + $item->grade5) >= 60 ? __('ws.successfully_passed') : __('ws.not_passed')}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end Role -->
                        @endif

                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('js')
    <script src="{{url('/')}}/ws_assets/js/rangeprogress.js"></script>
    <script src="{{url('/')}}/ws_assets/js/select_userprofile.js"></script>
    <script>
        $('#image').change(function () {
            var input = this;
            var url = $(this).val();
            var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
            if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile_image').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                $('#profile_image').attr('src', '/assets/no_preview.png');
            }
        });

        $('#form').validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                country_id: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                bio: {
                    required: true,
                },
                old_password: {
                    required: true,
                    minlength: 6,
                },
                password: {
                    required: true,
                    minlength: 6,
                },
                password_confirmation: {
                    required: true,
                    equalTo: '#password',
                },
            },
            errorElement: 'span',
            ignore: ':hidden:not(#country_id)',
            errorClass: 'help-block help-block-error is-invalid',
            focusInvalid: true,
            errorPlacement: function (error, element) {
                @if(session('redirect_to_home'))
                if ($(element).attr('id') == 'image') {
                    showAlertMessage('error', 'Updating profile image is required');
                    return;
                }
                @endif
                $(element).parents('.input-group').addClass("input-is-invalid");
                $(element).addClass("is-invalid");
                error.appendTo('#' + $(element).attr('id') + '_error');
            },
            success: function (label, element) {
                $(element).parents('.input-group').removeClass("input-is-invalid");
                $(element).removeClass("is-invalid");
            }
        });

        $('#dob').datepicker({
            'format': 'yyyy-mm-dd'
        });
    </script>
@endsection
