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
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url('pasien'); ?>">Data Pasien</a></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pasien</h3>
                            <div class="card-tools">
                                <a href="<?php echo BaseRouting::url('pasien/edit/' . $data->id); ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?php echo BaseRouting::url('pasien'); ?>" 
                                   class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px">No. RM</th>
                                            <td><?php echo htmlspecialchars($data->kode); ?></td>
                                        </tr>
                                        <tr>
                                            <th>NIK</th>
                                            <td><?php echo htmlspecialchars($data->nik); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td><?php echo htmlspecialchars($data->nama); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Panggilan</th>
                                            <td><?php echo htmlspecialchars($data->nama_pgl); ?></td>
                                        </tr>
                                        <tr>
                                            <th>No. HP</th>
                                            <td><?php echo htmlspecialchars($data->no_hp); ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 200px">Alamat KTP</th>
                                            <td><?php echo htmlspecialchars($data->alamat); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Domisili</th>
                                            <td><?php echo htmlspecialchars($data->alamat_domisili); ?></td>
                                        </tr>
                                        <tr>
                                            <th>RT/RW</th>
                                            <td><?php echo htmlspecialchars($data->rt . '/' . $data->rw); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kelurahan</th>
                                            <td><?php echo htmlspecialchars($data->kelurahan); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kecamatan</th>
                                            <td><?php echo htmlspecialchars($data->kecamatan); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Kota</th>
                                            <td><?php echo htmlspecialchars($data->kota); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Pekerjaan</th>
                                            <td><?php echo htmlspecialchars($data->pekerjaan); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 