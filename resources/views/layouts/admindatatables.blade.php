
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/appointment-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:46 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mining Clinic - Admin</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('logo.png')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/font-awesome.min.css')}}">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/feathericon.min.css')}}">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/datatables/datatables.min.css')}}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/datatable.css')}}">
    <style>
        .dataTables_length, .swal2-title, #swal2-title{
            text-transform:capitalize;
        }

    </style>
    @yield('styles')
    <!--[if lt IE 9]>
    <script src="{{asset('admin/assets/js/html5shiv.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/respond.min.js')}}"></script>

    <![endif]-->
</head>
<body>

<!-- Main Wrapper -->
<div class="main-wrapper" id="app">

    <!-- Header -->
        @include('partials.navbar')
    <!-- /Header -->

    <!-- Sidebar -->
        @include('partials.sidebar')
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper">
        @yield('content')
    </div>
    <!-- /Page Wrapper -->

</div>
<!-- /Main Wrapper -->

<!-- jQuery -->
<script src="{{asset('admin/assets/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
<!-- Bootstrap Core JS -->
<script src="{{asset('admin/assets/js/popper.min.js')}}"></script>
<script src="{{asset('admin/assets/js/bootstrap.min.js')}}"></script>

<!-- Slimscroll JS -->
<script src="{{asset('admin/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- Datatables JS -->
<script src="{{asset('admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/datatables/datatables.min.js')}}"></script>

<!-- Custom JS -->
<script  src="{{asset('admin/assets/js/script.js')}}"></script>
<script src="{{mix('/js/preload.js')}}"></script>
<script>
    $(function (){
        let appointment = document.getElementById('appointment_date');
        appointment.min = new Date().toISOString().split("T")[0];
    })
</script>
@yield('scripts')
@if (Session::has('error'))
    <script>
        $(function () {
            Swal.fire({
                icon: 'error',
                title: 'Sorry!...',
                text: '{{Session::get("error")}}'
            })
        });

    </script>
    {{ Session::forget('error') }}
    {{ Session::save() }}
@endif
@if (Session::has('success'))
    <script>
        $(function () {
            Swal.fire('{{Session::get("success")}}')
        });
    </script>
    {{ Session::forget('success') }}
    {{ Session::save() }}
@endif
</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/appointment-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->
</html>
