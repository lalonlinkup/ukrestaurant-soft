<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$company->name}} - Login Page</title>
    <link rel="icon" type="image/x-icon" href="{{asset($company->favicon ? $company->favicon : '/noImage.gif')}}">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('auth/css/materialdesignicons.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('auth/css/bootstrap.min.css') }}" />
    <link href="{{asset('backend')}}/css/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('auth/css/style.css') }}" />
    <style>
        body {
            background-image: url("{{asset('auth')}}/images/beach_bg.jpg");
            background-repeat: no-repeat;
            width: 100%;
            background-size: cover;
        }

        .heading {
            color: #7c1d1d !important;
            font-weight: 700 !important;
        }

        .login-card-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @media (min-width: 1400px) {
            .login-card-container {
                top: 40%;
            }
        }

        /* @media (min-width: 1400px) and (max-width: 2400px) {
            .login-card-container {
                top: 40%;
            }
        } */
    </style>
</head>

<body>
    <main>
        <div class="container login-card-container">
            <div class="row">
                <div class="col-md-10 offset-md-1 text-center">
                    <h2 class="heading"><span id="typed"></span></h2>
                </div>
                <div class="col-md-10 col-lg-8 mx-auto">
                    <div class="card login-card" style="height: 300px;">
                        <div class="row no-gutters">
                            <div class="col-md-6 p-1 d-none d-md-block">
                                <img src="{{ asset('auth/images/login.gif') }}" alt="login" class="login-card-img" />
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="brand-wrapper d-flex justify-content-center">
                                        <img src="{{asset('auth/images/logo.png')}}" alt="logo" class="logo" />
                                    </div>
                                    <form onsubmit="AdminLogin(event)">
                                        <div class="form-group">
                                            <label for="username" class="sr-only">Username</label>
                                            <input type="text" name="username" id="username" class="form-control shadow-none" autofocus placeholder="Username" autocomplete="off" />
                                            <p class="error-username m-0" style="font-style: italic;"></p>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="password" class="sr-only">Password</label>
                                            <div style="position: relative;" class="password">
                                                <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password" autocomplete="off" />
                                                <i class="fa fa-eye" style="position: absolute;top: 13px;right: 10px;cursor:pointer;" onclick="passwordShow(event)"></i>
                                            </div>
                                            <p class="error-password m-0" style="font-style: italic;"></p>
                                        </div>
                                        <input type="submit" name="login" id="login" class="btn btn-block login-btn mb-4 shadow-none" value="Login" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="{{asset('backend')}}/js/toastr.min.js"></script>
    <script src="{{asset('backend')}}/js/typed.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        @if(Session::has('success'))
        toastr.success("{{Session::get('success')}}")
        @endif
        @if(Session::has('error'))
        toastr.error("{{Session::get('error')}}")
        @endif

        $(function() {
            var typed = new Typed('#typed', {
                strings: ["{{$company->title}}"],
                typeSpeed: 100,
                backSpeed: 100,
                loop: true
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function AdminLogin(event) {
            event.preventDefault();
            $("#login").prop("disabled", true);
            var formdata = new FormData(event.target)
            $.ajax({
                url: "/login",
                method: "POST",
                data: formdata,
                contentType: false,
                processData: false,
                beforeSend: () => {
                    $(".error-username").text('').removeClass("text-danger")
                    $(".error-password").text('').removeClass("text-danger")
                },
                success: res => {
                    location.href = "/module/dashboard"
                },
                error: err => {
                    $("#login").prop("disabled", false);
                    toastr.error(err.responseJSON.message);
                    if (typeof err.responseJSON.errors == 'object') {
                        $.each(err.responseJSON.errors, (index, value) => {
                            $(".error-" + index).text(value).addClass("text-danger")
                        })
                        return
                    }
                    console.log(err.responseJSON.errors);
                }
            })
        }

        // show password
        function passwordShow(event) {
            let password = $(".password").find('input').prop('type');
            if (password == 'password') {
                $(".password").find('i').removeProp('class').prop('class', 'fa fa-eye-slash')
                $(".password").find('input').removeProp('type').prop('type', 'text');
            } else {
                $(".password").find('i').removeProp('class').prop('class', 'fa fa-eye')
                $(".password").find('input').removeProp('type').prop('type', 'password');
            }
        }
    </script>
</body>

</html>