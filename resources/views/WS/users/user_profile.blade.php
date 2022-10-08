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

    <section class="instructorDetailsPageHeader">
        <div class="container">
            <div class="row ">
                <div class="col-md-10">
                    <div class="InstuctorNameImg">
                        <img src="{{$user->full_path_image}}" alt="">
                    </div>
                    <div class="InstructorNameDetails">

                        <h5>{{$user->type == 3 && locale() == 'en' ? $user->name_en : $user->name}}</h5>
                        <p>
                            {{$user->bio}}
                        </p>

                    </div>
                </div>
            </div>
            @if($user->type == 3 && count($user->dates))
                <div class="d-flex justify-content-end margin-left mb-2 request">
                    <button type="submit" class="btn btn-warning" data-toggle="modal"
                            data-target="#exampleModalCenter">@lang('ws.request_for_session')</button>
                </div>
            @endif
        </div>
    </section>

    <section class="InstructorDetailsPage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <table class=" table table-striped instructorDetailsTable ">
                        <tbody>
                        @if($user->work)
                            <tr>
                                <td width="60%" style="padding-left: 30px;">
                                    @lang('ws.job_description')
                                </td>
                                <td width="40%" class="text-center">
                                    {{$user->work}}
                                </td>
                            </tr>
                        @endif
                        @if($user->study)
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.degree') </td>
                                <td class="text-center">
                                    {{$user->study}}
                                </td>
                            </tr>
                        @endif
                        @if($user->gender && in_array($user->gender, [1, 2]))
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.gender')
                                </td>
                                <td class="text-center">
                                    @if($user->gender == 1)
                                        @lang('ws.male')
                                    @else
                                        @lang('ws.female')
                                    @endif
                                </td>
                            </tr>
                        @endif
                        @if(count($user->languages))
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.languages')
                                </td>
                                <td class="text-center">
                                    {{implode(', ', $user->languages->pluck('name')->toArray())}}
                                </td>
                            </tr>
                        @endif
                        @if(count($user->interests))
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.interests')
                                </td>
                                <td class="text-center">
                                    {{implode(', ', $user->interests->pluck('name')->toArray())}}
                                </td>
                            </tr>
                        @endif
                        @if($user->country)
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.nationality')
                                </td>
                                <td class="text-center">
                                    <span>
                                        <i class="countryFlag"><img src="{{$user->country->image}}" alt=""></i>
                                        {{$user->country->name}}
                                    </span>
                                </td>
                            </tr>
                        @endif
                        @if($user->type != 3)
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.dob')
                                </td>
                                <td class="text-center">
                                    {{\Carbon\Carbon::parse($user->dob)->toDateString()}}
                                </td>
                            </tr>
                        @endif
                        @if($user->instagram || $user->facebook || $user->twitter || $user->linkedin || $user->slack)
                            <tr>
                                <td style="padding-left: 30px;">
                                    @lang('ws.social')
                                </td>
                                <td class="text-center">
                                    <ul class=" instructorSocial">
                                        @if($user->facebook)
                                            <li>
                                                <a href="{{$user->facebook}}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                            </li>
                                        @endif
                                        @if($user->instagram)
                                            <li>
                                                <a href="{{$user->instagram}}" target="_blank"><i class="fab fa-instagram"></i></a>
                                            </li>
                                        @endif
                                        @if($user->twitter)
                                            <li>
                                                <a href="{{$user->twitter}}" target="_blank"><i class="fab fa-twitter"></i></a>
                                            </li>
                                        @endif
                                        @if($user->linkedin)
                                            <li>
                                                <a href="{{$user->linkedin}}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                            </li>
                                        @endif
                                        @if($user->slack)
                                            <li>
                                                <a href="{{$user->slack}}" target="_blank"><i class="fab fa-slack"></i></a>
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{route('ws.start_chat', ['id' => $user->id])}}" class="chat instructorChat">
            <i><img src="{{url('/')}}/ws_assets/images/chat.svg" alt=""></i>
        </a>
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
