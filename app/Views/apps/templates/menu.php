
  <header class="main-header"> 
    <!-- Logo --> 
    <a href="#" class="logo blue-bg d-none d-sm-inline"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <!-- <span class="logo-mini"><img class="w-50" src="" alt=""></span>  -->
    <!-- logo for regular state and mobile devices --> 
    <span class="logo-lg">PANEL ADMIN</span>
  </a> 
    <!-- Header Navbar -->
    <nav class="navbar blue-bg navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <ul class="nav navbar-nav pull-left">
        <li><a class="sidebar-toggle" data-toggle="push-menu" href=""></a> </li>
      </ul>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account  -->
          <li class="dropdown user user-menu p-ph-res"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?= base_url('public/uploads/profiles/'.session()->get('photo')) ?>" class="user-image" alt="User Image"> <span class="hidden-xs"><?= session()->get('name') ?></span> </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <div class="pull-left user-img"><img src="<?= base_url('public/uploads/profiles/'.session()->get('photo')) ?>" class="img-responsive img-circle" alt="User"></div>
                <p class="text-left"><?= session()->get('name') ?> <small><?= session()->get('email') ?></small> </p>
              </li>
              <li><a href="<?= base_url('apps/profile') ?>"><i class="icon-profile-male"></i> My Profile</a></li>
              <li><a href="<?= base_url('logout') ?>" class="logout-link" ><i class="fa fa-power-off"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>