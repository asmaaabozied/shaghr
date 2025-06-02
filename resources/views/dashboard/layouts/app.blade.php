
@include('dashboard.layouts.header')
<body>

<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="../dashboard/crm-index.html" class="logo">
                    <span>
                        <img src="{{asset('style/assets/images/logo-sm.png')}}" alt="logo-small" class="logo-sm">
                    </span>
            <span>
                        <img src="{{asset('style/assets/images/logo.png')}}" alt="logo-large"
                             class="logo-lg logo-light">
                        <img src="{{asset('style/assets/images/logo-dark.png')}}" alt="logo-large" class="logo-lg">
                    </span>
        </a>
    </div>
    <!--end logo-->
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="hidden-sm">
                <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                   href="javascript: void(0);" role="button"
                   aria-haspopup="false" aria-expanded="false">

                    @if(app()->getLocale()=='en')
                    English <img src="{{asset('style/assets/images/flags/us_flag.jpg')}}" class="ml-2" height="16"
                                 alt=""/> <i class="mdi mdi-chevron-down"></i>
                    @else

{{--                        <a class="dropdown-item" href="javascript: void(0);"><span> --}}

                                Arabic <img
                                src="{{asset('style/assets/images/flags/french_flag.jpg')}}" alt="" class="ml-2"
                                height="16"/> <i class="mdi mdi-chevron-down"></i>
                        @endif

                </a>
                <div class="dropdown-menu dropdown-menu-right">


                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                        @if($properties['native']=='English')

                            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"><span> {{ $properties['native'] }} </span><img
                                    src="{{asset('style/assets/images/flags/us_flag.jpg')}}" alt=""
                                    class="ml-2 float-right" height="14"/></a>
                        @else
                            <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"><span> {{ $properties['native'] }} </span><img
                                    src="{{asset('style/assets/images/flags/french_flag.jpg')}}" alt=""
                                    class="ml-2 float-right" height="14"/></a>

                        @endif

                    @endforeach

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                    <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                        Notifications <span class="badge badge-light badge-pill">2</span>
                    </h6>
                    <div class="slimscroll notification-list">
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-primary">
                                    <i class="la la-cart-arrow-down text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">10 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-success">
                                    <i class="la la-group text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Meeting with designers</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">40 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-pink">
                                    <i class="la la-list-alt text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">UX 3 Task complete.</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">1 hr ago</small>
                            <div class="media">
                                <div class="avatar-md bg-warning">
                                    <i class="la la-truck text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 hrs ago</small>
                            <div class="media">
                                <div class="avatar-md bg-info">
                                    <i class="la la-check-circle text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Payment Successfull</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>

            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('style/assets/images/users/user-1.png')}}" alt="profile-user"
                         class="rounded-circle"/>
                    <span class="ml-1 nav-user-name hidden-sm">Amelia <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="ti-power-off text-muted mr-2"></i> Logout</a>
                </div>
            </li>
        </ul><!--end topbar-nav-->

        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <button class="nav-link button-menu-mobile waves-effect waves-light">
                    <i class="ti-menu nav-icon"></i>
                </button>
            </li>
            <li class="hide-phone app-search">
                <form role="search" class="">
                    <input type="text" id="AllCompo" placeholder="Search..." class="form-control">
                    <a href=""><i class="fas fa-search"></i></a>
                </form>
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->


<!-- Left Sidenav -->
@include('dashboard.layouts.sidenav')


<!-- end left-sidenav-->

<div class="page-wrapper">

    <!-- Page Content-->
    <div class="page-content">
        @yield('content')

@include('dashboard.layouts.footer')
