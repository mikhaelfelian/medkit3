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
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?= Notification::render() ?>
        
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('karyawan/create') ?>" class="btn btn-primary rounded-0">
                            <i class="fas fa-plus mr-2"></i>Tambah Baru
                        </a>
                    </div>
                    <div class="col-md-6">
                        <form action="<?= BaseRouting::url('karyawan') ?>" method="get" class="form-inline float-right">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-0" name="search" value="<?= $search ?>" 
                                       placeholder="Cari berdasarkan nama/kode/NIK...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary rounded-0"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Unit/Poli</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php 
                            $no = ($page - 1) * $perPage + 1;
                            foreach ($data as $item): 
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->kode ?></td>
                                <td>
                                    <?= $item->nama_dpn ? $item->nama_dpn . ' ' : '' ?>
                                    <?= $item->nama ?>
                                    <?= $item->nama_blk ? ' ' . $item->nama_blk : '' ?>
                                </td>
                                <td><?= $item->nik ?></td>
                                <td><?= $item->nama_poli ?: '-' ?></td>
                                <td><?= $item->jabatan ?: '-' ?></td>
                                <td><?= $this->model->getStatusLabel($item->status) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= BaseRouting::url('karyawan/show/' . $item->id) ?>" 
                                           class="btn btn-info btn-sm rounded-0" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= BaseRouting::url('karyawan/edit/' . $item->id) ?>" 
                                           class="btn btn-warning btn-sm rounded-0" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= BaseRouting::url('karyawan/delete/' . $item->id) ?>" 
                                           class="btn btn-danger btn-sm rounded-0" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" 
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
            <?php if ($total > $perPage): ?>
                <div class="card-footer clearfix">
                    <?php echo PaginateHelper::createLinks($page, $perPage, $total, $search ? ['search' => $search] : []); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section> 