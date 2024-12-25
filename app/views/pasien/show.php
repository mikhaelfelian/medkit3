<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detail Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th width="200">Kode</th>
                                <td><?= $data->kode ?></td>
                            </tr>
                            <tr>
                                <th>NIK</th>
                                <td><?= $data->nik ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Lengkap</th>
                                <td><?= $data->nama ?></td>
                            </tr>
                            <tr>
                                <th>Nama Panggilan</th>
                                <td><?= $data->nama_pgl ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>No HP</th>
                                <td><?= $data->no_hp ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td><?= $data->alamat ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Alamat Domisili</th>
                                <td><?= $data->alamat_domisili ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>RT/RW</th>
                                <td><?= ($data->rt ?? '-') . '/' . ($data->rw ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Kelurahan</th>
                                <td><?= $data->kelurahan ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Kecamatan</th>
                                <td><?= $data->kecamatan ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td><?= $data->kota ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td><?= $data->pekerjaan ?? '-' ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="<?= BaseRouting::url('pasien/edit/' . $data->id) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 