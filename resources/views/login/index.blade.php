<!--
MIT License

Copyright (c) 2021 [ThemeSelection](https://themeselection.com/)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->

<!DOCTYPE html>
<html class="light-style customizer-hide" data-assets-path="/assets/" data-template="vertical-menu-template-free"
    data-theme="theme-default" dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
        name="viewport" />
    <title>Admin | Karisma Arga</title>
    <meta content="" name="description" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link href="{{ asset('assets/vendor/fonts/boxicons.css') }}" rel="stylesheet" />

    <!-- Core CSS -->
    <link class="template-customizer-core-css" href="{{ asset('assets/vendor/css/core.css') }}" rel="stylesheet" />
    <link class="template-customizer-theme-css" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet" />

    <!-- Vendors CSS -->
    <link href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

    <!-- Page CSS -->
    <link href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" rel="stylesheet" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!-- Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!-- Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Card Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <img alt="logo_arhadi" src="{{ asset('assets/img/logo/karisma-arga-logo.png') }}"
                                style="width: 120px; height: 110px;">
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Selamat Datang! 👋</h4>

                        @if (session()->has('loginError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('loginError') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('login-post') }}" class="mb-3" id="formAuthentication" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input required class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') }}" name="email" placeholder="admin@example.com"
                                    type="email" />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @else
                                <div class="form-text">Masukkan alamat email valid.</div>
                                @enderror
                            </div>
                            <div class="form-password-toggle mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input aria-describedby="password" class="form-control" id="password"
                                        name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        type="password" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- / Card Login -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>