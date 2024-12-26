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
        <div class="card rounded-0">
            <div class="card-header rounded-0">
                <h3 class="card-title">Detail Obat</h3>
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="card-body rounded-0">
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
                        <th>Nama Alias</th>
                        <td><?= $data->item_alias ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th>Kandungan</th>
                        <td><?= $data->item_kand ?? '-' ?></td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td><?= $data->jml ?? '0' ?></td>
                    </tr>
                    <tr>
                        <th>Harga Beli</th>
                        <td>Rp <?= number_format($data->harga_beli ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Harga Jual</th>
                        <td>Rp <?= number_format($data->harga_jual ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?= $data->status == 4 ? 'Obat' : ($data->status == 6 ? 'Racikan' : '-') ?></td>
                    </tr>
                    <tr>
                        <th>Status Stok</th>
                        <td><?= $data->status_stok == '1' ? 'Aktif' : 'Tidak Aktif' ?></td>
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
                        <a href="<?= BaseRouting::url('obat') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('obat/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 