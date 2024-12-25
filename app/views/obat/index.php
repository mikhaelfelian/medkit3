<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Obat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Obat</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?= Notification::render() ?>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Obat</h3>
                    <div class="card-tools">
                        <a href="<?= BaseRouting::url('obat/add') ?>" class="btn btn-primary btn-sm rounded-0">
                            <i class="fas fa-plus"></i> Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Stok</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $i => $item): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($item->kode) ?></td>
                                <td><?= htmlspecialchars($item->barcode) ?></td>
                                <td><?= htmlspecialchars($item->item) ?></td>
                                <td><?= htmlspecialchars($item->jml) ?></td>
                                <td>Rp <?= Angka::formatRibuan($item->harga_jual) ?></td>
                                <td><?= $item->status == 4 ? 'Obat' : ($item->status == 6 ? 'Racikan' : '-') ?></td>
                                <td>
                                    <a href="<?= BaseRouting::url('obat/edit/' . $item->id) ?>" 
                                       class="btn btn-sm btn-primary rounded-0">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= BaseRouting::url('obat/delete/' . $item->id) ?>" 
                                       class="btn btn-sm btn-danger rounded-0"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div> 