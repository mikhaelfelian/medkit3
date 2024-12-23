<?php
$settings = Settings::getInstance();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BaseRouting::url(''); ?>" class="brand-link">
        <img src="<?php echo AssetHelper::logo(); ?>" 
             alt="<?php echo $settings->judul_app ?? 'AdminLTE Logo'; ?>" 
             class="brand-image img-circle elevation-3" 
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $settings->judul_app ?? 'NUSANTARA HMVC'; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo BaseRouting::url(''); ?>" class="nav-link <?php echo empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == BASE_URL . '/' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo BaseRouting::url('pasien'); ?>" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 