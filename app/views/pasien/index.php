<?php
$form = BaseForm::getInstance();

// Ensure variables exist
$result = $result ?? null;
$pagination = $pagination ?? ['current_page' => 1, 'total' => 0];
$search = $form->input('search');
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Data Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Flash Messages -->
            <?= Notification::render() ?>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('pasien/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Pasien
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" class="float-right">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <?= $form->input('text', 'search', $search, [
                                        'class' => 'form-control float-right',
                                        'placeholder' => 'Search'
                                    ]) ?>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
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
                                <th width="5%">No</th>
                                <th width="10%">No RM</th>
                                <th width="15%">NIK</th>
                                <th>Nama</th>
                                <th width="15%">No HP</th>
                                <th width="20%">Alamat</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php 
                                $no = ($pagination['current_page'] - 1) * 10 + 1;
                                while ($row = $result->fetch_assoc()): 
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['kode']) ?></td>
                                        <td><?= htmlspecialchars($row['nik']) ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['no_hp'] ?? '-') ?></td>
                                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?= BaseRouting::url('pasien/show/'.$row['id']) ?>" 
                                                   class="btn btn-info btn-sm" 
                                                   title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= BaseRouting::url('pasien/edit/'.$row['id']) ?>" 
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= BaseRouting::url('pasien/delete/'.$row['id']) ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                   title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (isset($pagination) && $pagination['total'] > 0): ?>
                    <div class="card-footer clearfix">
                        <div class="float-left">
                            Showing <?= ($pagination['current_page'] - 1) * 10 + 1 ?> 
                            to <?= min($pagination['current_page'] * 10, $pagination['total']) ?> 
                            of <?= $pagination['total'] ?> entries
                        </div>
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?php if ($pagination['current_page'] > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BaseRouting::url('pasien') ?>?page=<?= $pagination['current_page']-1 ?><?= $search ? "&search=$search" : '' ?>">&laquo;</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $pagination['last_page']; $i++): ?>
                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BaseRouting::url('pasien') ?>?page=<?= $i ?><?= $search ? "&search=$search" : '' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($pagination['current_page'] < $pagination['last_page']): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BaseRouting::url('pasien') ?>?page=<?= $pagination['current_page']+1 ?><?= $search ? "&search=$search" : '' ?>">&raquo;</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div> 