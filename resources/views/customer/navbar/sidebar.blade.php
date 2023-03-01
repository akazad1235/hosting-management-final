<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary elevation-4 {{Request::routeIs('make.payment')? 'd-none': null}}">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Customer</span>
    </a>


       <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="Dummy Pic">
        </div>
        <div class="info">
          <div class="info">
            <a href="#" class="d-block">{{Auth::guard('customer')->user()->name}}</a>
          </div>
        </div>
      </div>

      {{-- <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('customer.profile')}}" class="nav-link {{route('customer.profile')? 'active': null}}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Profile</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('customer.address')}}" class="nav-link {{route('customer.address')? 'active': null}}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Addresses</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('customer.products')}}" class="nav-link {{route('customer.products')? 'active': null}}">
                <i class="far fa-circle nav-icon"></i>
                <p>All Products</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{route('customer.order')}}" class="nav-link {{route('customer.order')? 'active': null}}">
                <i class="far fa-circle nav-icon"></i>
                <p>My Orders</p>
              </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{route('customer.ticket')}}" class="nav-link {{route('customer.ticket')? 'active': null}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Ticket</p>
                </a>
            </li> --}}
              <li class="nav-item">
                <a href="{{route('customer.ticket.all')}}" class="nav-link {{route('customer.ticket.all')? 'active': null}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tickets</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customer.ticket.list')}}" class="nav-link {{route('customer.ticket.list')? 'active': null}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ticket old</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>

      </nav>
      <!-- /.sidebar-menu -->
    </div>


    <!-- /.sidebar -->
  </aside>
