<?php
$settings = Settings::getInstance();
$currentUri = $_SERVER['REQUEST_URI'];
$isMasterData = strpos($currentUri, 'pasien') !== false;
$isSettings = strpos($currentUri, 'pengaturan') !== false;
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BaseRouting::url(''); ?>" class="brand-link">
        <?php try { ?>
            <img src="<?php echo AssetHelper::logo(); ?>" 
                 alt="<?php echo $settings->judul_app ?? 'AdminLTE Logo'; ?>" 
                 class="brand-image img-circle elevation-3" 
                 style="opacity: .8">
        <?php } catch (Exception $e) { ?>
            <img src="<?php echo BaseRouting::asset('theme/admin-lte-3/dist/img/AdminLTELogo.png'); ?>" 
                 alt="AdminLTE Logo" 
                 class="brand-image img-circle elevation-3" 
                 style="opacity: .8">
        <?php } ?>
        <span class="brand-text font-weight-light"><?php echo $settings->judul_app ?? 'NUSANTARA HMVC'; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?php echo BaseRouting::url(''); ?>" 
                       class="nav-link <?php echo $currentUri == BASE_URL . '/' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="<?php echo BaseRouting::url('pasien'); ?>" 
                       class="nav-link <?php echo $isMasterData ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="<?php echo BaseRouting::url('pengaturan'); ?>" 
                       class="nav-link <?php echo $isSettings ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Pengaturan Aplikasi</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 