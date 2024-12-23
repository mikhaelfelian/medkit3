<?php
// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASE_URL ?>" class="brand-link">
        <?php
        $defaultLogo = AssetHelper::theme('dist/img/AdminLTELogo.png');
        $customLogo = AssetHelper::custom('img/logo.png');
        $logoSrc = AssetHelper::exists('custom/img/logo.png') ? $customLogo : $defaultLogo;
        ?>
        <img src="<?= $logoSrc ?>" 
             alt="Logo" 
             class="brand-image img-circle elevation-3" 
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?= APP_NAME ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= BaseRouting::url('dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BaseRouting::url('pasien') ?>" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pasien</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BaseRouting::url('pengaturan') ?>" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                <!-- Add more menu items as needed -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside> 