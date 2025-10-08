<!--
MIT License

Copyright (c) 2021 [ThemeSelection](https://themeselection.com/)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
-->

<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
   data-theme="theme-default" data-assets-path="../assets/"
   data-template="vertical-menu-template-free">

<head>
   <meta charset="utf-8" />
   <meta name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
   <meta name="description" content="" />
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com" />
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
   <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />
   <!-- Icons. Uncomment required icon fonts -->
   <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
   <!-- <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'> -->
   <!-- Core CSS -->
   <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}"
      class="template-customizer-core-css" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
      class="template-customizer-theme-css" />
   <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
   <!-- Vendors CSS -->
   <link rel="stylesheet"
      href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
   <!-- Select2 -->
   <link
      href="{{ asset('assets/vendor/libs/select2-4.1.0-rc.0/dist/css/select2.min.css') }}"
      rel="stylesheet" />
   <!-- Helpers -->
   <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
   <!-- Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
   <!-- Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->
   <script src="{{ asset('assets/js/config.js') }}"></script>

   <!-- HTMX -->
   <script src="https://unpkg.com/htmx.org@2.0.4"
      integrity="sha384-HGfztofotfshcF7+8n44JQL2oJmowVChPTg48S+jvZoztPfvwD79OC/LTtG6dMp+"
      crossorigin="anonymous"></script>

   <!-- Alpine JS -->
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

   <!-- Trix Editor -->
   <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/trix.css') }}">

   <!-- Trix Toolbar Custom -->
   <link rel="stylesheet" type="text/css"
      href="{{ asset('assets/css/trix-custom.css') }}">

   <!-- App Script | AlpineJS -->
   <script src="{{ asset('assets/js/app.js') }}"></script>

   <!-- My CSS  -->
   <link rel="stylesheet" href="{{ asset('assets/css/my-style.css') }}">

   <!-- Title Halaman -->
   <title>{{ $pageTitle }}</title>
</head>

<body>
   <!-- Layout wrapper -->
   <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
         <!-- Sidebar -->
         @include('layouts.sidebar')
         <!-- / Sidebar -->

         <!-- Layout container -->
         <div class="layout-page">
            <!-- Navbar -->
            @include('layouts.header')
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
               <!-- Content -->
               @yield('container')
               <!-- / Content -->
               <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->

         </div>
         <!-- / Layout page -->
      </div>
      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
   </div>
   <!-- / Layout wrapper -->

   <!-- Core JS -->
   <!-- build:js assets/vendor/js/core.js -->
   <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
   <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
   <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
   <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}">
   </script>
   <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

   <!-- Library Select2 -->
   <script
      src="{{ asset('assets/vendor/libs/select2-4.1.0-rc.0/dist/js/select2.min.js') }}">
   </script>
   <!-- endbuild -->

   <!-- Vendors JS -->
   <!-- Main JS -->
   <script src="{{ asset('assets/js/main.js') }}"></script>

   <!-- Page JS -->
   <script async defer src="https://buttons.github.io/buttons.js"></script>

   <!-- Trix Editor -->
   <script type="text/javascript" src="{{ asset('assets/js/trix.js') }}"></script>

   <!-- Trix Toolbar Custom -->
   <script src="{{ asset('assets/js/trix-custom.js') }}"></script>

   @stack('products-script')
   @stack('orders-script')
   @stack('order-create-script')
   @stack('order-edit-script')
   @stack('users-script')
</body>

</html>