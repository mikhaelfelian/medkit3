<?php
$settings = ViewHelper::loadModel('Pengaturan')->getSettings();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo BaseRouting::url(''); ?>" class="brand-link">
        <?php
        try {
            $settings = ViewHelper::loadModel('Pengaturan')->getSettings();
            $logoPath = !empty($settings->logo) ? $settings->logo : 'assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
            ?>
            <img src="<?= BaseRouting::url(htmlspecialchars((string) ($logoPath))) ?>"
                alt="<?= htmlspecialchars((string) ($settings->judul_app ?? 'AdminLTE Logo')) ?>"
                class="brand-image img-circle elevation-3" style="opacity: .8">
        <?php } catch (Exception $e) { ?>
            <img src="<?php echo BaseRouting::asset('theme/admin-lte-3/dist/img/AdminLTELogo.png'); ?>" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
        <?php } ?>
        <span
            class="brand-text font-weight-light"><?= htmlspecialchars((string) ($settings->judul_app ?? 'NUSANTARA HMVC')) ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <?php
                try {
                    $settings = ViewHelper::loadModel('Pengaturan')->getSettings();
                    $logoPath = !empty($settings->logo_header) ? $settings->logo_header : 'assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
                    ?>
                    <div class="image">
                        <img src="<?= BaseRouting::url(htmlspecialchars((string) ($logoPath))) ?>"
                            alt="<?= $settings->judul; ?>" class="brand-image img-rounded elevation-0"
                            style="width: 209px; height: 85px; background-color: transparent;">
                    </div>
                <?php } catch (Exception $e) { ?>
                    <div class="image">
                        <img src="<?php echo BaseRouting::asset('theme/admin-lte-3/dist/img/AdminLTELogo.png'); ?>"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                <?php } ?>
                <div class="info">
                    <a href="#"
                        class="d-block"><?= htmlspecialchars((string) ($settings->judul_app ?? 'NUSANTARA HMVC')) ?></a>
                </div>
            </div>
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
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'merk') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'gelar') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'icd') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'satuan') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'kategori') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'poli') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'obat') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'supplier') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'tindakan') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'lab') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'radiologi') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'karyawan') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'bhp') !== false ||
                    strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'merk') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'gelar') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'icd') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'satuan') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'kategori') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'poli') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'obat') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'supplier') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'tindakan') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'lab') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'radiologi') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'karyawan') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'bhp') !== false ||
                            strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('satuan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'satuan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="nav-icon fas fa-list-alt"></i>
                                <p>Data Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('kategori'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kategori') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('merk'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'merk') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Merk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('obat'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'obat') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Obat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('tindakan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'tindakan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Tindakan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('lab'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'lab') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Laboratorium</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('radiologi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'radiologi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Radiologi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('poli'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'poli') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Klinik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('gelar'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gelar') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Gelar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pasien'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('karyawan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'karyawan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('gudang'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('supplier'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'supplier') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('icd'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'icd') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data ICD</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings with Submenu -->
                <li
                    class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan') !== false ? 'menu-open' : ''; ?>">
                    <a href="#"
                        class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan') !== false ? 'active' : ''; ?>">
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
                                <p>Aplikasi</p>
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