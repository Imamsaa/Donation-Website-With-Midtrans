  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar"> 
    <!-- sidebar -->
    <div class="sidebar"> 
      <!-- Sidebar user panel -->
      <div class="user-panel" style=" background-image: url('<?= base_url('public/assets/img/background2.png') ?>') ">
        <div class="image text-center"><img src="<?= base_url('public/uploads/profiles/'.session()->get('photo')) ?>" class="img-circle" alt="User Image"> </div>
        <div class="info">
          <p><?= session()->get('name') ?></p>
        </div>
      </div>
      
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <?php $sesi = session()->get('level') ?>
        <!-- Dashboard menu -->
        <li class="<?= ($active == 'dashboard' OR $active == 'profile') ? 'active' : '' ; ?>"> <a href="<?= base_url('apps'); ?>"> <i class="icon-home mr-2"></i> <span>Dashboard</span> <span class="pull-right-container"></span> </a></li>
        
        <?php if($sesi == 'admin' OR $sesi == 'fundraiser' OR $sesi == 'donatur') : ?>
        <!-- Program menu -->
        <li class="<?= $active == 'program' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/program') ?>"> <i class="ti-harddrives mr-2"></i> <span>Program</span> <span class="pull-right-container"> </span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'admin') : ?>
        <!-- Fundraiser Menu -->
        <li class="<?= $active == 'fundraiser' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/fundraiser') ?>"> <i class="ti-agenda mr-2"></i> <span>Fundraiser</span> <span class="pull-right-container"></span> </a></li>
        
        <!-- Donatur Menu -->
        <li class="<?= $active == 'donatur' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/donatur') ?>"> <i class="ti-cup mr-2"></i> <span>Donatur</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'bendahara') : ?>
        <!-- Donasi Menu -->
        <li class="<?= $active == 'donasi' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/donasi') ?>"> <i class="ti-money mr-2"></i> <span>Donasi</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>
        
        <?php if($sesi != 'donatur') : ?>
        <!-- Laporan Menu -->
        <li class="<?= $active == 'laporan' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/laporan') ?>"> <i class="ti-stats-up mr-2"></i> <span>Laporan</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'admin') : ?>
        <!-- Pengaturan Menu -->
        <li class="<?= $active == 'pengaturan' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/pengaturan') ?>"> <i class="ti-settings mr-2"></i> <span>Pengaturan</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'admin' OR $sesi == 'ketua') : ?>
        <!-- Instansi Menu -->
        <li class="<?= $active == 'instansi' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/instansi') ?>"> <i class="ti-stamp mr-2"></i> <span>Instansi</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'admin') : ?>
        <!-- Pengguna Menu -->
        <li class="<?= $active == 'pengguna' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/pengguna'); ?>"> <i class="ti-user mr-2"></i> <span>Pengguna</span> <span class="pull-right-container"></span> </a></li>
        
        <!-- Backup Menu -->
        <li class="<?= $active == 'backup' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/backup') ?>"> <i class="ti-server mr-2"></i> <span>Backup</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

        <?php if($sesi == 'donatur') : ?>
        <!-- Riwayat Donasi Menu -->
        <li class="<?= $active == 'riwayat' ? 'active' : '' ;?>"> <a href="<?= base_url('apps/riwayat') ?>"> <i class="ti-printer mr-2"></i> <span>Riwayat Donasi</span> <span class="pull-right-container"></span> </a></li>
        <?php endif; ?>

      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>