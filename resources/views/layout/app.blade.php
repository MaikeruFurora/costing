<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
  <meta name="token" content="{{ csrf_token() }}"/>
  <meta name="getFinalRate" content="{{ route('costing.finalRate') }}"/>
  <title>Costing</title>
  <!-- CSS files -->
  <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset("assets/select/select2.min.css") }}" rel="stylesheet"/>
  <link href="{{ asset("dist/libs/alertify/alertify.min.css") }}" rel="stylesheet"/>
  <link href="{{ asset("assets/icons/font-awesome/css/fontawesome.css") }}" rel="stylesheet"/>
  <style>
    @import url('https://rsms.me/inter/inter.css');
    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
    label{
        font-size: 13px;
    }
    .select2-selection__rendered {
        line-height: 31px !important;
    }
    .select2-container .select2-selection--single {
        height: 36px !important;
    }
    
    .select2-container .select2-selection--single .select2-selection__rendered {
        font-size: 14px !important; /* Adjust the font size as needed */
        font-weight: 400
    }
    .select2-selection__arrow {
        height: 36px !important;
    }
    .dt-info {
          font-size: 12px !important; /* Adjust as needed */
    }
    .select2-container .select2-selection__arrow {
        display: none;
    }
    .sub-header tr th {
        padding: 2px;
    }
    @keyframes blinker {  50% { opacity: 0; } }
</style>
@yield('css')
</head>



<body class=" layout-fluid">
  @include('layout/header')
  <div class="page-wrapper">
    <div class="page-body"><!-- Page body -->
        <div class="container-fluid">
          @yield('content')
        </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="{{ asset("assets/jquery-number/jquery.number.min.js") }}"></script>
  <script src="{{ asset('assets/js/app.js') }}"></script>
  <script src="{{ asset("assets/sweetalert/sweetalert2.js") }}"></script>
  <script src="{{ asset("assets/select/select2.min.js") }}"></script>
  <script src="{{ asset("dist/libs/alertify/alertify.min.js") }}"></script>
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="{{ asset('dist/js/tabler.min.js') }}" ></script>
  <script src="{{ asset('dist/js/demo.min.js') }}"></script>
  <script src="{{ asset('assets/js/global.js') }}"></script>
  @yield('script')
</body>

</html>
