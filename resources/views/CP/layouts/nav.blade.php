@if(auth()->user()->type == 1)
    <li class="menu-item @yield('dashboard_menu')" aria-haspopup="true">
        <a href="{{route('admin.dashboard')}}" class="menu-link">
            <span class="menu-text">@lang('constants.dashboard')</span>
        </a>
    </li>

    @if(check_permission('users'))
        <li class="menu-item @yield('users_menu')" aria-haspopup="true">
            <a href="{{route('users')}}" class="menu-link">
                <span class="menu-text">@lang('users.title')</span>
            </a>
        </li>
    @endif
    @if(check_permission('phases'))
        <li class="menu-item @yield('phases_menu')" aria-haspopup="true">
            <a href="{{route('phases')}}" class="menu-link">
                <span class="menu-text">@lang('phases.title')</span>
            </a>
        </li>
    @endif
    @if(check_permission('courses'))
        <li class="menu-item @yield('courses_menu')" aria-haspopup="true">
            <a href="{{route('courses')}}" class="menu-link">
                <span class="menu-text">@lang('courses.title')</span>
            </a>
        </li>
    @endif
@endif

@if(auth()->user()->type == 5 || check_permission('user_grades'))
    <li class="menu-item @yield('user_grades_menu')" aria-haspopup="true">
        <a href="{{route('user_grades')}}" class="menu-link">
            <span class="menu-text">@lang('user_grades.title')</span>
        </a>
    </li>
@endif
@if(auth()->user()->type == 5 || check_permission('user_assignments'))
    <li class="menu-item @yield('user_assignments_menu')" aria-haspopup="true">
        <a href="{{route('user_assignments')}}" class="menu-link">
            <span class="menu-text">@lang('user_assignments.title')</span>
        </a>
    </li>
@endif
@if(auth()->user()->type == 5 || check_permission('users_quizzes'))
    <li class="menu-item @yield('users_quizzes_menu')" aria-haspopup="true">
        <a href="{{route('users_quizzes')}}" class="menu-link">
            <span class="menu-text">@lang('users_quizzes.title')</span>
        </a>
    </li>
@endif

@if(auth()->user()->type == 1)
    @if(check_permission('users_courses'))
        <li class="menu-item @yield('users_courses_menu')" aria-haspopup="true">
            <a href="{{route('users_courses')}}" class="menu-link">
                <span class="menu-text">@lang('users_courses.title')</span>
            </a>
        </li>
    @endif
    @if(check_permission('chats'))
        <li class="menu-item @yield('chats_menu')" aria-haspopup="true">
            <a href="{{route('chats')}}" class="menu-link">
                <span class="menu-text">@lang('chats.title')</span>
            </a>
        </li>
    @endif
    @if(check_permission('settings'))
        <li class="menu-item menu-item-submenu menu-item-rel @yield('all_settings_menu')" data-menu-toggle="click" aria-haspopup="true">
            <a href="javascript:;" class="menu-link menu-toggle">
                <span class="menu-text">@lang('settings.title') &nbsp;&nbsp; <i class="fa fa-angle-down"></i></span>
                <span class="menu-desc"></span>
                <i class="menu-arrow"></i>
            </a>
            <div class="menu-submenu menu-submenu-classic menu-submenu-left" style="padding: 10px 0">
                <ul class="menu-subnav">
                    <li class="menu-item @yield('countries_menu')" aria-haspopup="true">
                        <a href="{{route('countries')}}" class="menu-link">
                            <span class="menu-text">@lang('countries.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('sliders_menu')" aria-haspopup="true">
                        <a href="{{route('sliders')}}" class="menu-link">
                            <span class="menu-text">@lang('sliders.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('partners_menu')" aria-haspopup="true">
                        <a href="{{route('partners')}}" class="menu-link">
                            <span class="menu-text">@lang('partners.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('interests_menu')" aria-haspopup="true">
                        <a href="{{route('interests')}}" class="menu-link">
                            <span class="menu-text">@lang('interests.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('languages_menu')" aria-haspopup="true">
                        <a href="{{route('languages')}}" class="menu-link">
                            <span class="menu-text">@lang('languages.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('galleries_menu')" aria-haspopup="true">
                        <a href="{{route('galleries')}}" class="menu-link">
                            <span class="menu-text">@lang('galleries.title')</span>
                        </a>
                    </li>

                    <li class="menu-item @yield('settings_menu')" aria-haspopup="true">
                        <a href="{{route('settings')}}" class="menu-link">
                            <span class="menu-text">@lang('settings.title')</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    @endif
@endif
