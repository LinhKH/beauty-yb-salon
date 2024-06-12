<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        @if($siteInfo->com_logo != '')
        <div class="bg-white text-center p-2">
            <img src="{{asset('public/site-img/'.$siteInfo->com_logo)}}" alt="{{$siteInfo->com_name}}" height="60px">
        </div>
        @else
            <span class="brand-text font-weight-bold">{{$siteInfo->com_name}}</span>
        @endif
    </a> 
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="javascript:void(0)" class="d-block">{{session()->get('admin_name')}}</a>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{url('admin/dashboard')}}" class="nav-link {{(Request::path() == 'admin/dashboard')? 'active':''}}">
                    <i class="nav-icon fas fa-home"></i>
                    <p> Dashboard </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/appointment')}}" class="nav-link {{(Request::path() == 'admin/appointment')? 'active':''}}">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>Appointment</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/services')}}" class="nav-link {{(Request::path() == 'admin/services')? 'active':''}}">
                    <i class="nav-icon fa fa-wrench"></i>
                    <p>Services</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/agents')}}" class="nav-link {{(Request::path() == 'admin/agents')? 'active':''}}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Agents</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/client')}}" class="nav-link {{(Request::path() == 'admin/client')? 'active':''}}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Clients</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/time_slot')}}" class="nav-link {{(Request::path() == 'admin/time_slot')? 'active':''}}">
                   <i class="nav-icon fas fa-clock"></i>
                   <p>Time Slot</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{(Request::path() == 'admin/general-settings' || Request::path() == 'admin/profile-settings'|| Request::path() == 'admin/social-settings' || Request::path() == 'admin/banner')? 'menu-open':''}}">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fas fa-image"></i>
                    <p>Gallery<i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('admin/gallery_cat')}}" class="nav-link {{(Request::path() == 'admin/gallery_cat')? 'active bg-primary':''}}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Gallery Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/gallery_img')}}" class="nav-link {{(Request::path() == 'admin/gallery_img')? 'active bg-primary':''}}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Gallery Image</p>
                        </a>
                    </li>
                </ul> 
            </li>
            <li class="nav-item">
                <a href="{{url('admin/pages')}}" class="nav-link {{(Request::path() == 'admin/pages')? 'active':''}}">
                    <i class="nav-icon fas fa-clone"></i>
                    <p>Pages</p>
                </a>
            </li> 
            <li class="nav-item">
                <a href="{{url('admin/payment-method')}}" class="nav-link {{(Request::path() == 'admin/payment-method')? 'active':''}}">
                    <i class="nav-icon fas fa-credit-card"></i>
                    <p>Payment Methods</p>
                </a>
            </li>             
            <li class="nav-item">
                <a href="{{url('admin/contact')}}" class="nav-link {{(Request::path() == 'admin/contact')? 'active':''}}">
                    <i class="nav-icon fa fa-pen"></i>
                    <p>Contact Form</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{url('admin/report')}}" class="nav-link {{(Request::path() == 'admin/report')? 'active':''}}">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Report</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{(Request::path() == 'admin/general-settings' || Request::path() == 'admin/profile-settings' || Request::path() == 'admin/banner' || Request::path() == 'admin/social-settings')? 'menu-open':''}}">
                <a href="javascript:void(0)" class="nav-link">
                    <i class="nav-icon fa fa-wrench"></i>
                    <p> Settings <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{url('admin/general-settings')}}" class="nav-link {{(Request::path() == 'admin/general-settings')? 'active bg-primary':''}}">
                            <i class="fas fa-cogs nav-icon"></i>
                            <p>General Setting</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/profile-settings')}}" class="nav-link {{(Request::path() == 'admin/profile-settings')? 'active bg-primary':''}}">
                            <i class="nav-icon fa fa-user"></i>
                            <p>Profile Setting</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/banner-slider')}}" class="nav-link {{(Request::path() == 'admin/banner-slider')? 'active bg-primary':''}}">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>Banner</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{url('admin/social-settings')}}" class="nav-link {{(Request::path() == 'admin/social-settings')? 'active bg-primary':''}}">
                            <i class="nav-icon fa fa-list"></i>
                            <p>Social Setting</p>
                        </a>
                    </li> 
                </ul> 
            </li>
        </ul>
        <!--  </li>
        </ul> -->
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Control Sidebar -->