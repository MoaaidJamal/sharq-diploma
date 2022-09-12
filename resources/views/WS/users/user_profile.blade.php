@extends('WS.layouts.main')

@section('title') @lang('ws.teammates') | {{$user->name}} @endsection
@section('style')
    <link href="{{url('/')}}/ws_assets/css/mate.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/profile_style.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/userprofile.css" rel="stylesheet" />
    <link href="{{url('/')}}/ws_assets/css/mate.css" rel="stylesheet" />
    <style>
        .tc-black-2 a {
            color: #0A033C;
            text-decoration: none;
        }

        .fab {
            background: none;
        }
    </style>
@endsection

@section('body')

    <section class="h-100 padding-top" data-aos="fade-down">
        <div class="container">
            <div class="container-box">
                <img src="{{url('/')}}/ws_assets/images/profile/bg-profile.jpeg"/>
            </div>
            <div class="row info-box px-4 justify-content-between">
                <div class="col-lg-8 d-flex flex-column flex-md-row justify-content-start align-items-start align-items-md-end">
                    <div class="h-100">
                        <div class="h-100 profile">
                            <a href="{{$user->full_path_image}}" class="fancybox" data-fancybox-group="gallery">
                                <img src="{{$user->full_path_image}}" alt="person" class="profile-image thumb"/>
                            </a>
                        </div>
                    </div>
                    <h2 class="font-bold700 font-inter text-name">{{$user->type == 3 && locale() == 'en' ? $user->name_en : $user->name}}</h2>
                    @if($user->type == 3 && count($user->dates))
                        <div class="d-flex justify-content-end margin-left mb-2 request">
                            <button type="submit" class="btn font-inter font-bold700" data-toggle="modal"
                                    data-target="#exampleModalCenter">@lang('ws.request_for_session')</button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="tab-pane show fade active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row d-flex justify-content-between">
                    <div class="col-12 col-lg-8 mate">
                        <div class="mx-3">
                            <h2 class="font-bold700 font-inter my-4 rtl">@lang('ws.about') {{explode(' ', $user->type == 3 && locale() == 'en' ? $user->name_en : $user->name)[0]}}</h2>
                            <p class="mb-3 tc-gray font-inter font-bold600 mb-3 mb-md-5 rtl">
                                {{$user->bio}}
                            </p>
                            @if(count($user->interests))
                                <div class="mb-3">
                                    <h2 for="exampleInputEmail1" class="form-label font-inter font-bold700 mb-4">@lang('ws.interests')</h2>
                                    <div class="d-flex tags flex-wrap mb-3 mb-md-5">
                                        @foreach($user->interests as $interest)
                                            <div class="tc-black-2 font-inter small-text tag" style="background-color: white;">
                                                <a href="{{route('ws.teammates', ['interest_id' => $interest->id])}}" target="_blank">
                                                    {{$interest->name}}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 mate2 mb-5 rtl">
                        <div class="mx-3">
                            @if($user->work)
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.job_description'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2">{{$user->work}}</span>
                                </div>
                            @endif
                            @if($user->study)
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.degree'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2">{{$user->study}}</span>
                                </div>
                            @endif
                            @if($user->gender && in_array($user->gender, [1, 2]))
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.gender'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2">
                                        @if($user->gender == 1)
                                            @lang('ws.male')
                                        @else
                                            @lang('ws.female')
                                        @endif
                                    </span>
                                </div>
                            @endif
                            @if(count($user->languages))
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.languages'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2 d-flex" style="padding-left: 10px">{{implode(', ', $user->languages->pluck('name')->toArray())}}</span>
                                </div>
                            @endif
                            @if($user->country)
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.nationality'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2 d-flex">
                                      <div class="flag-ps"><img src="{{$user->country->image}}"/></div>
                                      {{$user->country->name}}
                                    </span>
                                </div>
                            @endif
                            @if($user->type != 3)
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.dob'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2">{{\Carbon\Carbon::parse($user->dob)->toDateString()}}</span>
                                </div>
                            @endif
                            @if($user->instagram || $user->facebook || $user->twitter || $user->linkedin || $user->slack)
                                <div class="d-flex justify-content-between my-4 flex-column flex-sm-row flex-lg-column flex-xxl-row">
                                    <span class="font-bold700 font-inter font18 tc-black-2 mb-2 mb-sm-0" style="padding-right: 20px;">@lang('ws.social'):</span>
                                    <span class="font-bold600 font-inter font18 tc-black-2 d-flex mate2-icon flex-wrap">
                                        @if($user->instagram)
                                            <span class="profile-icons my-2">
                                                <a href="{{$user->instagram}}" target="_blank">
                                                    <i class="bi bi-instagram"></i>
                                                </a>
                                            </span>
                                        @endif
                                        @if($user->facebook)
                                            <span class="profile-icons my-2">
                                                <a href="{{$user->facebook}}" target="_blank">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </span>
                                        @endif
                                        @if($user->twitter)
                                            <span class="profile-icons my-2">
                                                <a href="{{$user->twitter}}" target="_blank">
                                                    <i class="bi bi-twitter"></i>
                                                </a>
                                            </span>
                                        @endif
                                        @if($user->linkedin)
                                            <span class="profile-icons my-2">
                                                <a href="{{$user->linkedin}}" target="_blank">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                            </span>
                                        @endif
                                        @if($user->slack)
                                            <span class="profile-icons my-2">
                                                <a href="{{$user->slack}}" target="_blank">
                                                    <i class="fab fa-slack"></i>
                                                </a>
                                            </span>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(count($user->dates))
        <div class="modal fade mentor" id="exampleModalCenter" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="height: 700px">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body d-flex justify-content-center align-items-center p-0 flex-wrap">
                        <div class="col-12 col-lg-12">
                            <div class="p-4 p-sm-5">
                                <div class="font28 tc-black-1 font-inter font-bold700" style="margin-left: 56px">@lang('ws.request_session_with') {{$user->name}}</div>
                                <p class="font-inter font-bold700 mb-3 s-small tc-gray" style="width: 80%; margin-left: 56px">
                                    {{$user->request_session_description}}
                                </p>
                                <div class="col-12 col-lg-12">
                                    <div class="p-4 p-sm-5">
                                        <form action="{{route('ws.book_session')}}" method="POST" id="session_form">
                                            @csrf
                                            <div class="sessions d-flex flex-column justify-content-between">
                                                <div>
                                                    <div style="margin-top: 45px !important;">
                                                        <div class="d-flex my-0 my-sm-2 flex-wrap">
                                                            @foreach($user->dates as $date)
                                                                <div class="col-12 col-sm-6 my-1 my-sm-0">
                                                                    <input class="radio" type="radio" name="date_id" id="d{{$date->id}}" value="{{$date->id}}"/>
                                                                    <label for="d{{$date->id}}" class="tc-black-2 font-inter small-text tag">{{Carbon\Carbon::parse($date->date_from)->format('Y-m-d H:i')}} &nbsp;&nbsp; - &nbsp;&nbsp; {{Carbon\Carbon::parse($date->date_to)->format('Y-m-d H:i')}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="text-danger is-invalid" id="date_id_error" style="display: none">@lang('ws.choose_session')</div>
                                                    </div>

                                                    <input id="user_id" type="hidden" name="user_id" value="{{$user->id}}" />
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="button" class="btn font-inter font-bold700 book-session">@lang('ws.book_session')</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(".fancybox").jqPhotoSwipe();
            $(".forcedgallery > a").jqPhotoSwipe({
                forceSingleGallery: true
            });
        });

        $(document).on('click', '.book-session', function () {
            if ($('[name=date_id]:checked').val()) {
                $('#date_id_error').hide();
                $('#session_form').submit();
            } else {
                $('#date_id_error').text('Please choose a session').show();
            }
        })
    </script>
@endsection
