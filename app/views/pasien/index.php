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
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url('') ?>">Home</a></li>
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
            <?php echo Notification::render(); ?>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo BaseRouting::url('pasien/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Pasien
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" class="float-right">
                                <div class="input-group input-group-sm" style="width: 250px;">
                                    <?php echo $form->input('text', 'search', $search, [
                                        'class' => 'form-control float-right',
                                        'placeholder' => 'Search'
                                    ]); ?>
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>No. RM</th>
                                    <th>Nama Pasien</th>
                                    <th>Alamat</th>
                                    <th>No. Telp</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if (!empty($data['data'])): 
                                    $start = ($data['current_page'] - 1) * $data['per_page'] + 1;
                                    foreach($data['data'] as $row): 
                                ?>
                                <tr>
                                    <td><?php echo $start++; ?></td>
                                    <td><?php echo htmlspecialchars($row->kode); ?></td>
                                    <td><?php echo htmlspecialchars($row->nama); ?></td>
                                    <td><?php echo htmlspecialchars($row->alamat); ?></td>
                                    <td><?php echo htmlspecialchars($row->no_hp); ?></td>
                                    <td>
                                        <a href="<?php echo BaseRouting::url('pasien/edit/'.$row->id); ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo BaseRouting::url('pasien/delete/'.$row->id); ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Hapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (!empty($data['total'])): ?>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info">
                                Showing <?php echo ($data['current_page'] - 1) * $data['per_page'] + 1 ?> 
                                to <?php echo min($data['current_page'] * $data['per_page'], $data['total']) ?> 
                                of <?php echo $data['total'] ?> entries
                                <?php echo $search ? " (filtered from {$data['total']} total entries)" : '' ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers">
                                <ul class="pagination justify-content-end">
                                    <!-- Previous -->
                                    <li class="page-item <?php echo ($data['current_page'] == 1) ? 'disabled' : '' ?>">
                                        <a class="page-link" 
                                           href="<?php echo BaseRouting::url('pasien?page=' . ($data['current_page'] - 1) . ($search ? "&search={$search}" : '')) ?>">
                                            Previous
                                        </a>
                                    </li>
                                    
                                    <!-- Page Numbers -->
                                    <?php for($i = 1; $i <= $data['last_page']; $i++): ?>
                                    <li class="page-item <?php echo ($data['current_page'] == $i) ? 'active' : '' ?>">
                                        <a class="page-link" 
                                           href="<?php echo BaseRouting::url('pasien?page=' . $i . ($search ? "&search={$search}" : '')) ?>">
                                            <?php echo $i ?>
                                        </a>
                                    </li>
                                    <?php endfor; ?>
                                    
                                    <!-- Next -->
                                    <li class="page-item <?php echo ($data['current_page'] >= $data['last_page']) ? 'disabled' : '' ?>">
                                        <a class="page-link" 
                                           href="<?php echo BaseRouting::url('pasien?page=' . ($data['current_page'] + 1) . ($search ? "&search={$search}" : '')) ?>">
                                            Next
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div> 