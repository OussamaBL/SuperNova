<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Supernova E_commerce Gaming ">

	<!-- title -->
	<title>SuperNova | Gaming</title>
	
    <link rel="stylesheet" href="{{ asset('css/font-face.css') }}" media="all">
	<!-- bootstrap -->
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/animsition/animsition.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/wow/animate.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/slick/slick.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" media="all">
	<link rel="stylesheet" href="{{ asset('css/theme.css') }}" media="all">
	
</head>


  <body class="animsition">

    <!--PreLoader-->
    {{-- <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div> --}}
    <!--PreLoader Ends-->
    
    <div id="app">
        @yield('content')
    </div>


    @vite('resources/js/app_back_office.js')
    
	<script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
	<script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
	<script src="{{ asset('vendor/animsition/animsition.min.js') }}"></script>
	<script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
	<script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
	<script src="{{ asset('vendor/counter-up/jquery.counterup.min.js') }}"></script>
	<script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
	<script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
	<script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <!-- Main JS-->
    <script src="{{ asset('js/main.js') }}"></script>

</body>
</html>