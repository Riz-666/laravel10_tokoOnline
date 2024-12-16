<nav class="navbar top-navbar navbar-expand-md navbar-dark">
  <div class="navbar-header" data-logobg="skin5">
      <!-- This is for the sidebar toggle which is visible on mobile only -->
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
      <!-- ============================================================== -->
      <!-- Logo -->
      <!-- ============================================================== -->
      <a class="navbar-brand" href="{{ Route('backend.index') }}">
          <!-- Logo icon -->
          <b class="logo-icon p-l-10">
              <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
              <!-- Dark Logo icon -->
              <img src="{{ asset('backend/image/icon_univ_bsi.png') }}" alt="homepage" class="light-logo" />

          </b>
          <!--End Logo icon -->
           <!-- Logo text -->
          <span class="logo-text">
               <!-- dark Logo text -->
               <img src="{{ asset('backend/image/logo_text.png') }}" alt="homepage" class="light-logo" />

          </span>
      </a>
      <!-- ============================================================== -->
      <!-- End Logo -->
      <!-- ============================================================== -->

      <!-- ============================================================== -->
      <!-- Toggle which is visible on mobile only -->
      <!-- ============================================================== -->
      <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
  </div>
  <!-- ============================================================== -->
  <!-- End Logo -->
  <!-- ============================================================== -->
  <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <!-- ============================================================== -->
      <!-- toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-left mr-auto">
          <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>

      </ul>
      <!-- ============================================================== -->
      <!-- Right side toggle and nav items -->
      <!-- ============================================================== -->
      <ul class="navbar-nav float-right">
          <!-- ============================================================== -->
          <!-- User profile and search -->
          <!-- ============================================================== -->
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (Auth::user()->foto)
                <img src="{{ asset('storage/img-user/'.Auth::user()->foto) }}" alt="user" class="rounded-circle" width="31"></a>
                @else
                <img src="{{ asset('storage/img-user/default-img.jpg') }}" alt="user" class="rounded-circle" width="31"></a>
                @endif
              <div class="dropdown-menu dropdown-menu-right user-dd animated">
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{ Route('backend.user.edit', Auth::user()->id) }}"><i class="fa fa-user m-r-5 m-l-5"></i> Profile</a>
                  <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('out').submit();"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                </div>
          </li>
      </ul>
  </div>
</nav>
