<footer>
    <a href="#hero" class="up">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a href="{{route('ws.messages')}}" class="chat">
        <i><img src="{{url('/')}}/ws_assets/images/chat.svg" alt=""></i>
    </a>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul class="footerList d-flex justify-content-around">
                    <li>
                        <a href="{{route('ws.home')}}">
                            {{$settings->home_menu_title}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('ws.modules')}}">
                            {{$settings->learning_paths_menu_title}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('ws.teammates')}}">
                            {{$settings->find_your_mate_menu_title}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('ws.mentors')}}">
                            {{$settings->mentors_menu_title}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('ws.schedule')}}">
                            {{$settings->schedule_menu_title}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row d-flex justify-content-center mt-3">
            <div style="width: fit-content">
                <div class="footerListTitle">
                    {{$settings->follow_us_on_social_media}}
                </div>
                <ul class="socialIcons d-flex justify-content-between">
                    <li>
                        <a href="{{$settings->facebook}}"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li>
                        <a href="{{$settings->twitter}}"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li>
                        <a href="{{$settings->instagram}}"><i class="fab fa-instagram"></i></a>
                    </li>
                    <li>
                        <a href="{{$settings->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<div class="copy">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <div class="left-side">
                    <p>
                        {{$settings->copyright}}
                    </p>
                </div>
                <div class="right-side ">
                    <p>@lang('ws.footer_desc') </p>
                    <div class="copyLogo"><img src="{{url('/')}}/ws_assets/images/footerLogo.svg" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</div>
