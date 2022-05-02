<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/4.1.0/autoNumeric.min.js"></script>
  </head>

  <body>
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @include('sweetalert::alert')

    <div class="container-fluid overflow-hidden">
      <div class="row vh-100 overflow-auto">
          <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-light d-flex sticky-top">
              <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-dark">
                  <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                      <span class="fs-5">Keraton<span class="d-none d-sm-inline"> App</span></span>
                  </a>
                  <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                      <li class="dropdown">
                          <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-dark" id="dropdown_giro" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fs-3 bi-bank"></i><span class="ms-3 mb-2 d-none d-sm-inline">Giro</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                              <li><a class="dropdown-item" href="{{ route('giro_index') }}">Dashboard</a></li>
                              <li><a class="dropdown-item" href="{{ route('new_giro') }}">Tambah Giro Baru</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="{{ route('select_monthly_report_giro') }}">Monthly Report</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="{{ route('select_periodic_report_giro') }}">Periodic Report</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="{{ route('select_monthly_periodic_report_giro') }}">Monthly & Periodic Report</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="{{ route('select_giro_book_report_giro') }}">Giro Book Report</a></li>
                          </ul>
                      </li>
                      <li class="dropdown">
                          <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1 text-dark" id="dropdown_nota" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fs-3 bi-receipt"></i><span class="ms-3 mb-2 d-none d-sm-inline">Nota</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                              <li><a class="dropdown-item" href="{{ route('giro_index') }}">Dashboard</a></li>
                              <li><a class="dropdown-item" href="{{ route('new_giro') }}">Tambah</a></li>
                          </ul>
                      </li>
                  </ul>
                  <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                          <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                          <span class="d-none d-sm-inline mx-1">Joe</span>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                          <li><a class="dropdown-item" href="#">New project...</a></li>
                          <li><a class="dropdown-item" href="#">Settings</a></li>
                          <li><a class="dropdown-item" href="#">Profile</a></li>
                          <li>
                              <hr class="dropdown-divider">
                          </li>
                          <li><a class="dropdown-item" href="#">Sign out</a></li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="col d-flex flex-column h-sm-100">
              <main class="row overflow-auto">
                  <div class="col pt-4">
                      <h2 class="mb-3">@yield('title')</h2>
                      @yield('content')
                  </div>
              </main>
          </div>
       </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  </body>
</html>