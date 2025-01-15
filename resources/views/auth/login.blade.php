
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

</html>
