@extends('WS.layouts.main')

@section('title') @lang('ws.gallery') @endsection

@section('body')

    <section class="explore-our-gallery">
        <div class="container">
            <h3 class="font-inter font-bold700" data-aos="fade-down">{{$settings->gallery_title}}</h3>
            <div class="d-flex justify-content-between" data-aos="fade-down">
                <div class="font-inter paragraph ">{{$settings->gallery_description}}</div>
            </div>
            <div class="row flex-wrap container-gallery mb-0">
                @foreach($images as $image)
                    <div class="gallery col-12 col-sm-6 col-lg-4" data-aos="flip-left">
                        <a href="{{$image->path}}" class="fancybox" data-fancybox-group="gallery">
                            <img alt="img" src="{{$image->path}}" class="thumb"/>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

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
