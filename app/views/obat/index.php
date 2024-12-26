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
        <div class="row">
            <div class="col-12">
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tambah button on left -->
                                <a href="<?= BaseRouting::url('obat/add') ?>" class="btn btn-primary btn-sm rounded-0">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <div class="col-md-6">
                                <!-- Search form on right -->
                                <form action="<?= BaseRouting::url('obat') ?>" method="GET" class="float-right">
                                    <div class="input-group input-group-sm" style="width: 250px;">
                                        <input type="text" class="form-control rounded-0" placeholder="Cari..."
                                            name="search" value="<?= $search ?? '' ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary rounded-0" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="10%">Kode</th>
                                        <th width="10%">Barcode</th>
                                        <th>Nama Produk</th>
                                        <th width="10%">Stok</th>
                                        <th width="15%">Harga Jual</th>
                                        <th width="10%">Status</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $i => $item): ?>
                                            <tr>
                                                <td class="text-center"><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars((string)$item->kode) ?></td>
                                                <td><?= htmlspecialchars((string)$item->barcode) ?></td>
                                                <td><?= htmlspecialchars((string)$item->item) ?></td>
                                                <td><?= htmlspecialchars((string)$item->jml) ?></td>
                                                <td><?= htmlspecialchars((string)$item->harga_jual) ?></td>
                                                <td><?= $item->status == 4 ? 'Obat' : ($item->status == 6 ? 'Racikan' : '-') ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="<?= BaseRouting::url('obat/show/' . $item->id) ?>" 
                                                           class="btn btn-info btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('obat/edit/' . $item->id) ?>" 
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('obat/delete/' . $item->id) ?>" 
                                                           class="btn btn-danger btn-sm" 
                                                           onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                                           title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>