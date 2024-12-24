<?php
$settings = ViewHelper::loadModel('Pengaturan')->getSettings();
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
                       class="nav-link <?php echo empty($_SERVER['REQUEST_URI']) || $_SERVER['REQUEST_URI'] == BASE_URL . '/' ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Master Data -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pasien'); ?>" 
                               class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pasien</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings with Submenu -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Pengaturan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pengaturan'); ?>" 
                               class="nav-link <?php echo $_SERVER['REQUEST_URI'] == BASE_URL . '/pengaturan' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengaturan Aplikasi</p>
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