<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ASK-KSTU ADMIN PANEL | {{ Session::get('page') }}</title>


    {{--  toastr css  --}}
    <link rel="stylesheet" href="{{url('admin/css/toastr.css')}}">


    <!-- Custom fonts for this template-->
    <link href="{{ url('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ url('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    @livewireStyles

    {{--  load-awesome  --}}
    <link rel="stylesheet" href="{{url('admin/css/load-awesome.css')}}">

</head>

<body class="bg-gradient-primary">


    <livewire:admin.login-wired/>




    <!-- Bootstrap core JavaScript-->
    <script src="{{ url('admin/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ url('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ url('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ url('admin/js/sb-admin-2.min.js')}}"></script>
    @livewireScripts
    <script src="{{url('admin/js/toastr.min.js')}}"></script>
    <script src="{{url('admin/js/custom/custom.js')}}"></script>



</body>

</html>
