@extends('WS.layouts.main')

@section('title') @lang('ws.home') @endsection
@section('home_active') active @endsection

@section('body')

    @if(count($sliders))
        <section class="hero" id="hero">
            <div class="owl-carousel heroSlider">
                @foreach($sliders as $slider)
                    <div class="heroSliderItem" style="background-image: url('{{$slider->image}}');">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="heroText">
                                        <h1>
                                            {{$settings->header_title}}
                                        </h1>
                                        <span>
                                            {!! settings('header_description') !!}
                                        </span>
                                        <a href="{{route('ws.modules')}}" class="btn joinBtn"><span>@lang('ws.start_learning_now')</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if(count($courses))
        <section class="diplomaProgram pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="sectionTitle">
                            <h5>{{$settings->learning_paths_title}}</h5>
                            <p>{{$settings->learning_paths_description}}</p>
                        </div>
                        @include('WS.partials.courses', ['courses' => $courses])
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($settings->home_video_id)
        <section class="joinSec">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="joinDeplomaImg clearfix">
                            <img src="{{url('/')}}/ws_assets/images/Union 1.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sectionTitle">
                            <h5>{{$settings->home_video_title}}</h5>
                        </div>
                        <p>
                            {!! $settings->home_video_description !!}
                        </p>
                        <a href="https://www.youtube.com/watch?v={{$settings->home_video_id}}" target="_blank" class="viewVideoBtn btn">
                            <span>
                                <div class="playvideoIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14.781" height="17.727" viewBox="0 0 14.781 17.727">
                                        <path id="Stroke_3" data-name="Stroke 3"
                                              d="M12.831,9.87a37.09,37.09,0,0,1-9.27,6.324,9.906,9.906,0,0,1-1.651.532,1.253,1.253,0,0,1-1.141-.671,13.029,13.029,0,0,1-.413-1.713A41.29,41.29,0,0,1,0,8.366,38.852,38.852,0,0,1,.393,2.186C.463,1.8.666.906.726.762A1.237,1.237,0,0,1,1.288.15,1.229,1.229,0,0,1,1.91,0,8.679,8.679,0,0,1,3.34.443a36.758,36.758,0,0,1,9.467,6.386c.169.182.634.669.711.768a1.247,1.247,0,0,1,.027,1.5C13.463,9.206,12.988,9.7,12.831,9.87Z"
                                              transform="translate(0.5 0.5)" fill="none" stroke="#761C33"
                                              stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                              stroke-width="1"></path>
                                    </svg>
                                </div> @lang('ws.view_video')
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($mentors))
        <section class="Instructors">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="sectionTitle">
                            <h5>{{$settings->popular_mentors_title}}</h5>
                            <p>{{$settings->popular_mentors_description}}</p>
                        </div>
                        <div class="InstructorsSlider owl-carousel">
                            @foreach($mentors as $mentor)
                                @include('WS.users.user_card', ['user' => $mentor])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if(count($partners))
        <section class="partners">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="sectionTitle">
                            <h5>{{$settings->partners_title}}</h5>
                            <p>{{$settings->partners_description}}</p>
                        </div>
                        <div class="partnerSlider owl-carousel">
                            @foreach($partners as $partner)
                                <div class="partnerBox">
                                    <div class="partnerImg">
                                        <a href="{{$partner->url}}" target="_blank">
                                            <img alt="img" src="{{$partner->image}}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection
