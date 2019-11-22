<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>@yield('title')</title>

    @yield('head')

    <!-- Bootstrap -->
    <link href="{{asset('adminlte/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('adminlte/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('adminlte/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('adminlte/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{asset('adminlte/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{asset('adminlte/vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{asset('adminlte/vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">

  

    <!-- Custom Theme Style -->
    <link href="{{asset('adminlte/build/css/custom.min.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="{{url('dashboard')}}" class="site_title"><i class="fa fa-money"></i> <span>DUIT.IN</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->

            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">



                  @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} 
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                  <li><a href="{{url('dashboard')}}"><i class="fa fa-home "></i> Dashboard </a>
                    
                  </li>
                  <li><a><i class="fa fa-edit"></i> Laporan </a>
                    <ul class="nav child_menu">
                      <li><a href="{{url('laporanpengeluaranpemasukan')}}">Laporan Rasio Pemasukan dan Pengeluaran</a></li>
                      <li><a href="{{url('laporantrendpemasukan')}}">Laporan Trend Pemasukan</a></li>
                      <li><a href="{{url('laporantrendpengeluaran')}}">Laporan Trend Pengeluaran</a></li>
                    </ul>
                  
                  <li><a href="{{url('tabunganberencana')}}"><i class="fa fa-desktop"></i> Tabungan Berencana</a>
                  </li>
                  <li><a href="{{url('konfigurasi')}}"><i class="fa fa-bar-chart-o"></i> Konfigurasi </a>
                  </li>


                  <!-- <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="">2</i>
                    <i class="fa fa-envelope-o"></i>

                    Notifikasi
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">

                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="message">
                          Ayo menabung agar semua target mu bisa tercapai
                        </span>
                        <span class="message">
                          <button class="btn btn-danger btn-small" >Hapus Reminder</button>
                        </span>
                      </a>
                    </li>
                     <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="message">
                          Ayo menabung agar semua target mu bisa tercapai
                        </span>
                        <span class="message">
                          <button class="btn btn-danger btn-small" >Hapus Reminder</button>
                        </span>
                      </a>
                    </li>
                     <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="message">
                          Ayo menabung agar semua target mu bisa tercapai
                        </span>
                        <span class="message">
                          <button class="btn btn-danger btn-small" >Hapus Reminder</button>
                        </span>
                      </a>
                    </li>
                     <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="message">
                          Ayo menabung agar semua target mu bisa tercapai
                        </span>
                        <span class="message">
                          <button class="btn btn-danger btn-small" >Hapus Reminder</button>
                        </span>
                      </a>
                    </li>
                     <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="message">
                          Ayo menabung agar semua target mu bisa tercapai
                        </span>
                        <span class="message">
                          <button class="btn btn-danger btn-small" >Hapus Reminder</button>
                        </span>
                      </a>
                    </li>
                  </li> -->
                  
                </ul>
              </div>
              <!-- <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="e_commerce.html">E-commerce</a></li>
                      <li><a href="projects.html">Projects</a></li>
                      <li><a href="project_detail.html">Project Detail</a></li>
                      <li><a href="contacts.html">Contacts</a></li>
                      <li><a href="profile.html">Profile</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="page_403.html">403 Error</a></li>
                      <li><a href="page_404.html">404 Error</a></li>
                      <li><a href="page_500.html">500 Error</a></li>
                      <li><a href="plain_page.html">Plain Page</a></li>
                      <li><a href="login.html">Login Page</a></li>
                      <li><a href="pricing_tables.html">Pricing Tables</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>                  
                  <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
              </div> -->

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div> -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="navbar navbar-nav">
                <ul class="navbar-right">

                  
                </ul>





          
        
                </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer style="background-color: #F7F7F7">
          <div class="pull-right">
            DUIT.IN © 2019</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="{{asset('adminlte/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset('adminlte/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('adminlte/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{asset('adminlte/vendors/nprogress/nprogress.js')}}"></script>
    <!-- Chart.js -->
    <script src="{{asset('adminlte/vendors/Chart.js/dist/Chart.min.js')}}"></script>
    <!-- gauge.js -->
    <script src="{{asset('adminlte/vendors/gauge.js/dist/gauge.min.js')}}"></script>
    <!-- bootstrap-progressbar -->
    <script src="{{asset('adminlte/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{asset('adminlte/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('adminlte/vendors/skycons/skycons.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('adminlte/vendors/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('adminlte/vendors/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('adminlte/vendors/Flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('adminlte/vendors/Flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('adminlte/vendors/Flot/jquery.flot.resize.js')}}"></script>
    <!-- Flot plugins -->
    <script src="{{asset('adminlte/vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
    <script src="{{asset('adminlte/vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
    <script src="{{asset('adminlte/vendors/flot.curvedlines/curvedLines.js')}}"></script>
    <!-- DateJS -->
    <script src="{{asset('adminlte/vendors/DateJS/build/date.js')}}"></script>
    <!-- JQVMap -->
    <script src="{{asset('adminlte/vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
    <script src="{{asset('adminlte/vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
    <script src="{{asset('adminlte/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('adminlte/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('adminlte/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    

    <!-- Custom Theme Scripts -->
    <script src="{{asset('adminlte/build/js/custom.min.js')}}"></script>
    @yield('js')
	
  </body>
</html>
