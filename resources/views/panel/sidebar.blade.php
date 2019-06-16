<nav class="navbar navbar-vertical fixed-right navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="./index.html">
            <img src="{{asset('assets/img/brand/blue.png')}}" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="./assets/img/theme/team-1-800x800.jpg">
              </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>My profile</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>Settings</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>Activity</span>
                    </a>
                    <a href="./examples/profile.html" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>Support</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#!" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="./index.html">
                            <img src="{{asset('assets/img/brand/blue.png')}}">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <!--side Navigation -->

            <ul class="navbar-nav pr-0" dir="rtl">
                <li class="nav-item">
                    <strong>
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }} " href="/admin/dashboard">
                            <i class="ni ni-single-02 text-primary pl-4"></i>داشبورد
                        </a>
                    </strong>
                </li>
            </ul>

            <hr class="my-3">
            <ul class="navbar-nav pr-0 active" dir="rtl">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}" href="/admin/products">
                        <i class=" ni ni-single-02 text-primary pl-4"></i>لیست محصولات
                    </a>
                </li>
            </ul>
            {{--<ul class="dropdown-container navbar-nav pr-0 dropdown active" dir="rtl">--}}
                {{--<li class="nav-item nav-link">--}}
                    {{--<strong>نمودار ها</strong>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ request()->is('admin/blood') ? 'active' : '' }}" href="{{route('blood')}}">--}}
                        {{--<i class=" ni ni-single-02 text-primary pl-4"></i>گروه خونی--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ request()->is('admin/age') ? 'active' : '' }}" href="{{route('age')}}">--}}
                        {{--<i class="ni ni-single-02 text-primary pl-4"></i> سن کاربران--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ request()->is('admin/weight') ? 'active' : '' }}" href="{{route('weight')}}">--}}
                        {{--<i class="ni ni-single-02 text-primary pl-4"></i> وزن کاربران--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ request()->is('admin/sleep') ? 'active' : '' }}" href="{{route('sleep')}}">--}}
                        {{--<i class="ni ni-single-02 text-primary pl-4"></i>میانگین زمان خواب--}}
                    {{--</a>--}}
                {{--</li>--}}

                {{--<li class="nav-item">--}}
                    {{--<a class="nav-link {{ request()->is('admin/exercise') ? 'active' : '' }}" href="{{route('exercise')}}">--}}
                        {{--<i class="ni ni-single-02 text-primary pl-4"></i>میانگین زمان ورزش--}}
                    {{--</a>--}}
                {{--</li>--}}

            </ul>

            <hr class="my-3">
            <ul class="navbar-nav pr-0 active" dir="rtl">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="/admin/users">
                        <i class=" ni ni-single-02 text-primary pl-4"></i>لیست کاربران
                    </a>
                </li>
            </ul>

            <hr class="my-3">
            <ul class="navbar-nav pr-0 active" dir="rtl">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="ni ni-single-02 text-primary pl-4"></i>خروج از حساب کاربری
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>

            </ul>


        </div>
    </div>
</nav>