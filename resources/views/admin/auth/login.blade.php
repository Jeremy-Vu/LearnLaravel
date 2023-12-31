<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title> Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href={{ asset('/img/favicon.ico')}}>
    <!-- App css -->
    <link href={{ asset('/css/icons.min.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('/css/app-creative.min.css') }} rel="stylesheet" type="text/css"/>
    {{--         <link href={{ asset('/css/app-creative-dark.min.css') }} rel="stylesheet" type="text/css" />--}}
</head>
<body class="authentication-bg" data-layout-config='{"darkMode":false}'>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center mt-0 font-weight-bold"> Login </h4>
                            <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                        </div>
                        @if (session()->has('failed'))
                            <div class="alert alert-danger">
                                <ul>
                                    {{ session()->get('failed') }}
                                </ul>
                            </div>
                        @endif

                        @if (session()->has('success'))
                            <div class="alert alert-primary">
                                <ul>
                                    {{ session()->get('success') }}
                                </ul>
                            </div>
                        @endif

                        @if (session()->has('logout'))
                            <div class="alert alert-success">
                                <ul>
                                    {{ session()->get('logout') }}
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('processLogin') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" type="email" placeholder="Enter your email">
                                @if ($errors->has('email'))
                                    <span class="error" style="color: red;">
                                      {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <a href="#" class="text-muted float-right">Quên mật khẩu?</a>
                                <label>Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password" class="form-control"
                                           placeholder="Enter your password">
                                    <div class="input-group-append" data-password="false">
                                        <div class="input-group-text">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="error" style="color: red;">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>


                            <div class="form-group mb-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                    <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary" type="submit"> Log In</button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-muted">Chưa có tài khoản?
                            <a href={{ route('register')}} class="text-muted ml-1">
                            <b>Đăng ký ngay</b>
                        </p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    Welcome
</footer>

<!-- bundle -->
<script src={{ asset('/js/vendor.min.js') }}></script>
<script src={{ asset('/js/app.min.js') }}></script>

</body>
</html>



