<!DOCTYPE html>
<html lang="en">

<head>
    <title>Company Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/backend/config/common_config.css') }}">
    <style>
        html,
        body {
            height: 100%;
        }

        .global-container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgb(238, 174, 202);
            background: radial-gradient(circle, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 1) 100%);
        }

        form {
            padding-top: 10px;
            font-size: 14px;
            margin-top: 30px;
        }

        .card-title {
            font-weight: 300;
        }

        .btn {
            font-size: 14px;
            margin-top: 20px;
        }

        .login-form {
            width: 360px;
            margin: 20px;
        }

        .sign-up {
            text-align: center;
            padding: 20px 0 0;
        }

        .alert {
            margin-bottom: -30px;
            font-size: 13px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <h3 class="card-title text-center">Welcome to Company Management System</h3>
                <div class="card-text">
                    <form action="{{ route('login') }}" id="loginForm" method="POST">
                        <!-- to error: add class "has-danger" -->
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email"
                                aria-describedby="emailHelp">
                            @if ($errors->has('email'))
                                <label id="email-error" class="error"
                                    for="email">{{ $errors->first('email') }}</label>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password">
                            @if ($errors->has('password'))
                                <label id="password-error" class="error"
                                    for="password">{{ $errors->first('password') }}</label>
                            @endif
                            <a href="#" style="float:right;font-size:12px;">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Signin</button>

                        {{-- <div class="sign-up">
                            Don't have an account?
                            <a href="https: //w3schoolweb.com/bootstraplogin-page/">Create One</a>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: "required",
            },
        });
    </script>
</body>

</html>
