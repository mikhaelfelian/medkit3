<?php
$form = BaseForm::getInstance();
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('pasien') ?>">Data Pasien</a></li>
                        <li class="breadcrumb-item active">Detail Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pasien</h3>
                            <div class="card-tools">
                                <a href="<?= BaseRouting::url('pasien/edit/' . $data['id']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Kode</th>
                                            <td><?= htmlspecialchars($data['kode']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td><?= htmlspecialchars($data['nik']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <td><?= htmlspecialchars($data['nama']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Panggilan</th>
                                            <td><?= htmlspecialchars($data['nama_pgl'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>No HP</th>
                                            <td><?= htmlspecialchars($data['no_hp'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Alamat</th>
                                            <td><?= nl2br(htmlspecialchars($data['alamat'])) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Domisili</th>
                                            <td><?= nl2br(htmlspecialchars($data['alamat_domisili'] ?? '-')) ?></td>
                                        </tr>
                                        <tr>
                                            <th>RT/RW</th>
                                            <td><?= htmlspecialchars($data['rt'] ?? '-') ?>/<?= htmlspecialchars($data['rw'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelurahan</th>
                                            <td><?= htmlspecialchars($data['kelurahan'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td><?= htmlspecialchars($data['kecamatan'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kota</th>
                                            <td><?= htmlspecialchars($data['kota'] ?? '-') ?></td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td><?= htmlspecialchars($data['pekerjaan'] ?? '-') ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                Created: <?= date('d M Y H:i', strtotime($data['created_at'])) ?>
                                <?php if ($data['updated_at']): ?>
                                    | Last Updated: <?= date('d M Y H:i', strtotime($data['updated_at'])) ?>
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 