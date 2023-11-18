<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title }}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/icon-ayam.png">
    <!-- Custom Stylesheet -->
    <link href="/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header ">
            <div class="brand-logo">
                <a class="p-3" href="#">
                    <b class="logo-abbr"><img src="/assets/images/icon-ayam.png" alt=""> </b>
                    <span class="logo-compact"></span>
                    <span class="brand-title">
                        <p class="text-white text-bold">Sistem Monitoring Gas Berbahaya</p>
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">

                </div>
                <div class="header-right">
                    <ul class="clearfix ">
                        <li class="icons dropdown mt-2 mr-3 m-0 d-flex justify-content-center align-items-center">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                                <b class="text-bold">{{ $user }}</b>
                                <img src="/assets/images/user-png.png" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="/profile"><i class="icon-user"></i>
                                                <span>Profil</span></a>
                                        </li>
                                        <hr class="my-2">
                                        <li><a href="logout"><i class="icon-logout"></i> <span>Keluar</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Dashboard</li>
                    <li>
                        <a href="/home" aria-expanded="false">
                            <i class="fa fa-line-chart" aria-hidden="true"></i><span class="nav-text">Monitoring</span>
                        </a>
                    </li>
                    <li class="nav-label">Data</li>
                    <li>
                        <a href="/riwayat_monitoring" aria-expanded="false">
                            <i class="fa fa-history" aria-hidden="true"></i> <span class="nav-text">Riwayat
                                Monitoring</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'admin')
                        <li>
                            <a href="/user" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i> <span class="nav-text"> Data User</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        @yield('content');


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Developed by <a href="#">Delfan Rynaldo Laden</a> 2023</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="/assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>

    @if (session('success'))
        <script>
            var sweetAlertDemo = function() {
                var initDemo = function() {
                    swal({
                        title: "{{ session('success') }}",
                        text: "{{ session('success') }}",
                        icon: "success",
                        buttons: {
                            confirm: {
                                text: "Oke",
                                value: true,
                                visible: true,
                                className: "btn btn-success",
                                closeModal: true
                            }
                        }
                    });
                };
                return {
                    init: function() {
                        initDemo();
                    },
                };
            }();

            jQuery(document).ready(function() {
                sweetAlertDemo.init();
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            var sweetAlertDemo = function() {
                var initDemo = function() {
                    swal({
                        title: "{{ session('error') }}",
                        text: "{{ session('error') }}",
                        icon: "error",
                        buttons: {
                            confirm: {
                                text: "Oke",
                                value: true,
                                visible: true,
                                className: "btn btn-success",
                                closeModal: true
                            }
                        }
                    });
                };
                return {
                    init: function() {
                        initDemo();
                    },
                };
            }();

            jQuery(document).ready(function() {
                sweetAlertDemo.init();
            });
        </script>
    @endif
    @yield('scripts')
</body>

</html>
