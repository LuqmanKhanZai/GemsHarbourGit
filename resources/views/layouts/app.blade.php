<!DOCTYPE html>
<html>

<head>

    <meta char`et="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GEMS HARBOR | @yield('title')</title>

    <link href="{{ asset('admin_file/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/iCheck/custom.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/chosen/bootstrap-chosen.css')}}"
        rel="stylesheet">

    <!-- <link href="css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet"> -->

    <link href="{{ asset('admin_file/css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}"
        rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/cropper/cropper.min.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/jasny/jasny-bootstrap.min.css') }}"
        rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/nouslider/jquery.nouislider.css') }}"
        rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/plugins/ionRangeSlider/ion.rangeSlider.css') }}"
        rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/clockpicker/clockpicker.css') }}"rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/select2/select2.min.css" rel="stylesheet') }}">
    <link href="{{ asset('admin_file/css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/plugins/dualListbox/bootstrap-duallistbox.min.css') }}" rel="stylesheet">
    <!-- FooTable -->
    <link href="{{ asset('admin_file/css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/style.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{asset('admin_file/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{asset('admin_file/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">

</head>

<body>
    {{-- FOr SWeet Alert --}}
    @include('sweetalert::alert')
    {{-- FOr SWeet Alert --}}
    <div id="wrapper">


        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span>
                                <img alt="image" style="width:100%;"  src="{{ asset('admin_file/img/gems_logo.png') }}" />
                            </span>
                        </div>
                    </li>

                    <li class="{{Request::is(['home','home/*']) ? 'active' : ''}}">
                        <a href="{{url('home')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span> </a>
                    </li>

                    <li class="{{Request::is(['buyer/*','seller/*','supplier/*','bank/*']) ? 'active' : ''}}">
                        <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Accounts</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{Request::is(['buyer/index','buyer/index/*']) ? 'active' : ''}}"><a href="{{route('buyer.index')}}">Buyer Account</a></li>
                            <li class="{{Request::is(['seller/index','seller/index/*']) ? 'active' : ''}}"><a href="{{route('seller.index')}}">Seller Account</a></li>
                        </ul>
                    </li>

                    <!-- <li class="{{Request::is(['chart/*','sub_chart/*']) ? 'active' : ''}}">
                        <a href="#"><i class="fa fa-folder-o"></i> <span class="nav-label">Accounts</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{Request::is(['chart','chart/*']) ? 'active' : ''}}"><a href="#">Chart of account</a></li>
                            <li class="{{Request::is(['sub_chart','sub_chart/*']) ? 'active' : ''}}"><a href="#">Main Sub Chart</a></li>
                        </ul>
                    </li> -->

                    <li class="{{Request::is(['category','category/*']) ? 'active' : ''}}">
                        <a href="{{route('category.index')}}"><i class="fa fa-star"></i> <span class="nav-label">Category</span> </a>
                    </li>

                    <li class="{{Request::is(['store','store/*']) ? 'active' : ''}}">
                        <a href="{{route('store.index')}}"><i class="fa fa-star"></i> <span class="nav-label">Store</span> </a>
                    </li>

                    <li class="{{Request::is(['product/*','product/*']) ? 'active' : ''}}">
                        <a href="#"><i class="fa fa-folder-o"></i> <span class="nav-label">Products</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li class="{{Request::is(['product/create','product/create/*']) ? 'active' : ''}}"><a href="{{route('product.create')}}">Add Product</a></li>
                            <li class="{{Request::is(['product/index','product/index/*']) ? 'active' : ''}}"><a href="{{route('product.index')}}">Product List</a></li>
                        </ul>
                    </li>

                    <li class="{{Request::is(['contact','contact/*']) ? 'active' : ''}}">
                        <a href="{{route('contact')}}"><i class="fa fa-envelope"></i> <span class="nav-label">Contact</span> </a>
                    </li>

                    {{-- <li class="{{Request::is(['product','product/*']) ? 'active' : ''}}">
                        <a href="{{route('product.index')}}"><i class="fa fa-star"></i> <span class="nav-label">Product</span> </a>
                    </li> --}}

                    <li class="{{Request::is(['admin','profile/*']) ? 'active' : ''}}">
                        <a href="{{route('admin.profile')}}"><i class="fa fa-star"></i> <span class="nav-label">My Profile</span> </a>
                    </li>

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                        <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control"
                                    name="top-search" id="top-search">
                            </div>
                        </form> -->
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome To GEMS HARBOR</span>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                            </a>
                            <ul class="dropdown-menu dropdown-messages">
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="{{asset('admin_file/img/a7.jpg')}}">
                                        </a>
                                        <div>
                                            <small class="pull-right">46h ago</small>
                                            <strong>Mike Loreipsum</strong> started following <strong>Monica
                                                Smith</strong>. <br>
                                            <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="{{asset('admin_file/img/a4.jpg')}}">
                                        </a>
                                        <div>
                                            <small class="pull-right text-navy">5h ago</small>
                                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica
                                                Smith</strong>. <br>
                                            <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="dropdown-messages-box">
                                        <a href="profile.html" class="pull-left">
                                            <img alt="image" class="img-circle" src="{{asset('admin_file/img/profile.jpg')}}">
                                        </a>
                                        <div>
                                            <small class="pull-right">23h ago</small>
                                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                            <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="mailbox.html">
                                            <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                            </a>
                            <ul class="dropdown-menu dropdown-alerts">
                                <li>
                                    <a href="mailbox.html">
                                        <div>
                                            <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="profile.html">
                                        <div>
                                            <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                            <span class="pull-right text-muted small">12 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="grid_options.html">
                                        <div>
                                            <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                            <span class="pull-right text-muted small">4 minutes ago</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <div class="text-center link-block">
                                        <a href="notifications.html">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>


                        <li>
                            <a  href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                               <i class="fa fa-sign-out"></i>  {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>

                        </li>
                        <li>
                            <a class="right-sidebar-toggle">
                                <i class="fa fa-tasks"></i>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="wrapper wrapper-content">

               @yield('content')

            </div>

            <div class="footer">
                <div class="pull-right">
                    10GB of <strong>250GB</strong> Free.
                </div>
                <div>
                    <strong>Copyright</strong> Example Company &copy; 2022-2024
                </div>
            </div>
        </div>

        <div id="right-sidebar">
            <div class="sidebar-container">

                <ul class="nav nav-tabs navs-3">

                    <li class="active"><a data-toggle="tab" href="#tab-1">
                            Notes
                        </a></li>
                    <li><a data-toggle="tab" href="#tab-2">
                            Projects
                        </a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3">
                            <i class="fa fa-gear"></i>
                        </a></li>
                </ul>

                <div class="tab-content">


                    <div id="tab-1" class="tab-pane active">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
                            <small><i class="fa fa-tim"></i> You have 10 new message.</small>
                        </div>

                        <div>

                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a1.jpg')}}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">

                                        There are many variations of passages of Lorem Ipsum available.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a1.jpg')}}">
                                    </div>
                                    <div class="media-body">
                                        The point of using Lorem Ipsum is that it has a more-or-less normal.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a3.jpg')}}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        Mevolved over the years, sometimes by accident, sometimes on purpose (injected
                                        humour and the like).
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a4.jpg')}}">
                                    </div>

                                    <div class="media-body">
                                        Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a8.jpg')}}">
                                    </div>
                                    <div class="media-body">

                                        All the Lorem Ipsum generators on the Internet tend to repeat.
                                        <br>
                                        <small class="text-muted">Today 4:21 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a7.jpg')}}">
                                    </div>
                                    <div class="media-body">
                                        Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..",
                                        comes from a line in section 1.10.32.
                                        <br>
                                        <small class="text-muted">Yesterday 2:45 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a3.jpg')}}">

                                        <div class="m-t-xs">
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                            <i class="fa fa-star text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                                        <br>
                                        <small class="text-muted">Yesterday 1:10 pm</small>
                                    </div>
                                </a>
                            </div>
                            <div class="sidebar-message">
                                <a href="#">
                                    <div class="pull-left text-center">
                                        <img alt="image" class="img-circle message-avatar" src="{{asset('admin_file/img/a4.jpg')}}">
                                    </div>
                                    <div class="media-body">
                                        Uncover many web sites still in their infancy. Various versions have.
                                        <br>
                                        <small class="text-muted">Monday 8:37 pm</small>
                                    </div>
                                </a>
                            </div>
                        </div>

                    </div>

                    <div id="tab-2" class="tab-pane">

                        <div class="sidebar-title">
                            <h3> <i class="fa fa-cube"></i> Latest projects</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <ul class="sidebar-list">
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary pull-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Business valuation</h4>
                                    It is a long established fact that a reader will be distracted.

                                    <div class="small">Completion with: 22%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
                                    </div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Contract with Company </h4>
                                    Many desktop publishing packages and web page editors.

                                    <div class="small">Completion with: 48%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 48%;" class="progress-bar"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="small pull-right m-t-xs">9 hours ago</div>
                                    <h4>Meeting</h4>
                                    By the readable content of a page when looking at its layout.

                                    <div class="small">Completion with: 14%</div>
                                    <div class="progress progress-mini">
                                        <div style="width: 14%;" class="progress-bar progress-bar-info"></div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary pull-right">NEW</span>
                                    <h4>The generated</h4>
                                    <!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
                                    There are many variations of passages of Lorem Ipsum available.
                                    <div class="small">Completion with: 22%</div>
                                    <div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
                                </a>
                            </li>

                        </ul>

                    </div>

                    <div id="tab-3" class="tab-pane">

                        <div class="sidebar-title">
                            <h3><i class="fa fa-gears"></i> Settings</h3>
                            <small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
                        </div>

                        <div class="setings-item">
                            <span>
                                Show notifications
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example">
                                    <label class="onoffswitch-label" for="example">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Disable Chat
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox"
                                        id="example2">
                                    <label class="onoffswitch-label" for="example2">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Enable history
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example3">
                                    <label class="onoffswitch-label" for="example3">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Show charts
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example4">
                                    <label class="onoffswitch-label" for="example4">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Offline users
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example5">
                                    <label class="onoffswitch-label" for="example5">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Global search
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example6">
                                    <label class="onoffswitch-label" for="example6">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>
                                Update everyday
                            </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox"
                                        id="example7">
                                    <label class="onoffswitch-label" for="example7">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-content">
                            <h4>Settings</h4>
                            <div class="small">
                                I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting
                                industry.
                                And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                since the 1500s.
                                Over the years, sometimes by accident, sometimes on purpose (injected humour and the
                                like).
                            </div>
                        </div>

                    </div>
                </div>

            </div>



        </div>

    </div>

    {{-- @include('layouts.footer_links') --}}

    <!-- Mainly scripts -->
    <script src="{{ asset('admin_file/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('admin_file/js/bootstrap.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('admin_file/js/inspinia.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/dataTables/datatables.min.js') }}"></script>
    <!-- Chosen -->
    <script src="{{ asset('admin_file/js/plugins/chosen/chosen.jquery.js') }}"></script>
    <!-- JSKnob -->
    <script src="{{ asset('admin_file/js/plugins/jsKnob/jquery.knob.js') }}"></script>
    <!-- Input Mask-->
    <script src="{{ asset('admin_file/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('admin_file/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- NouSlider -->
    <script src="{{ asset('admin_file/js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('admin_file/js/plugins/switchery/switchery.js') }}"></script>
    <!-- IonRangeSlider -->
    <script src="{{ asset('admin_file/js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ asset('admin_file/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- MENU -->
    <script src="{{ asset('admin_file/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <!-- Color picker -->
    <script src="{{ asset('admin_file/js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Clock picker -->
    <script src="{{ asset('admin_file/js/plugins/clockpicker/clockpicker.js') }}"></script>
    <!-- Image cropper -->
    <script src="{{ asset('admin_file/js/plugins/cropper/cropper.min.js') }}"></script>
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="{{ asset('admin_file/js/plugins/fullcalendar/moment.min.js') }}"></script>
    <!-- Date range picker -->
    <script src="{{ asset('admin_file/js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('admin_file/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- TouchSpin -->
    <script src="{{ asset('admin_file/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- Tags Input -->
    <script src="{{ asset('admin_file/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <!-- Dual Listbox -->
    <script src="{{ asset('admin_file/js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/flot/jquery.flot.time.js') }}"></script>
    <!-- Peity -->
    <script src="{{ asset('admin_file/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admin_file/js/demo/peity-demo.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('admin_file/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Jvectormap -->
    <script src="{{ asset('admin_file/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin_file/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- EayPIE -->
    <script src="{{ asset('admin_file/js/plugins/easypiechart/jquery.easypiechart.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('admin_file/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Sparkline demo data  -->
    <script src="{{ asset('admin_file/js/demo/sparkline-demo.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('admin_file/js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- FooTable -->
    <script src="{{ asset('admin_file/js/plugins/footable/footable.all.min.js') }}"></script>
    {{-- FOR All Js Code of Layout Page --}}
    <script src="{{ asset('admin_file/js/layout.js') }}"></script>
    <!-- Toastr -->
    <script src="{{asset('admin_file/js/plugins/toastr/toastr.min.js')}}"></script>
    <!-- Sweet alert -->
    <script src="{{asset('admin_file/js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    {{-- Data table --}}
    <script src="{{ asset('admin_file/js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{asset('admin_file/js/plugins/clockpicker/clockpicker.js')}}"></script>
    {{-- <script  src="{{asset('admin_file/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script> --}}

    <script>

        // This Table Is For Transaction
        $(document).ready(function() {
            $('.footable').footable();
            $('.footable2').footable();
        });

        $(document).ready(function(){
            $('.chosen-select').chosen({width: "100%"});
            $('.clockpicker').clockpicker();

            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
        });
    </script>

    @if(Session::has('success'))
        <script>
            $(document).ready(function(){
                toastr.success("{!!Session::get('success')!!}");
            });
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            $(document).ready(function(){
                toastr.error("{!!Session::get('error')!!}")
            });
        </script>
    @endif

    <script>
        $("#form").validate({
            rules: {
                // Employeee Customr Supplier
                name: {
                    required: true,
                    minlength: 3
                },
                image: {
                    required: true,
                },
                contact: {
                    required: true,
                },
                salary:{
                    required : true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                },
                identity:{
                    required : true,
                },
                address:{
                    required : true,
                },
                // Expenses HEad
                description:{
                    required : true,
                    minlength: 50
                },

                // Expense
                date:{
                    required : true,
                },
                amount:{
                    required : true,
                },
                paid_by:{
                    required : true,
                },
                paid_from:{
                    required : true,
                },
                exp_type_id: {
                    required: true,
                },

                // Cash Recipt Bank Recipet Cash Payment Bank Payment
                sub_chart_credit:{
                    required : true,
                },
                sub_chart_debit:{
                    required : true,
                },

                // Sub Cahrt Account
                chart_id:{
                    required : true,
                },

                experience:{
                    required : true,
                },
                // 'speciality[]':{
                //     required : true,
                // },


            },
            messages: {
                name: {
                    required: "Name is required"
                },
                image: {
                    required: "Image is required"
                },
                cat_id: {
                    required: "Category is required"
                },
                // contact: {
                //     required: "Contact is required"
                // },
                // email: {
                //     required: "Email is required"
                // },
                // password: {
                //     required: "Contact is required"
                // },
                // gender: {
                //     required: "Gender is required"
                // },
                // date_of_birth: {
                //     required: "Date Of Birth is required"
                // },
                'speciality[]': {
                    required: "Speciality is required"
                },
            }
        });
    </script>

    @yield('script')

</body>

</html>
