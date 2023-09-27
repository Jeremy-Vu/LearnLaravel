<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Đăng nhập </title>
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
                         <!-- Logo-->
                            {{-- <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="index.html">
                                    <span><img src={{ asset('/js/vendor.min.js') }} alt="" height="18"></span>
                                </a>
                            </div> --}}
                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Đăng nhập </h4>
                                    <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p>
                                </div>
                                @if (session()->has('failed'))
                                <div class="alert alert-danger">
                                    <ul>
                                        {{ session()->get('failed') }}
                                    </ul>
                                </div>
                                @endif

                                @if (session()->has('Ok'))
                                <div class="alert alert-primary">
                                    <ul>
                                        {{ session()->get('Ok') }}
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
                                <form action="{{ route('process_login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                          <label>Email</label>
                                        <input class="form-control"  name="email" type="email"  placeholder="Enter your email">
                                    </div>
                                    @if ($errors->has('email'))
                                    <span class="error" style="color: red;">
                                      {{ $errors->first('email') }}
                                    </span>
                                    @endif

                                    <div class="form-group">
                                        {{-- <a href="pages-recoverpw.html" class="text-muted float-right">Quên mật khẩu?</a> --}}
                                        <label >Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" name="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                    <span class="error" style="color: red;">
                                      {{ $errors->first('password') }}
                                    </span>
                                    @endif

                                    {{-- <div class="form-group mb-3">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div> --}}

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-primary" type="submit"> Log In </button>
                                    </div>
                                </form>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-muted">Chưa có tài khoản? <a href={{ route('register')}} class="text-muted ml-1"><b>Đăng ký ngay</b></a></p>
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
            Demo quản lý panel khách sạn 
        </footer>

        <!-- bundle -->
        <script src={{ asset('/js/vendor.min.js') }}></script>
        <script src={{ asset('/js/app.min.js') }}></script>
        
    </body>
</html>



