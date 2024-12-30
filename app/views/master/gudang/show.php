<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Gudang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('gudang') ?>">Data Gudang</a></li>
                    <li class="breadcrumb-item active">Detail Gudang</li>
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
                <h3 class="card-title">Detail Gudang</h3>
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('gudang') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body rounded-0">
                <table class="table table-striped">
                    <tr>
                        <th width="200">Kode</th>
                        <td><?= htmlspecialchars((string)$data->kode) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Gudang</th>
                        <td><?= htmlspecialchars((string)$data->gudang) ?></td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td><?= htmlspecialchars((string)($data->keterangan ?? '-')) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            switch($data->status) {
                                case '1':
                                    echo 'Gudang Aktif';
                                    break;
                                case '2':
                                    echo 'Gudang Bazar';
                                    break;
                                case '3':
                                    echo 'Gudang Brg Keluar';
                                    break;
                                default:
                                    echo 'Gudang Simpan';
                            }
                            ?>
                        </td>
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
                        <a href="<?= BaseRouting::url('gudang') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('gudang/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 