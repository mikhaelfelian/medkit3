<!-- Content Header -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('poli') ?>">Data Poli</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card rounded-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Kode</th>
                                <td><?= $data->kode ?></td>
                            </tr>
                            <tr>
                                <th>Nama Poli</th>
                                <td><?= $data->poli ?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td><?= $data->keterangan ?: '-' ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <?php if ($data->status == '1'): ?>
                                        <span class="badge badge-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Non-Aktif</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Dibuat Pada</th>
                                <td><?= date('d/m/Y H:i:s', strtotime($data->created_at)) ?></td>
                            </tr>
                            <tr>
                                <th>Diupdate Pada</th>
                                <td><?= $data->updated_at ? date('d/m/Y H:i:s', strtotime($data->updated_at)) : '-' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('poli') ?>" class="btn btn-secondary rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('poli/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 