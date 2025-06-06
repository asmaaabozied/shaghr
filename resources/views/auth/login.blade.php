<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Shaghr & Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('style/assets/images/favicon.ico')}}">
    <!-- App css -->
    <link href="{{asset('style/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('style/assets/css/jquery-ui.min.css')}}" rel="stylesheet">
    <link href="{{asset('style/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('style/assets/css/metisMenu.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('style/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
</head>
<body class="account-body accountbg">
<!-- Log In page -->
<div class="container">
    <div class="row vh-100 ">
        <div class="col-12 align-self-center">
            <div class="auth-page">
                <div class="card auth-card shadow-lg">
                    <div class="card-body">
                        <div class="px-3">
                            <div class="auth-logo-box">
                                <a  class="logo logo-admin"><img src="{{asset('style/assets/images/logo-sm.png')}}" height="55" alt="logo" class="auth-logo"></a>
                            </div><!--end auth-logo-box-->

                            <div class="text-center auth-logo-text">
                                <h4 class="mt-0 mb-3 mt-5">Let's Get Started Shaghr</h4>
                                <p class="text-muted mb-0">Sign in to continue to Shaghr.</p>
                            </div> <!--end auth-logo-text-->


                            <form class="form-horizontal auth-form my-4" method="POST" action="{{ route('login') }}" >
                                @csrf

                                <div class="form-group">
                                    <label for="username">Email</label>
                                    <div class="input-group mb-3">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user"></i>
                                                </span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group">
                                    <label for="userpassword">Password</label>
                                    <div class="input-group mb-3">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock"></i>
                                                </span>

                                        <input id="password" type="password"  id="userpassword" placeholder="Enter password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div><!--end form-group-->

                                <div class="form-group row mt-4">
                                    <div class="col-sm-6">
                                        <div class="custom-control custom-switch switch-success">
                                            <input type="checkbox" class="custom-control-input" id="customSwitchSuccess">
                                            <label class="custom-control-label text-muted" for="customSwitchSuccess">Remember me</label>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-sm-6 text-right">
                                        <a href="{{ route('password.request') }}" class="text-muted font-13"><i class="dripicons-lock"></i> Forgot password?</a>
                                    </div><!--end col-->
                                </div><!--end form-group-->

                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit">Log In <i class="fas fa-sign-in-alt ml-1"></i></button>
                                    </div><!--end col-->
                                </div> <!--end form-group-->
                            </form><!--end form-->
                        </div><!--end /div-->

{{--                        <div class="m-3 text-center text-muted">--}}
{{--                            <p class="">Don't have an account ?  <a href="../authentication/auth-register.html" class="text-primary ml-2">Free Resister</a></p>--}}
{{--                        </div>--}}
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end auth-page-->
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->
<!-- End Log In page -->

<!-- jQuery  -->
<script src="{{asset('style/assets/js/jquery.min.js')}}'"></script>
<script src="{{asset('style/assets/js/jquery-ui.min.js')}}"></script>
<script src="{{asset('style/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('style/assets/js/metismenu.min.js')}}"></script>
<script src="{{asset('style/assets/js/waves.js')}}"></script>
<script src="{{asset('style/assets/js/feather.min.js')}}"></script>
<script src="{{asset('style/assets/js/jquery.slimscroll.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('style/assets/js/app.js')}}"></script>

</body>

</html>
