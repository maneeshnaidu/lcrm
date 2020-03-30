<div class="container">
    <nav class="navbar navbar-expand-md navbar-light">
        <a class="navbar-brand mt-0" href="{{ url('/') }}">
            @if(isset($settings['app_logo']))
                <img src="{{ asset('front/images/logo_white.png') }}"
                     alt="{{ config('app.name') }}" class="img-responsive site_logo m_auto">
            @endif
        </a>
        <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-bars text-white"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0 navbar-right">
                <li class="sub-menu-parent">
                    <a class="nav-item nav-link link-padding {{ Request::is('/') ? 'active':'' }}" href="{{ url('/') }}">
                        {{ trans('frontend.home') }}
                    </a>
                </li>
                <li>
                    <a class="nav-item nav-link link-padding {{ Request::is('about_us') ? 'active':'' }}" href="{{ url('about_us') }}">
                        {{ trans('frontend.about_us') }}
                    </a>
                </li>
                <li>
                    <a class="nav-item nav-link link-padding {{ Request::is('contactus') ? 'active':'' }}" href="{{ url('contactus') }}">
                        {{ trans('contactus.contactus') }}
                    </a>
                </li>
                <li>
                    <a class="nav-item nav-link link-padding {{ Request::is('blog') || Request::is('blog/*') ||
                                 Request::is('blogitem') || Request::is('blogitem/*') ? 'active':'' }}" href="{{ url('blog') }}">
                        {{ trans('blog.blog') }}
                    </a>
                </li>
                <li>
                    <a class="nav-item nav-link link-padding {{ Request::is('pricing') ? 'active':'' }}" href="{{ url('pricing') }}">
                        {{ trans('frontend.pricing') }}
                    </a>
                </li>
                @if(isset($user))
                    <li class="dropdown show">
                        <a class="dropdown-toggle menu2 text-left nav-item nav-link link-padding portfolio text-white" id="dropdownMenuLink" data-toggle="dropdown">
                            {{ $user->full_name }}
                        </a>
                        <ul id="portfolio"  class="dropdown-menu animated  fadeInUp" aria-labelledby="dropdownMenuLink">
                            <li class="panel-body">
                                <a class="dropdown-item font-weight-bold" href="#">
                                    <div class="user_name_max name_para text-center text-capitalize">{{ $user->full_name }}</div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="panel-body">
                                <a class="dropdown-item" href="{{ $user->inRole('admin') ? url('admin'):url('dashboard') }}">
                                    <i class="fa fa-fw fa-home"></i>
                                    {{trans('left_menu.dashboard')}}
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="panel-body">
                                <a class="dropdown-item" href="{{ url('profile') }}">
                                    <i class="fa fa-fw fa-user"></i>
                                    {{trans('left_menu.my_profile')}}
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="panel-body">
                                <a href="{{ url('logout') }}" class="text-danger dropdown-item">
                                    <i class="fa fa-fw fa-sign-out"></i>
                                    {{trans('left_menu.logout')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a class="nav-item nav-link link-padding text-white {{ Request::is('register') ? 'active':'' }}" href="{{ url('register') }}">
                            {{ trans('frontend.sign_up') }}
                        </a>
                    </li>
                    <li>
                        <a class="nav-item   nav-link link-padding text-white {{ Request::is('signin') ? 'active':'' }}" href="{{ url('signin') }}">
                            {{ trans('frontend.login') }}
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</div>
