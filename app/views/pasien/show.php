<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Pasien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
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
        <div class="card rounded-0">
            <div class="card-header rounded-0">
                <h3 class="card-title">Detail Pasien</h3>
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body rounded-0">
                <table class="table table-striped">
                    <tr>
                        <th width="200">No. RM</th>
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
                        <th>No. HP</th>
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
                        <td><?= ($data->rt ?? '-') . ' / ' . ($data->rw ?? '-') ?></td>
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
                    <tr>
                        <th>Tanggal Input</th>
                        <td><?= $data->created_at ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td><?= $data->updated_at ?? '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer rounded-0">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('pasien/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 