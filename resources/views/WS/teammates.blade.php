@extends('WS.layouts.main')

@section('title') Teammates @endsection
@section('find_mates_active') active @endsection

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

    <section class="find-your-mate">
        <div class="container">
            <div class="d-flex tabs" data-aos="fade-down">
                <h3 class="font-inter font-bold700">{{$settings->find_your_mate_title}}</h3>
            </div>
            <div class="font-inter mb-4 paragraph " data-aos="fade-down">
                {{$settings->find_your_mate_description}}
            </div>
            <div class="mb-3 interests" data-aos="fade-down">
                <div class="d-flex tags flex-wrap mb-5">
                    <a href="{{route('ws.teammates')}}" class="btn tc-black-2 font-inter small-text tag @if(!$interest_id) active @endif">
                        @lang('ws.all')
                    </a>
                    @foreach($interests as $interest)
                        <a href="{{route('ws.teammates', ['interest_id' => $interest->id])}}" class="btn tc-black-2 font-inter small-text tag @if($interest->id == $interest_id) active @endif">
                            {{$interest->name}}
                        </a>
                    @endforeach
                </div>
            </div>
            @if(count($mates))
                <div class="row flex-wrap">
                    @foreach($mates as $mate)
                        <figure class="col-10 col-sm-6 col-md-4 col-lg-3" data-aos="flip-left">
                            <a href="{{route('ws.user_profile', ['id' => $mate->id])}}" style="display: block; background-image: url('{{$mate->full_path_image}}'); background-size: cover; width: 100%; height: 310px"></a>
                            @if($mate->country)
                                <div class="flag">
                                    <img alt="img" src="{{$mate->country->image}}"/>
                                </div>
                            @endif
                            <figcaption class="figure-caption">
                                <div class="font-inter font-bold700 tc-black-2">{{$mate->name}}</div>
                            </figcaption>
                            <div class="d-flex flex-wrap justify-content-between my-2">
                                <div class="d-flex justify-content-between">
                                    @if($mate->instagram)
                                        <div class="profile-icons">
                                            <a href="{{$mate->instagram}}" target="_blank">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mate->facebook)
                                        <div class="profile-icons">
                                            <a href="{{$mate->facebook}}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mate->twitter)
                                        <div class="profile-icons">
                                            <a href="{{$mate->twitter}}" target="_blank">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mate->linkedin)
                                        <div class="profile-icons">
                                            <a href="{{$mate->linkedin}}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($mate->slack)
                                        <div class="profile-icons">
                                            <a href="{{$mate->slack}}" target="_blank">
                                                <i class="fab fa-slack"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="link">
                                    <a href="{{route('ws.user_profile', ['id' => $mate->id])}}" class="btn font-inter font-bold700 d-flex align-items-center s-small" style="color: #9B3B5A !important;">
                                        @lang('ws.view_profile')
                                    </a>
                                </div>
                            </div>
                        </figure>
                    @endforeach
                </div>
            @else
                <section class="learning-path">
                    <div class="container">
                        <div class="alert alert-danger" role="alert">@lang('ws.no_teammates_to_show')</div>
                    </div>
                </section>
            @endif
        </div>
        {{$mates->links('WS.partials.pagination')}}
    </section>

@endsection
