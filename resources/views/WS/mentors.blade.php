@extends('WS.layouts.main')

@section('title') @lang('ws.mentors') @endsection
@section('mentors_active') active @endsection

@section('style')
    <link rel="stylesheet" href="{{url('/')}}/ws_assets/css/find-your-mate.css">
    <style>
        .small-text.tag.active {
            background-color: rgb(155, 59, 90);
            color: white;
        }
        .small-text.tag {
            background-color: white;
        }
    </style>
@endsection

@section('body')

    <section class="find-your-mate rtl">
        <div class="container">
            <div class="d-flex tabs" data-aos="fade-down">
                <h3 class="font-inter font-bold700">{{$settings->popular_mentors_title}}</h3>
            </div>
            <div class="font-inter mb-4 paragraph " data-aos="fade-down">
                {{$settings->popular_mentors_description}}
            </div>
            @if(count($mentors))
                <div class="row flex-wrap">
                    @foreach($mentors as $mentor)
                        <figure class="col-10 col-sm-6 col-md-4 col-lg-3" data-aos="flip-left">
                            <a href="{{route('ws.user_profile', ['id' => $mentor->id])}}" style="display: block; background-image: url('{{$mentor->full_path_image}}'); background-size: cover; width: 100%; height: 310px"></a>
                            @if($mentor->country)
                                <div class="flag">
                                    <img alt="img" src="{{$mentor->country->image}}"/>
                                </div>
                            @endif
                            <figcaption class="figure-caption">
                                <div class="font-inter font-bold700 tc-black-2">{{locale() == 'ar' ? $mentor->name : $mentor->name_en}}</div>
                            </figcaption>
                            <div class="d-flex flex-wrap justify-content-between my-2">
                                <div class="d-flex justify-content-between">
                                    @if($mentor->instagram)
                                        <div class="profile-icons">
                                            <a href="{{$mentor->instagram}}" target="_blank">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mentor->facebook)
                                        <div class="profile-icons">
                                            <a href="{{$mentor->facebook}}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mentor->twitter)
                                        <div class="profile-icons">
                                            <a href="{{$mentor->twitter}}" target="_blank">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mentor->linkedin)
                                        <div class="profile-icons">
                                            <a href="{{$mentor->linkedin}}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mentor->slack)
                                        <div class="profile-icons">
                                            <a href="{{$mentor->slack}}" target="_blank">
                                                <i class="fab fa-slack"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="link">
                                    <a href="{{route('ws.user_profile', ['id' => $mentor->id])}}" class="btn font-inter font-bold700 d-flex align-items-center s-small" style="color: #9B3B5A !important;">
                                        View Profile
                                    </a>
                                </div>
                            </div>
                        </figure>
                    @endforeach
                </div>
            @else
                <section class="learning-path">
                    <div class="container">
                        <div class="alert alert-danger" role="alert">@lang('ws.no_mentors')</div>
                    </div>
                </section>
            @endif
        </div>
        {{$mentors->links('WS.partials.pagination')}}
    </section>

@endsection
