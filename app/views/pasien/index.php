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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien/create') ?>" class="btn btn-tool">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php Notification::render(); ?>
                        
                        <!-- Search Form -->
                        <div class="row">
                            <div class="col-md-3 offset-md-9">
                                <form action="<?= BaseRouting::url('pasien') ?>" method="GET">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" placeholder="Cari..." name="search" value="<?= $search ?? '' ?>">
                                        <div class="input-group-append">
                                            <button class="btn btn-default" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="10%">Kode</th>
                                        <th width="15%">NIK</th>
                                        <th>Nama</th>
                                        <th width="10%">No HP</th>
                                        <th>Alamat</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($pasiens)): ?>
                                        <?php 
                                        $no = ($page - 1) * $perPage + 1;
                                        foreach ($pasiens as $pasien): 
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $pasien->kode ?? '-' ?></td>
                                            <td><?= $pasien->nik ?? '-' ?></td>
                                            <td><?= $pasien->nama ?? '-' ?></td>
                                            <td><?= $pasien->no_hp ?? '-' ?></td>
                                            <td><?= $pasien->alamat ?? '-' ?></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="<?= BaseRouting::url('pasien/show/' . $pasien->id) ?>" class="btn btn-default btn-sm" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= BaseRouting::url('pasien/edit/' . $pasien->id) ?>" class="btn btn-default btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= BaseRouting::url('pasien/delete/' . $pasien->id) ?>" 
                                                       class="btn btn-default btn-sm" 
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
                                            <td colspan="7" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total > $perPage): ?>
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info">
                                    Menampilkan <?= ($page - 1) * $perPage + 1 ?> sampai <?= min($page * $perPage, $total) ?> dari <?= $total ?> data
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers">
                                    <ul class="pagination m-0 float-right">
                                        <?php
                                        $totalPages = ceil($total / $perPage);
                                        for ($i = 1; $i <= $totalPages; $i++):
                                        ?>
                                        <li class="paginate_button page-item <?= ($page == $i) ? 'active' : '' ?>">
                                            <a class="page-link" href="<?= BaseRouting::url('pasien?page=' . $i . '&search=' . ($search ?? '')) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                        <?php endfor; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 