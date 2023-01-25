
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GEMS HARBOR | Login</title>

    <link href="{{asset('admin_file/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin_file/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{asset('admin_file/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('admin_file/css/style.css')}}" rel="stylesheet">

</head>

<body class="gray-bg">
  {{-- FOr SWeet Alert --}}
    @include('sweetalert::alert')
    {{-- FOr SWeet Alert --}}
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6 text-justify">
                <h1 class="font-bold">GEMS HARBOR</h1>
                {{-- <h1 class="font-bold">Welcome To <br> <small>GEMS HARBOR</small></h1> --}}

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">
                            {{ __('Login') }}
                        </button>
                        <p class="text-muted text-center">
                            <small>Do not have an account?</small>
                        </p>
                        
                    </form>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copy right GEMS HARBOR
            </div>
            <div class="col-md-6 text-right">
               <small>© 2022-2023</small>
            </div>
        </div>
    </div>

</body>

</html>
