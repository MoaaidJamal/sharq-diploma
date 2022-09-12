@extends('WS.layouts.main')

@section('title') @lang('ws.home') @endsection
@section('home_active') active @endsection

@section('body')

    @if(count($sliders))
        <section class="main-section d-flex align-items-center" data-aos="fade-down">
            <div class="container">
                <div id="carouselExampleCaptions" class="carousel slide position-relative" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($sliders as $key => $item)
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$key}}" @if($key == 0) class="active" @endif aria-current="true" aria-label="Slide {{$key+1}}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($sliders as $key => $item)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="h-100"><img src="{{$item->image}}" class="w-100" alt="..."></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="carousel-caption position-absolute top-0 left-0 rtl" style="border-radius: 15px; @if(locale() == 'ar') text-align: right !important; @else text-align: left !important @endif">
                        <div class="d-flex flex-column justify-content-center p-5 w-50 h-100">
                            <h2 class="font-bold700 font-inter my-4" style="margin-top: 370px !important;">{{$settings->header_title}}</h2>
                            <p class="font-bold700 font-inter mb-4">{!! settings('header_description') !!}</p>
                            <div><a class="btn start font-inter font-bold700" href="{{route('ws.modules')}}">@lang('ws.start_learning_now')</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="learning-path" data-aos="fade-down">
        <div class="container font-inter rtl">
            <h3 class="font-bold700 mb-4">{{$settings->home_video_title}}</h3>
            <div>
                {!! settings('home_video_description') !!}
            </div>
            @if(settings('home_video_id'))
                <div class="container-video">
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/{{$settings->home_video_id}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif
        </div>
    </section>

    @if(count($courses))
        <section class="fellowship-program" data-aos="fade-down">
            <div class="container rtl">
                <h2 class="font-inter px-0 d-flex">{{$settings->learning_paths_title}}</h2>
                <div class="font-inter" style="margin-bottom: 15px;">{{$settings->learning_paths_description}}</div>
                <div class="row">
                    @include('WS.partials.courses', ['courses' => $courses])
                </div>
            </div>
        </section>
    @endif

{{--    @if(count($mates))--}}
{{--        <section class="find-your-mate">--}}
{{--            <div class="container" data-aos="fade-down">--}}
{{--                <div class="d-flex justify-content-between tabs">--}}
{{--                    <h3 class="font-inter font-bold700">{{$settings->find_your_mate_title}}</h3>--}}
{{--                    <div>--}}
{{--                        <a href="{{route('ws.teammates')}}" class="btn font-inter font-bold700 d-flex align-items-center" style="color: #9B3B5A !important;">--}}
{{--                            @lang('ws.view_more_team') <i class="bi bi-arrow-right"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="font-inter mb-4 paragraph ">--}}
{{--                    {{$settings->find_your_mate_description}}--}}
{{--                </div>--}}
{{--                <div class="row flex-wrap">--}}
{{--                    @foreach($mates as $mate)--}}
{{--                        <figure class="figure col-12 col-sm-6 col-md-4 col-lg-3" data-aos="flip-left">--}}
{{--                            <a href="{{route('ws.user_profile', ['id' => $mate->id])}}" style="display: block; background-image: url('{{$mate->full_path_image}}'); background-size: cover; width: 100%; height: 310px"></a>--}}
{{--                            @if($mate->country)--}}
{{--                                <div class="flag">--}}
{{--                                    <img alt="img" src="{{$mate->country->image}}"/>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                            <figcaption class="figure-caption">--}}
{{--                                <div class="font-inter font-bold700 tc-black-2">{{$mate->name}}</div>--}}
{{--                            </figcaption>--}}
{{--                            <div class="d-flex flex-wrap justify-content-between my-2">--}}
{{--                                <div class="d-flex justify-content-between">--}}
{{--                                    @if($mate->instagram)--}}
{{--                                        <div class="profile-icons">--}}
{{--                                            <a href="{{$mate->instagram}}" target="_blank">--}}
{{--                                                <i class="bi bi-instagram"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if($mate->facebook)--}}
{{--                                        <div class="profile-icons">--}}
{{--                                            <a href="{{$mate->facebook}}" target="_blank">--}}
{{--                                                <i class="fab fa-facebook-f"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if($mate->twitter)--}}
{{--                                        <div class="profile-icons">--}}
{{--                                            <a href="{{$mate->twitter}}" target="_blank">--}}
{{--                                                <i class="bi bi-twitter"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if($mate->linkedin)--}}
{{--                                        <div class="profile-icons">--}}
{{--                                            <a href="{{$mate->linkedin}}" target="_blank">--}}
{{--                                                <i class="fab fa-linkedin-in"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if($mate->slack)--}}
{{--                                        <div class="profile-icons">--}}
{{--                                            <a href="{{$mate->slack}}" target="_blank">--}}
{{--                                                <i class="fab fa-slack"></i>--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <a href="{{route('ws.user_profile', ['id' => $mate->id])}}" class="btn font-inter font-bold700 d-flex align-items-center s-small" style="color: #9B3B5A !important;">--}}
{{--                                    @lang('ws.view_profile')--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </figure>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    @endif--}}

    @if(count($mentors))
        <section class="popular-instructor wrapper">
            <div>
                <div class="container rtl" data-aos="fade-down">
                    <div class="d-flex justify-content-between tabs">
                        <h3 class="font-inter font-bold700">{{$settings->popular_mentors_title}}</h3>
                        <div>
                            <a href="{{route('ws.mentors')}}" style="color: #9B3B5A !important;" class="btn font-inter font-bold700 d-flex align-items-center"> @lang('ws.view_more_mentors') <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="font-inter mb-4 paragraph ">{{$settings->popular_mentors_description}}</div>
                </div>
                <div class="carousel carousel-slide">
                    @foreach($mentors as $mentor)
                        <div class="px-1" data-aos="flip-left">
                            <a href="{{route('ws.user_profile', ['id' => $mentor->id])}}" class="image-person">
                                <img alt="img" src="{{$mentor->full_path_image}}"
                                     class="figure-img img-fluid rounded">
                            </a>
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
                                            <a href="{{$mate->slack}}" target="_blank">
                                                <i class="fab fa-slack"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{route('ws.user_profile', ['id' => $mentor->id])}}" class="btn font-inter font-bold700 d-flex align-items-center s-small" style="color: #9B3B5A !important;">
                                        @lang('ws.view_profile')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if(count($team))
        <section class="popular-instructor wrapper">
            <div>
                <div class="container rtl" data-aos="fade-down">
                    <div class="d-flex justify-content-between tabs">
                        <h3 class="font-inter font-bold700">@lang('ws.our_team')</h3>
                    </div>
                </div>
                <div class="carousel carousel-slide">
                    @foreach($team as $member)
                        <div class="px-1" data-aos="flip-left">
                            <a href="{{route('ws.user_profile', ['id' => $member->id])}}" class="image-person">
                                <img alt="img" src="{{$member->full_path_image}}"
                                     class="figure-img img-fluid rounded">
                            </a>
                            @if($member->country)
                                <div class="flag">
                                    <img alt="img" src="{{$member->country->image}}"/>
                                </div>
                            @endif
                            <figcaption class="figure-caption">
                                <div class="font-inter font-bold700 tc-black-2">{{$member->name}}</div>
                            </figcaption>
                            <div class="d-flex flex-wrap justify-content-between my-2">
                                <div class="d-flex justify-content-between">
                                    @if($member->instagram)
                                        <div class="profile-icons">
                                            <a href="{{$member->instagram}}" target="_blank">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($member->facebook)
                                        <div class="profile-icons">
                                            <a href="{{$member->facebook}}" target="_blank">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($member->twitter)
                                        <div class="profile-icons">
                                            <a href="{{$member->twitter}}" target="_blank">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($member->linkedin)
                                        <div class="profile-icons">
                                            <a href="{{$member->linkedin}}" target="_blank">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>
                                        </div>
                                    @endif
                                    @if($member->slack)
                                        <div class="profile-icons">
                                            <a href="{{$mate->slack}}" target="_blank">
                                                <i class="fab fa-slack"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <a href="{{route('ws.user_profile', ['id' => $member->id])}}" class="btn font-inter font-bold700 d-flex align-items-center s-small" style="color: #9B3B5A !important;">
                                        @lang('ws.view_profile')
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

{{--    @if(count($gallery))--}}
{{--        <section class="explore-our-gallery" data-aos="fade-down">--}}
{{--            <div class="container">--}}
{{--                <h3 class="font-inter font-bold700 rtl">{{$settings->gallery_title}}</h3>--}}
{{--                <div class="d-flex justify-content-between">--}}
{{--                    <div class="font-inter paragraph ">{{$settings->gallery_description}}</div>--}}
{{--                    <div>--}}
{{--                        <a href="{{route('ws.gallery')}}" class="btn font-inter font-bold700 d-flex align-items-center" style="color: #9B3B5A;"> @lang('ws.view_all') <i class="bi bi-arrow-right"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="row flex-wrap container-gallery mb-0">--}}
{{--                    @foreach($gallery as $file)--}}
{{--                        <div class="gallery col-12 col-sm-6 col-lg-4">--}}
{{--                            <a href="{{$file->path}}" class="fancybox" data-fancybox-group="gallery">--}}
{{--                                <img alt="img" src="{{$file->path}}" class="thumb"/>--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    @endif--}}

    @if(count($partners))
        <section class="our-great-partnars" data-aos="fade-down" style="min-height: auto">
            <div class="container">
                <h3 class="font-inter font-bold700 rtl">{{$settings->partners_title}}</h3>
                <div class="d-flex justify-content-between rtl">
                    <div class="font-inter paragraph ">{{$settings->partners_description}}</div>
                </div>
                <div class="row justify-content-between flex-wrap container-gallery">
                    @foreach($partners as $partner)
                        <a href="{{$partner->url}}" target="_blank" class="photo-logo col-6 col-sm-6 col-lg-3">
                            <img alt="img" src="{{$partner->image}}" style="margin: auto; display: block; max-height: 100%; max-width: 100%; width: auto; height: auto">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
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
    </script>
@endsection
