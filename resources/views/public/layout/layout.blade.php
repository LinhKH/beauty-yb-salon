<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ settings()->com_name }}</title>
    @include('public/layout/header-links')
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <nav class="navbar navbar-light fixed-top navbar-expand-lg">
                <div class="container-xl container-fluid">
                    <div class="d-flex mb-2 mb-sm-0 me-0 me-md-2 justify-content-between col-12 col-sm-auto">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            @if ($siteInfo->com_logo != '')
                                <img src="{{ asset('/site-img/' . $siteInfo->com_logo) }}" width="160px"
                                    alt="{{ $siteInfo->com_name }}">
                            @else
                                <span>{{ $siteInfo->com_name }}</span>
                            @endif
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse order-3 order-lg-2" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link @if (Request::path() == '/') active @endif"
                                    href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Request::path() == 'service') active @endif"
                                    href="{{ url('service') }}">Our Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Request::path() == 'agent') active @endif"
                                    href="{{ url('agent') }}">Our Team</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if (Request::path() == 'galleries') active @endif"
                                    href="{{ url('galleries') }}">Gallery</a>
                            </li>
                            @php $pages = site_pages(); @endphp
                            @foreach ($pages as $page)
                                @if ($page->show_in_header == '1')
                                    <li class="nav-item">
                                        <a class="nav-link @if (Request::path() == 'page/' . $page->page_slug) active @endif"
                                            href="{{ url('/page/' . $page->page_slug) }}">{{ $page->page_title }}</a>
                                    </li>
                                @endif
                            @endforeach
                            <li class="nav-item">
                                <a class="nav-link @if (Request::path() == 'contact') active @endif"
                                    href="{{ url('contact') }}">Contact</a>
                            </li>
                        </ul>

                    </div>
                    <ul class="d-flex col-12 col-sm-auto header-right-menu justify-content-center order-2 order-lg-3">
                        @if (session()->has('id'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ session()->get('name') }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ url('my_appointment') }}">My Appointment</a>
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('change-password') }}">Change
                                            Password</a></li>
                                    <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ url('login') }}"><i class="fa fa-user"></i></a></li>
                        @endif
                        <li><a href="javascript:void(0)" class="cart newClient-services"><i
                                    class="fa fa-shopping-cart"></i><span class="my-count"></span></a></li>
                        <li><a href=""><i class="fa fa-phone"></i> {{ $siteInfo->com_phone }}</a></li>
                    </ul>
                </div>
            </nav>
            <div class="container-xl container-fluid">
                @if (Request::url('/') == url('/'))
                    @include('public/partials/banner')
                @endif
            </div>
        </header>
        @yield('content')
        <footer id="footer">
            <div class="container mb-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="footer-widget">
                            @if (settings()->com_logo != '')
                                <img class="mb-2" src="{{ asset('/site-img/' . settings()->com_logo) }}"
                                    alt="{{ settings()->com_name }}" width="180px">
                            @else
                                <h5 class="logo text-uppercase mb-4"><a href="#">{{ settings()->com_name }}</a>
                                </h5>
                            @endif
                            <ul class="icon">
                                @foreach ($social_settings as $item)
                                    @if ($item->instagram != '')
                                        <li><a href="{{ $item->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif
                                    @if ($item->you_tube != '')
                                        <li><a href="{{ $item->you_tube }}"><i class="fab fa-youtube"></i></a></li>
                                    @endif
                                    @if ($item->twitter != '')
                                        <li><a href="{{ $item->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if ($item->facebook != '')
                                        <li><a href="{{ $item->facebook }}"><i class="fab fa-facebook"></i></a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="footer-widget">
                            <h6>our services</h6>
                            <ul class="text-capitalize">
                                @php $services = all_services();
                                    $i = 0;
                                @endphp
                                @foreach ($services as $service)
                                    @if ($service->status == '1' && $i < 5)
                                        <li><a href="{{ url('/service/' . $service->slug) }}"><i
                                                    class=" fa fa-angle-right"></i>{{ $service->title }}</a></li>
                                        @php $i++; @endphp
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="footer-widget">
                            <h6>Useful Links</h6>
                            <ul class="text-capitalize">
                                @foreach ($pages as $page)
                                    @if ($page->status == '1' && $page->show_in_footer == '1')
                                        <li><a href="{{ url('page/' . $page->page_slug) }}"><i
                                                    class=" fa fa-angle-right"></i>{{ $page->page_title }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="footer-widget">
                            @php $gallery = footer_gallery();  @endphp
                            <h6>Gallery</h6>
                            <div class="footer-gallery" id="footergallery">
                                @foreach ($gallery as $g_image)
                                    <a href="{{ asset('/gallery/' . $g_image->image) }}"><img
                                            src="{{ asset('/gallery/' . $g_image->image) }}" alt=""></a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-widget footer-section text-center">
                <div class="container">
                    <div class="row">
                        <span>{{ $siteInfo->address_footer }}</span>
                    </div>
                </div>
            </div>
        </footer>
        @include('public.partials.client-services-modal')
    </div>
    @include('public/layout/footer-scripts')
</body>

</html>
