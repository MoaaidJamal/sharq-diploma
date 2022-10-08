<header>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('/')}}/assets/images/logo.png" alt="" style="width: 150px"></a>
                    <div class="mobileBtns">

                        <div class="profContainer dropdown">
                            <a href="javascript:;" class="profileSec " data-toggle="dropdown" id="dropProfile"
                               aria-haspopup="true" aria-expanded="true">
                                <div class="profileImg">
                                    <img src="{{auth()->user()->full_path_image}}" alt="" style="max-height: 40px">
                                </div>
                                <span>{{auth()->user()->name}}</span>
                            </a>
                            <div class="profileDropDown  publicProfileDropDown dropdown-menu"
                                 aria-labelledby="dropProfile">
                                <div class="arrow-up"></div>
                                <ul>
                                    @if(in_array(auth()->user()->type, [1, 5]))
                                        <li>
                                            <a class="singlenotifyLink clearfix" href="{{auth()->user()->type == 1 ? route('admin.dashboard') : route('user_grades')}}">@lang('ws.dashboard')</a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="singlenotifyLink clearfix" href="{{route('ws.profile')}}">@lang('ws.my_profile')</a>
                                    </li>
                                    <li>
                                        <a class="singlenotifyLink clearfix" href="{{route('ws.logout')}}">@lang('ws.logout')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <i></i>
                            <i></i>
                            <i></i>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item @yield('home_active')">
                                <a class="nav-link" href="{{route('ws.home')}}">{{$settings->home_menu_title}}</a>
                            </li>
                            <li class="nav-item @yield('module_active')">
                                <a class="nav-link" href="{{route('ws.modules')}}">{{$settings->learning_paths_menu_title}}</a>
                            </li>
                            <li class="nav-item @yield('find_mates_active')">
                                <a class="nav-link" href="{{route('ws.teammates')}}">{{$settings->find_your_mate_menu_title}}</a>
                            </li>
                            <li class="nav-item @yield('mentors_active')">
                                <a class="nav-link" href="{{route('ws.mentors')}}">{{$settings->mentors_menu_title}}</a>
                            </li>
                            <li class="nav-item @yield('schedule_active')">
                                <a class="nav-link" href="{{route('ws.schedule')}}">{{$settings->schedule_menu_title}}</a>
                            </li>
                        </ul>
                        <div class="profNotifyDescktop">
                            <div class="langCont">
                                <a class=" btn joinBtn langBtn" href="{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL(locale() == 'ar' ? 'en' : 'ar', null, [], true)}}" id="langDropDown">
                                    <span>{{locale() == 'ar' ? 'EN' : 'ع'}}</span>
                                </a>
                            </div>
                            <div class="profContainer dropdown">
                                <a href="javascript:;" class="profileSec " data-toggle="dropdown" id="dropProfile"
                                   aria-haspopup="true" aria-expanded="true">
                                    <div class="profileImg">
                                        <img src="{{auth()->user()->full_path_image}}" alt="" style="max-height: 40px">
                                    </div>
                                    <span>{{auth()->user()->name}}</span>
                                </a>
                                <div class="profileDropDown  publicProfileDropDown dropdown-menu"
                                     aria-labelledby="dropProfile">
                                    <div class="arrow-up"></div>
                                    <ul>
                                        @if(in_array(auth()->user()->type, [1, 5]))
                                            <li>
                                                <a href="{{auth()->user()->type == 1 ? route('admin.dashboard') : route('user_grades')}}">@lang('ws.dashboard')</a>
                                            </li>
                                        @endif
                                        <li>
                                            <a href="{{route('ws.profile')}}">@lang('ws.my_profile')</a>
                                        </li>
                                        <li>
                                            <a href="{{route('ws.logout')}}">@lang('ws.logout')</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>
