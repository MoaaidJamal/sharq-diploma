@extends('WS.layouts.main')

@section('title')
    @lang('ws.profile')
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('body')
    <form action="{{route('ws.profile_post')}}" method="POST" class="SuggestCourseForm" enctype="multipart/form-data" id="form" style="margin: 0">
        @csrf
        <section class="myProfileHeader">
            <div class="container">
                <div class="row ">
                    <div class="col-md-10">
                        <div class="myProfileHeaderCont">
                            <div class="profileImgCont">
                                <label for="uploadProfImg">
                                    <a href="javascript:;" class="MyProfIcon">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19.807" height="19.5"
                                                 viewBox="0 0 19.807 19.5">
                                                <g id="Image_2" data-name="Image 2" transform="translate(0.75 0.75)">
                                                    <path id="Stroke_1" data-name="Stroke 1"
                                                          d="M13.217,0H4.783C1.842,0,0,2.081,0,5.026v7.947C0,15.919,1.834,18,4.783,18h8.434C16.166,18,18,15.919,18,12.974V5.026C18,2.081,16.166,0,13.217,0Z"
                                                          fill="none" stroke="#761c33" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5"/>
                                                    <path id="Stroke_3" data-name="Stroke 3"
                                                          d="M3.6,1.8A1.8,1.8,0,1,1,1.8,0,1.8,1.8,0,0,1,3.6,1.8Z"
                                                          transform="translate(4.156 4.085)" fill="none" stroke="#761c33"
                                                          stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-miterlimit="10" stroke-width="1.5"/>
                                                    <path id="Stroke_5" data-name="Stroke 5"
                                                          d="M17.025,2.856A22.244,22.244,0,0,0,14.1.327a2.287,2.287,0,0,0-3.083.743c-.746.966-1.212,2.266-2.339,2.876C7.291,4.7,6.476,3.486,5.318,3c-1.292-.541-2.273.432-3.028,1.367S.768,6.23,0,7.157"
                                                          transform="translate(0.975 9.042)" fill="none" stroke="#761c33"
                                                          stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-miterlimit="10" stroke-width="1.5"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                </label>
                                <input type="file" style="cursor: pointer" name="image" accept="image/*" id="uploadProfImg" onchange="readURL(this)">
                                <script>
                                    function readURL(input) {
                                        var $input = input;
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();
                                            reader.onload = function (e) {
                                                $($input).parent().parent().find(".myProfileImg img")
                                                    .attr('src', e.target.result)


                                            };
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>

                                <div class="myProfileImg">
                                    <img src="{{auth()->user()->full_path_image}}" alt="">
                                </div>
                            </div>
                            <div class="ProfNameDetails">
                                <h4>{{auth()->user()->name}}</h4>
                                <p>
                                    {{auth()->user()->bio}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="myCoursesPageSec">
            <div class="coursesTabsSection ">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-pills coursepage-tabs" id="MycoursesTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active Profile-tab" data-toggle="pill" href="#profile" role="tab"
                                       aria-controls="pills-Profile" aria-selected="true"> @lang('ws.profile')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  contactList-tab" data-toggle="pill" href="#contact" role="tab"
                                       aria-controls="pills-contactList" aria-selected="false"> @lang('ws.contact_links')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  Account-tab" data-toggle="pill" href="#reset_password" role="tab"
                                       aria-controls="pills-Account" aria-selected="false">@lang('ws.account')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  Personality-tab" data-toggle="pill" href="#personality" role="tab"
                                       aria-controls="pills-Personality" aria-selected="false">@lang('ws.personality')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  Role-tab" data-toggle="pill" href="#role" role="tab"
                                       aria-controls="pills-Roll" aria-selected="false">@lang('ws.role')</a>
                                </li>
                                @if(auth()->user()->grades)
                                    <li class="nav-item">
                                        <a class="nav-link  ExamInfo-tab" data-toggle="pill" href="#grades" role="tab"
                                           aria-controls="pills-ExamInfo" aria-selected="false">@lang('ws.grades')</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mycoursesTabContainer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-content" id="MycoursesTabContent">
                            <div class="tab-pane show active fade" id="profile" role="tabpanel"
                                 aria-labelledby="Profile-tab">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name_ar">@lang('users.name_ar')</label>
                                        <input type="text" class="form-control" name="name[ar]" id="name_ar"
                                               value="{{auth()->user()->getTranslation('name', 'ar')}}" placeholder="@lang('ws.your_name')">
                                        <div class="text-danger" id="name_ar_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="name_en">@lang('users.name_en')</label>
                                        <input type="text" class="form-control" name="name[en]" id="name_en"
                                               value="{{auth()->user()->getTranslation('name', 'en')}}" placeholder="@lang('ws.your_name')">
                                        <div class="text-danger" id="name_en_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">@lang('users.email')</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                               value="{{auth()->user()->email}}" placeholder="@lang('ws.email')">
                                        <div class="text-danger" id="email_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dob">@lang('ws.dob')</label>
                                        <input type="text" class="datepicker form-control" name="dob" id="dob"
                                               value="{{auth()->user()->dob ? Carbon\Carbon::parse(auth()->user()->dob)->toDateString() : ''}}"
                                               placeholder="1995-12-10">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">@lang('ws.gender')</label>
                                        <select name="gender" id="gender" class="select">
                                            <option disabled selected value="">-</option>
                                            <option value="1" @if(auth()->user()->gender == 1) selected @endif>@lang('ws.male')</option>
                                            <option value="2" @if(auth()->user()->gender == 2) selected @endif>@lang('ws.female')</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="country_id">@lang('ws.nationality')</label>
                                        <select name="country_id" id="country_id" class="select">
                                            <option disabled selected value="">-</option>
                                            @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if(auth()->user()->country_id == $country->id) selected @endif>{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="bio_ar">@lang('users.bio_ar')</label>
                                        <textarea type="text" class="form-control" name="bio[ar]" id="bio_ar"
                                                  placeholder="@lang('users.bio_ar')">{{auth()->user()->getTranslation('bio', 'ar')}}</textarea>
                                        <div class="text-danger" id="bio_ar_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="bio_en">@lang('users.bio_en')</label>
                                        <textarea type="text" class="form-control" name="bio[en]" id="bio_en"
                                                  placeholder="@lang('users.bio_en')">{{auth()->user()->getTranslation('bio', 'en')}}</textarea>
                                        <div class="text-danger" id="bio_en_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="work_ar">@lang('users.work_ar')</label>
                                        <input type="text" class="form-control" name="work[ar]" id="work_ar"
                                               value="{{auth()->user()->getTranslation('work', 'ar')}}" placeholder="@lang('users.work_ar')">
                                        <div class="text-danger" id="work_ar_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="work_en">@lang('users.work_en')</label>
                                        <input type="text" class="form-control" name="work[en]" id="work_en"
                                               value="{{auth()->user()->getTranslation('work', 'en')}}" placeholder="@lang('users.work_en')">
                                        <div class="text-danger" id="work_en_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="study_ar">@lang('users.study_ar')</label>
                                        <input type="text" class="form-control" name="study[ar]" id="study_ar"
                                               value="{{auth()->user()->getTranslation('study', 'ar')}}" placeholder="@lang('users.study_ar')">
                                        <div class="text-danger" id="study_ar_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="study_en">@lang('users.study_en')</label>
                                        <input type="text" class="form-control" name="study[en]" id="study_en"
                                               value="{{auth()->user()->getTranslation('study', 'en')}}" placeholder="@lang('users.study_en')">
                                        <div class="text-danger" id="study_en_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>@lang('ws.languages')</label>
                                        <div class="chooselangCont">
                                            @foreach($languages as $key => $language)
                                                <label for="lang{{$key}}" class="langCheckCont">
                                                    <input type="checkbox" name="languages[]" @if(auth()->user()->languages->contains($language->id)) checked @endif class="langCheckBoxInput" id="lang{{$key}}" value="{{$language->id}}">
                                                    <div class="langCheckBox"><span>{{$language->name}}</span></div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @if(count($interests))
                                        <div class="form-group col-md-6">
                                            <label>@lang('ws.interests')</label>
                                            <div class="ChooseIntrsestBox">
                                                @foreach($interests as $key => $interest)
                                                    <label for="Interset{{$key}}" class="langCheckCont">
                                                        <input type="checkbox" name="interests[]" value="{{$interest->id}}" @if(auth()->user()->interests->contains($interest->id)) checked @endif class="langCheckBoxInput" id="Interset{{$key}}">
                                                        <div class="langCheckBox"><span>{{$interest->name}}</span></div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-12">
                                    <button class="btn sendSuggestBtn" type="submit"><span>@lang('ws.save_changes')</span></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contactList-tab">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="slack">Slack</label>
                                        <input type="url" class="form-control" name="slack" id="slack" placeholder="www.slack.com"
                                               value="{{auth()->user()->slack}}">
                                        <div class="text-danger" id="slack_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="instagram">Instagram</label>
                                        <input type="url" class="form-control" name="instagram" id="instagram" placeholder="www.instagram.com"
                                               value="{{auth()->user()->instagram}}">
                                        <div class="text-danger" id="instagram_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="facebook">Facebook</label>
                                        <input type="url" class="form-control" name="facebook" id="facebook" placeholder="www.facebook.com"
                                               value="{{auth()->user()->facebook}}">
                                        <div class="text-danger" id="facebook_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="linkedin">LinkedIn</label>
                                        <input type="url" class="form-control" name="linkedin" id="linkedin" placeholder="www.linkedin.com"
                                               value="{{auth()->user()->linkedin}}">
                                        <div class="text-danger" id="linkedin_error"></div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="twitter">Twitter</label>
                                        <input type="url" class="form-control" name="twitter" id="twitter" placeholder="www.twitter.com"
                                               value="{{auth()->user()->twitter}}">
                                        <div class="text-danger" id="twitter_error"></div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn sendSuggestBtn" type="submit"><span>@lang('ws.save_changes')</span></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reset_password" role="tabpanel" aria-labelledby="Account-tab">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">@lang('ws.email')</label>
                                        <input type="email" class="form-control" disabled
                                               value="{{auth()->user()->email}}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="old_password">@lang('ws.current_password')</label>
                                            <input type="password" class="form-control" placeholder="@lang('ws.current_password')" id="old_password" name="old_password">
                                            <div class="text-danger" id="old_password_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">@lang('ws.new_password')</label>
                                            <input type="password" class="form-control" placeholder="@lang('ws.new_password')" id="password" name="password">
                                            <div class="text-danger" id="password_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">@lang('ws.new_password_confirmation')</label>
                                            <input type="password" class="form-control" placeholder="@lang('ws.new_password_confirmation')" id="password_confirmation"
                                                   name="password_confirmation">
                                            <div class="text-danger" id="password_confirmation_error"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn sendSuggestBtn" type="submit"><span>@lang('ws.save_changes')</span></button>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="personality" role="tabpanel" aria-labelledby="Personality-tab">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.introvert')</label>
                                            <span>
                                                <input type="text" class="amount" id="introvert" name="extrovert"
                                                       value="{{auth()->user()->extrovert ?: 0}}" readonly
                                                       style="border:0; font-weight:500; display: none;">
                                                @lang('ws.extrovert')
                                            </span>
                                            <div class="slider-range-min"></div>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.thinking')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="thinking" name="feeling"
                                                       value="{{auth()->user()->feeling ?: 0}}"
                                                       style="border:0; font-weight:500; display: none;">
                                                @lang('ws.feeling')
                                            </span>
                                            <div class="slider-range-min"></div>

                                        </div>


                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.intuition')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="extrovert" name="perceiving"
                                                       value="{{auth()->user()->perceiving ?: 0}}"
                                                       style="border:0; font-weight:500; display: none;">
                                                @lang('ws.perceiving')
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.sensing')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="sensing" name="intuition"
                                                       value="{{auth()->user()->intuition ?: 0}}"
                                                       style="border:0; font-weight:500; display: none;">
                                                @lang('ws.intuition')
                                            </span>
                                            <div class="slider-range-min"></div>

                                        </div>


                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn sendSuggestBtn" type="submit"><span>@lang('ws.save_changes')</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="Role-tab">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.maker')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-maker" name="maker"
                                                       value="{{auth()->user()->maker ?: 0}}"
                                                       style="border:0; font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.connector')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-connector" name="connector"
                                                       value="{{auth()->user()->connector ?: 0}}"
                                                       style="border:0; font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.idea_generator')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-generator" name="idea_generator"
                                                       value="{{auth()->user()->idea_generator ?: 0}}"
                                                       style="border:0;  font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.collaborator')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-collaborator" name="collaborator"
                                                       value="{{auth()->user()->collaborator ?: 0}}"
                                                       style="border:0; font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.finisher')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-finisher" name="finisher"
                                                       value="{{auth()->user()->finisher ?: 0}}"
                                                       style="border:0; font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.evaluator')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-evaluator" name="evaluator"
                                                       value="{{auth()->user()->evaluator ?: 0}}"
                                                       style="border:0;  font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.organiser')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-organiser" name="organiser"
                                                       value="{{auth()->user()->organiser ?: 0}}"
                                                       style="border:0;  font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="slidecontainer clearfix">
                                            <label for="">@lang('ws.moderator')</label>
                                            <span>
                                                <input type="text" class="amount" readonly id="range-moderator" name="moderator"
                                                       value="{{auth()->user()->moderator ?: 0}}"
                                                       style="border:0;  font-weight:500;">
                                            </span>
                                            <div class="slider-range-min"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn sendSuggestBtn" type="submit"><span>@lang('ws.save_changes')</span></button>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->grades)
                                <div class="tab-pane fade" id="grades" role="tabpanel" aria-labelledby="ExamInfo-tab">
                                    <div class="row">
                                        <table class="MyMarks table">
                                            <thead>
                                            <tr>
                                                <th>@lang('ws.course_id')</th>
                                                <th>@lang('ws.grade1')</th>
                                                <th>@lang('ws.grade2')</th>
                                                <th>@lang('ws.grade3')</th>
                                                <th>@lang('ws.grade4')</th>
                                                <th>@lang('ws.grade5')</th>
                                                <th>@lang('ws.assignment_grade')</th>
                                                <th>@lang('ws.total')</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach(auth()->user()->grades as $item)
                                                @php
                                                    $assignments = \App\Models\UsersAssignment::query()->where('user_id', $item->user_id)->whereHas('lecture', function ($q) use ($item) {
                                                        $q->where('course_id', $item->course_id);
                                                    })->get();
                                                    $assignments_grade = $assignments->sum('grade') ?: 0;
                                                    $total = $item->grade1 + $item->grade2 + $item->grade3 + $item->grade4 + $item->grade5 + $assignments_grade;
                                                @endphp
                                                <tr>
                                                    <td>{{optional($item->course)->title}}</td>
                                                    <td>{{$item->grade1}}</td>
                                                    <td>{{$item->grade2}}</td>
                                                    <td>{{$item->grade3}}</td>
                                                    <td>{{$item->grade4}}</td>
                                                    <td>{{$item->grade5}}</td>
                                                    @if(count($assignments))
                                                        <td>
                                                            <ul>
                                                                @foreach($assignments as $assignment)
                                                                    <li>{{$assignment->lecture->title}}: {{$assignment->grade}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                    @else
                                                        <td>-</td>
                                                    @endif
                                                    <td>{{$total}}</td>
                                                    <td>{{$total >= 60 ? __('ws.successfully_passed') : __('ws.not_passed')}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
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
            ignore: ':hidden',
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
            'format': 'yyyy-mm-dd',
            endDate: '{{now()->toDateString()}}'
        });


    </script>
@endsection
