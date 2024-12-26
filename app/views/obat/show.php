<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Obat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('obat') ?>">Data Obat</a></li>
                    <li class="breadcrumb-item active">Detail Obat</li>
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
                        <h3 class="card-title">Detail Obat</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-tool">
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
                                <th>Barcode</th>
                                <td><?= $data->barcode ?? '-' ?></td>
                            </tr>
                            <tr>
                                <th>Nama Obat</th>
                                <td><?= $data->item ?></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td><?= $data->jml ?? '0' ?></td>
                            </tr>
                            <tr>
                                <th>Harga Jual</th>
                                <td><?= $data->harga_jual ?? '0' ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?= $data->status == 4 ? 'Obat' : ($data->status == 6 ? 'Racikan' : '-') ?></td>
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
                    <div class="card-footer">
                        <a href="<?= BaseRouting::url('obat/edit/' . $data->id) ?>" class="btn btn-warning">Edit</a>
                        <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-default">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 