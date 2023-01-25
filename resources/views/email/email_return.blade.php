<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Email Verify</title>

    <link href="{{ asset('admin_file/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('admin_file/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_file/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        {{-- <h1>&nbsp;</h1> --}}
        <h3 class="font-bold">Email Verification Succsses</h3>

        <div class="error-desc">
            Thank You for chosing GemsHarbour your email verfication completed please login your account and complte profile.
            {{-- <br/><a href="#" class="btn btn-primary m-t">Dashboard</a> --}}
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('admin_file/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('admin_file/js/bootstrap.min.js')}}"></script>

</body>

</html>
