
<!DOCTYPE html>
<html lang="en">

<!-- doccure/appointments.html  30 Nov 2019 04:12:09 GMT -->
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- Favicons -->
    <link href="{{asset('doctor/assets/img/favicon.png')}}" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('doctor/assets/css/bootstrap.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('doctor/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('doctor/assets/plugins/fontawesome/css/all.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('doctor/assets/css/style.css')}}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="{{asset('doctor/assets/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('doctor/assets/js/respond.min.js')}}"></script>
    <![endif]-->
    @yield('styles')
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper" id="app">

    <!-- Header -->
    @include('partials.doctorNavbar')
    <!-- /Header -->

    <!-- Breadcrumb -->
   @yield('breadcrumb')
    <!-- /Breadcrumb -->

    <!-- Page Content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                    <!-- Profile Sidebar -->
                    @include('partials.doctorSidebar')
                    <!-- /Profile Sidebar -->

                </div>

                <div class="col-md-7 col-lg-8 col-xl-9">
                   @yield('content')
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->

    <!-- Footer -->
    <footer class="footer">

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container-fluid">

                <!-- Copyright -->
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 text-center">
                            <a href="#" class="text-white">&copy; {{ date('Y')  }} - Invoke Solutions </a>
                        </div>

                    </div>
                </div>
                <!-- /Copyright -->

            </div>
        </div>
        <!-- /Footer Bottom -->

    </footer>
    <!-- /Footer -->

</div>
<!-- /Main Wrapper -->


<!-- jQuery -->
<script src="{{asset('doctor/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

<!-- Bootstrap Core JS -->
<script src="{{asset('doctor/assets/js/popper.min.js')}}"></script>
<script src="{{asset('doctor/assets/js/bootstrap.min.js')}}"></script>

<!-- Sticky Sidebar JS -->
<script src="{{asset('doctor/assets/plugins/theia-sticky-sidebar/ResizeSensor.js')}}"></script>
<script src="{{asset('doctor/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}"></script>
<script src="{{asset('doctor/assets/js/circle-progress.min.js')}}"></script>
<!-- Custom JS -->
<script src="{{asset('doctor/assets/js/script.js')}}"></script>
@yield('scripts')
@if (Session::has('error'))
    <script>
        $(function () {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{Session::get("error")}}'
            })
        });

    </script>
@endif
@if (Session::has('success'))
    <script>
        $(function () {
            Swal.fire('{{Session::get("success")}}')
        });
    </script>
@endif
</body>

<!-- doccure/appointments.html  30 Nov 2019 04:12:09 GMT -->
</html>
