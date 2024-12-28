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
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="<?= BaseRouting::url('supplier') ?>" 
                                   class="btn btn-default btn-sm rounded-0">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BaseRouting::url('supplier/trash') ?>" method="GET" class="float-right">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search" class="form-control rounded-0" 
                                               placeholder="Search" value="<?= $search ?>">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default rounded-0">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kota</th>
                                    <th>Telepon</th>
                                    <th>Contact Person</th>
                                    <th>Tgl Hapus</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data)): ?>
                                    <?php 
                                    $start = ($page - 1) * $perPage + 1;
                                    foreach ($data as $index => $item): 
                                    ?>
                                        <tr>
                                            <td><?= $start + $index ?></td>
                                            <td><?= htmlspecialchars($item->kode) ?></td>
                                            <td><?= htmlspecialchars($item->nama) ?></td>
                                            <td><?= htmlspecialchars($item->kota) ?></td>
                                            <td><?= htmlspecialchars($item->no_tlp) ?></td>
                                            <td><?= htmlspecialchars($item->cp) ?></td>
                                            <td><?= date('d/m/Y H:i', strtotime($item->deleted_at)) ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?= BaseRouting::url('supplier/restore/' . $item->id) ?>"
                                                       class="btn btn-info btn-sm rounded-0"
                                                       onclick="return confirm('Pulihkan data ini?')">
                                                        <i class="fas fa-undo"></i>
                                                    </a>
                                                    <a href="<?= BaseRouting::url('supplier/permanent-delete/' . $item->id) ?>"
                                                       class="btn btn-danger btn-sm rounded-0"
                                                       onclick="return confirm('Hapus permanen data ini?')">
                                                        <i class="fas fa-times"></i>
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
                    <?php if ($total > $perPage): ?>
                        <div class="card-footer clearfix">
                            <?php
                            require_once SYSTEM_PATH . '/libraries/Paginate.php';
                            $paginator = new Paginate();
                            echo $paginator->createLinks($page, $perPage, $total, $search ? ['search' => $search] : []);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section> 