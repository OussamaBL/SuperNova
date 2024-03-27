<!doctype html>

<html
lang="en"
class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
dir="ltr"
data-theme="theme-default"
data-assets-path="{{asset('assets_dashboard/')}}"
data-template="vertical-menu-template-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - eCommerce | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('assets_dashboard/img/favicon/favicon.ico')}} " />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/fonts/fontawesome.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/fonts/tabler-icons.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/fonts/flag-icons.css')}} " />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/css/rtl/core.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/css/rtl/theme-default.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/css/demo.css')}} " />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/node-waves/node-waves.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/typeahead-js/typeahead.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/apex-charts/apex-charts.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}} " />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}} " />



    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}} " /> --}}
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}} " /> --}}
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}} " /> --}}
     <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/select2/select2.css')}}" /> 
    {{-- <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/@form-validation/form-validation.css')}}" />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/quill/typography.css')}}" /> --}} --}}
    {{-- <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/quill/katex.css')}}" />
    <link rel="stylesheet" href="{{asset('assets_dashboard/vendor/libs/quill/editor.css')}}" />  --}}

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{asset('assets_dashboard/vendor/js/helpers.js')}} "></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets_dashboard/js/config.js')}} "></script>
  </head>

  <body>
    
    <div id="app">
        @yield('content')
    </div>

    @vite('resources/js/app_back_office.js')

    <script src="{{asset('assets_dashboard/vendor/libs/jquery/jquery.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/popper/popper.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/js/bootstrap.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/node-waves/node-waves.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/hammer/hammer.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/i18n/i18n.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/typeahead-js/typeahead.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/js/menu.js')}} "></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    {{-- dashboard --}}
    <script src="{{asset('assets_dashboard/vendor/libs/apex-charts/apexcharts.js')}} "></script>
    <script src="{{asset('assets_dashboard/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}} "></script>
     
    {{-- categories --}}
    {{-- <script src="{{asset('assets_dashboard/vendor/libs/moment/moment.js')}}"></script>
    <script src="{{asset('assets_dashboard/vendor/libs/select2/select2.js')}}"></script>
    <script src="{{asset('assets_dashboard/vendor/libs/@form-validation/popular.js')}}"></script>
    <script src="{{asset('assets_dashboard/vendor/libs/@form-validation/bootstrap5.js')}}"></script>
    <script src="{{asset('assets_dashboard/vendor/libs/@form-validation/auto-focus.js')}}"></script> --}}

    

    <!-- Main JS -->
    <script src="{{asset('assets_dashboard/js/main.js')}} "></script>

    <!-- Page JS -->
    <script src="{{asset('assets_dashboard/js/app-ecommerce-dashboard.js')}} "></script>
  </body>
</html>
