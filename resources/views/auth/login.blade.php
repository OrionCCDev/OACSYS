{{--
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Orion</title>
    <meta name="description" content="A responsive bootstrap 4 admin dashboard template by hencework" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('X-Files/Dash/loader.png') }}">
    <link rel="icon" href="{{ asset('X-Files/Dash/loader.png') }}" type="image/x-icon">

    <!-- Custom CSS -->
    <link href="{{ asset('X-Files/Dash/dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

	<!-- HK Wrapper -->
	<div class="hk-wrapper">

        <!-- Main Content -->
        <div class="hk-pg-wrapper hk-auth-wrapper">
            <header class="d-flex justify-content-between align-items-center">
                <a class="d-flex auth-brand" href="#">
                    <img class="brand-img" src="{{ asset('X-Files/Dash/logo-white.webp') }}" width="140" height="85" alt="brand" />
                </a>
            </header>
            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-5 pa-0">
                        <div id="owl_demo_1" class="owl-carousel dots-on-item owl-theme">

                            <div class="fadeOut item auth-cover-img overlay-wrap" style="background-image:url({{ asset('X-Files/Dash/login-main.png') }});">
                                <div class="auth-cover-info py-xl-0 pt-100 pb-50">
                                    <div class="auth-cover-content text-center w-xxl-75 w-sm-90 w-xs-100">

                                    </div>
                                </div>
								<div class="bg-overlay bg-trans-dark-50"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 pa-0">
                        <div class="auth-form-wrap py-xl-0 py-50">
                            <div class="auth-form w-xxl-55 w-xl-75 w-sm-90 w-xs-100">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <h1 class="display-4 mb-10">Welcome Back :)</h1>
                                    <p class="mb-30">Sign in to your account and enjoy unlimited perks.</p>
                                    <!-- Email Address -->
                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mt-4">
                                        <x-input-label for="password" :value="__('Password')" />

                                        <x-text-input id="password" class="form-control"
                                                        type="password"
                                                        name="password"
                                                        required autocomplete="current-password" />

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="block mt-4">
                                        <label for="remember_me" class="inline-flex items-center">
                                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                        </label>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit">{{ __('Log in') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Main Content -->

    </div>
	<!-- /HK Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('X-Files/Dash/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('X-Files/Dash/vendors/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('X-Files/Dash/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- Slimscroll JavaScript -->
    <script src="{{ asset('X-Files/Dash/dist/js/jquery.slimscroll.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('X-Files/Dash/dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Owl JavaScript -->
    <script src="{{ asset('X-Files/Dash/vendors/owl.carousel/dist/owl.carousel.min.js') }}"></script>

    <!-- FeatherIcons JavaScript -->
    <script src="{{ asset('X-Files/Dash/dist/js/feather.min.js') }}"></script>

    <!-- Init JavaScript -->
    <script src="{{ asset('X-Files/Dash/dist/js/init.js') }}"></script>
    <script src="{{ asset('X-Files/Dash/dist/js/login-data.js') }}"></script>
</body>

</html>  --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IT System - Login</title>
    <link rel="icon" href="{{ asset('X-Files/Dash/logo-blue.webp') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Big+Shoulders+Display:wght@600;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #05070c;
            background-image:
                radial-gradient(ellipse 900px 600px at 12% -10%, rgba(61, 90, 224, 0.28), transparent 60%),
                radial-gradient(ellipse 700px 500px at 100% 10%, rgba(125, 196, 255, 0.14), transparent 55%),
                radial-gradient(ellipse 900px 700px at 50% 110%, rgba(61, 90, 224, 0.18), transparent 60%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #e8edf7;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: rgba(18, 26, 42, 0.55);
            backdrop-filter: blur(22px) saturate(150%);
            -webkit-backdrop-filter: blur(22px) saturate(150%);
            border: 1px solid rgba(125, 196, 255, 0.16);
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            overflow: hidden;
            padding: 40px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            font-family: 'Big Shoulders Display', 'IBM Plex Sans', sans-serif;
            font-size: 30px;
            color: #e8edf7;
            font-weight: 700;
            letter-spacing: 0.01em;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #a7b3c9;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #a7b3c9;
            font-weight: 500;
        }

        .form-group .input-wrapper {
            position: relative;
        }

        .form-group .icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7dc4ff;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(125, 196, 255, 0.22);
            border-radius: 8px;
            font-size: 14px;
            color: #e8edf7;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #7dc4ff;
            box-shadow: 0 0 0 3px rgba(125, 196, 255, 0.18);
            outline: none;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #a7b3c9;
            cursor: pointer;
            font-size: 16px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #a7b3c9;
        }

        .remember-me input {
            margin-right: 6px;
        }

        .forgot-link {
            font-size: 14px;
            color: #7dc4ff;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            text-decoration: underline;
            color: #e8edf7;
        }

        .btn-login {
            display: block;
            width: 100%;
            padding: 14px 20px;
            background: linear-gradient(45deg, #3d5ae0, #7dc4ff);
            color: white;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(61, 90, 224, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .signup-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #a7b3c9;
        }

        .signup-link a {
            color: #7dc4ff;
            font-weight: 500;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
            transform-style: preserve-3d;
            transform: perspective(1000px);
        }

        .company-logo {
            max-width: 200px;
            max-height: 105px;
            object-fit: contain;
            transition: transform 0.6s ease-out;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
        }

        .error-message {
            color: #f0685c;
            font-size: 13px;
            margin-top: 5px;
        }

        @media screen and (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .form-header h2 {
                font-size: 24px;
            }

            .form-control {
                padding: 12px 15px 12px 40px;
            }

            .btn-login {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <x-auth-session-status class="error-message" :status="session('status')" />

        <div class="form-header">
            <div class="logo-container" id="logo-tilt-container">
                <img src="{{ asset('X-Files/Dash/logo-blue.webp') }}" alt="Company Logo" class="company-logo">
            </div>
            <h2>Orion IT System</h2>
            <p>Enter your credentials to access your account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="icon fas fa-envelope"></i>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="icon fas fa-lock"></i>
                    <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                    <i class="password-toggle fas fa-eye-slash" id="togglePassword"></i>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Remember me</span>
                </label>

                {{--  @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif  --}}
            </div>

            <button type="submit" class="btn-login">
                Log in
            </button>

            {{--  <div class="signup-link">
                Don't have an account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Sign up</a>
                @endif
            </div>  --}}
        </form>
    </div>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            const passwordInput = document.getElementById("password");
            const icon = this;

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });
    </script>

    <!-- Card3d.js Library for tilt effect -->
    <script src="https://cdn.jsdelivr.net/npm/card3d@2.6.5/dist/card3d.min.js"></script>
    <script>
        // Initialize the tilt effect on the logo container
        document.addEventListener('DOMContentLoaded', function() {
            const logoContainer = document.getElementById('logo-tilt-container');
            if (logoContainer) {
                const tiltEffect = new Card3d(logoContainer, {
                    glare: true,
                    scale: 1.05,
                    perspective: 1000,
                    max: 15,
                    speed: 1000,
                    easing: "cubic-bezier(.03,.98,.52,.99)",
                    glarePosition: "all",
                    gyroscope: true  // Enable device orientation on mobile
                });
            }
        });
    </script>
</body>
</html>
