<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
    <title>
      {{ $config['pageTitle']  }} | {{ config('app.name') }}
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('assets/css/material-dashboard.css?v=3.0.0')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/DataTables/FixedColumns-4.0.1/css/fixedColumns.dataTables.css')}}"/>
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/yadcf-0.9.3/jquery.dataTables.yadcf.css')}}"/> --}}

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"/>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/choices.min.css')}}"/>
    @section('js')    
    
    @show

  </head>

  {{-- footer fixed --}}
  <body class="g-sidenav-show  bg-gray-200">

    <!-- Sidebar -->
    @include('layouts.sidebar',['user' => Auth::User()])

    <!-- End Sidebar -->
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

      <!-- Navbar -->
      @include('layouts.navbar')
      <!-- End Navbar -->

      <!-- konten -->
      @yield('content')
      <!-- End konten -->

      <!-- footer -->
      @include('layouts.footer')
      <!-- End footer -->
      

    </main>

 
    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{asset('assets/js/material-dashboard.min.js')}}"></script>
    <!-- datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="{{asset('assets/DataTables/datatables.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/DataTables/FixedColumns-4.0.1/js/fixedColumns.dataTables.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('assets/yadcf-0.9.3/jquery.dataTables.yadcf.js')}}"></script> --}}

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('assets/js/plugins/choices.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
      if (document.getElementById("choices-button")) {
        var element = document.getElementById("choices-button");
        const example = new Choices(element, {});
      }

      var choicesTags = document.getElementById("choices-tags");
      var color = choicesTags.dataset.color;
      if (choicesTags) {
        const example = new Choices(choicesTags, {
          delimiter: ",",
          editItems: true,
          maxItemCount: 10,
          removeItemButton: true,
          addItems: true,
          classNames: {
            item: "badge rounded-pill choices-" + color + " me-2"
          }
        });
      }
    </script>

    @section('js')    
    
    @show


  </body>
  
</html>