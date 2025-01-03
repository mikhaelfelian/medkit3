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
                                <i class="fas fa-ruler nav-icon"></i>
                                <p>Data Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('kategori'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kategori') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Data Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('merk'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'merk') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-trademark nav-icon"></i>
                                <p>Data Merk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('obat'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'obat') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-pills nav-icon"></i>
                                <p>Data Obat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('tindakan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'tindakan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-procedures nav-icon"></i>
                                <p>Data Tindakan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('lab'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'lab') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-flask nav-icon"></i>
                                <p>Data Laboratorium</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('radiologi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'radiologi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-x-ray nav-icon"></i>
                                <p>Data Radiologi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('poli'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'poli') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-clinic-medical nav-icon"></i>
                                <p>Data Klinik</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('gelar'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gelar') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-graduation-cap nav-icon"></i>
                                <p>Data Gelar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pasien'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pasien') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-user-injured nav-icon"></i>
                                <p>Data Pasien</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('karyawan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'karyawan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-user-md nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('gudang'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-warehouse nav-icon"></i>
                                <p>Data Gudang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('supplier'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'supplier') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-truck nav-icon"></i>
                                <p>Data Supplier</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('icd'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'icd') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-book-medical nav-icon"></i>
                                <p>Data ICD</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Transaksi -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'transaksi') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'transaksi') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('po'); ?>" 
                                class="nav-link <?php echo $_SERVER['REQUEST_URI'] == BASE_URL . '/po' ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-file-invoice nav-icon"></i>
                                <p>Purchase Order</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('faktur'); ?>" 
                                class="nav-link <?php echo $_SERVER['REQUEST_URI'] == BASE_URL . '/faktur' ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-cart-plus nav-icon"></i>
                                <p>Faktur</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('transaksi'); ?>" 
                                class="nav-link <?php echo $_SERVER['REQUEST_URI'] == BASE_URL . '/transaksi' ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-list nav-icon"></i>
                                <p>Data Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('transaksi'); ?>" 
                                class="nav-link <?php echo $_SERVER['REQUEST_URI'] == BASE_URL . '/transaksi' ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-list nav-icon"></i>
                                <p>Data Pembelian</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Gudang -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'gudang') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            Gudang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-header"><?= HtmlHelper::nbs() ?>INVENTORI</li>
                        <li class="nav-item">
                            <a href="#<?php //echo BaseRouting::url('gudang'); ?>" 
                                class="nav-link <?php //echo $_SERVER['REQUEST_URI'] == BASE_URL . '/gudang' ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Stok</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Medical Records -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'medical-records') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'medical-records') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>
                            Medical Records
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-header"><?= HtmlHelper::nbs() ?>PELAYANAN</li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pendaftaran'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pendaftaran') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Pendaftaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('antrian'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'antrian') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-users nav-icon"></i>
                                <p>Antrian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('rawat-jalan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'rawat-jalan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-procedures nav-icon"></i>
                                <p>Rawat Jalan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('rawat-inap'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'rawat-inap') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-bed nav-icon"></i>
                                <p>Rawat Inap</p>
                            </a>
                        </li>
                        <li class="nav-header"><?= HtmlHelper::nbs() ?>PENUNJANG</li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('radiologi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'radiologi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-x-ray nav-icon"></i>
                                <p>Radiologi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('laboratorium'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laboratorium') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-flask nav-icon"></i>
                                <p>Laboratorium</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Apotek -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'apotek') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'apotek') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-pills"></i>
                        <p>
                            Apotek
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('apotek/penjualan'); ?>" 
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'apotek/penjualan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-cash-register nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('apotek/resep'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'apotek/resep') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-prescription nav-icon"></i>
                                <p>Resep</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('apotek/stok'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'apotek/stok') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-boxes nav-icon"></i>
                                <p>Stok</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Kasir -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'kasir') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kasir') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Kasir
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('kasir/pembayaran'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kasir/pembayaran') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('kasir/riwayat'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kasir/riwayat') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-history nav-icon"></i>
                                <p>Riwayat Transaksi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Human Resources -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'hr') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'hr') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Human Resources
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('hr/karyawan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'hr/karyawan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-user-md nav-icon"></i>
                                <p>Data Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('hr/jadwal'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'hr/jadwal') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Jadwal Kerja</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('hr/presensi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'hr/presensi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Presensi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Laporan -->
                <li class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan') !== false ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan') !== false ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('laporan/kunjungan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan/kunjungan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Kunjungan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('laporan/pendapatan'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan/pendapatan') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Pendapatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('laporan/farmasi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan/farmasi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-pills nav-icon"></i>
                                <p>Farmasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('laporan/medis'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'laporan/medis') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-notes-medical nav-icon"></i>
                                <p>Rekam Medis</p>
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
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-cogs nav-icon"></i>
                                <p>Aplikasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pengaturan/lisensi'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan/lisensi') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-key nav-icon"></i>
                                <p>Lisensi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pengaturan/api'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan/api') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-code nav-icon"></i>
                                <p>API</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pengaturan/bpjs'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan/bpjs') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-hospital nav-icon"></i>
                                <p>BPJS</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo BaseRouting::url('pengaturan/satusehat'); ?>"
                                class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pengaturan/satusehat') !== false ? 'active' : ''; ?>">
                                <?= HtmlHelper::nbs(2) ?>
                                <i class="fas fa-heartbeat nav-icon"></i>
                                <p>SATU SEHAT</p>
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