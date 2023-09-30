<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Đăng ký</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href={{ asset('/img/favicon.ico')}}>

    <!-- App css -->
    <link href={{ asset('/css/icons.min.css') }} rel="stylesheet" type="text/css" />
    <link href={{ asset('/css/app-creative.min.css') }} rel="stylesheet" type="text/css" />
    {{-- <link href={{ asset('/css/app-creative-dark.min.css') }} rel="stylesheet" type="text/css" /> --}}

</head>

<body class="authentication-bg" data-layout-config='{"darkMode":false}'>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Đăng ký</h4>
                                <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than
                                    a minute </p>
                            </div>

                            <form action="{{ route('processRegister') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Enter your name">
                                </div>
{{--                                @if ($errors->has('name'))--}}
{{--                                    <span class="error" style="color: red;">--}}
{{--                                        {{ $errors->first('name') }}--}}
{{--                                    </span>--}}
{{--                                @endif--}}

                                <div class="form-group">
                                    <label>Email address</label>
                                    <input class="form-control" type="email" name="email"
                                        placeholder="Enter your email">
                                </div>
{{--                                @if ($errors->has('email'))--}}
{{--                                    <span class="error" style="color: red;">--}}
{{--                                        {{ $errors->first('email') }}--}}
{{--                                    </span>--}}
{{--                                @endif--}}

                                <div class="form-group">
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
                                </div>
{{--                                @if ($errors->has('password'))--}}
{{--                                    <span class="error" style="color: red;">--}}
{{--                                        {{ $errors->first('password') }}--}}
{{--                                    </span>--}}
{{--                                @endif--}}

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" name="confirm_password" class="form-control"
                                            placeholder="Enter your password">
                                        <div class="input-group-append" data-password="false">
                                            <div class="input-group-text">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

{{--                                @if ($errors->has('confirm_password'))--}}
{{--                                    <span class="error" style="color: red;">--}}
{{--                                        {{ $errors->first('confirm_password') }}--}}
{{--                                    </span>--}}
{{--                                @endif--}}



                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="submit">Đăng ký</button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Đã có tài khoản? <a href="{{ route('login') }}"
                                    class="text-muted ml-1"><b>Đăng nhập ngay!</b></a></p>
                        </div> <!-- end col-->
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
