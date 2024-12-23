<?php
$form = BaseForm::getInstance();
$search = $form->input('search');

// Ensure pagination data exists
$currentPage = isset($pagination['current_page']) ? (int)$pagination['current_page'] : 1;
$perPage = isset($pagination['per_page']) ? (int)$pagination['per_page'] : 10;
$totalPages = isset($pagination['total_pages']) ? (int)$pagination['total_pages'] : 1;

// Calculate starting number for the current page
$startNumber = (($currentPage - 1) * $perPage) + 1;

// Ensure data is an array
$data = is_array($data) ? $data : [];
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
                        <li class="breadcrumb-item"><a href="<?php echo BaseRouting::url(''); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Data Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?php echo Notification::render(); ?>
            
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Daftar Pasien</h3>
                        <a href="<?php echo BaseRouting::url('pasien/create'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Pasien
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">No</th>
                                <th>Kode</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th style="width: 100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php 
                                $counter = $startNumber;
                                foreach ($data as $pasien): 
                                ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <a href="<?php echo BaseRouting::url('pasien/show/' . $pasien['id']); ?>" 
                                               class="text-primary">
                                                <?php echo htmlspecialchars($pasien['kode']); ?>
                                            </a>
                                        </td>
                                        <td><?php echo htmlspecialchars($pasien['nik']); ?></td>
                                        <td><?php echo htmlspecialchars($pasien['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($pasien['no_hp']); ?></td>
                                        <td><?php echo htmlspecialchars($pasien['alamat']); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?php echo BaseRouting::url('pasien/edit/' . $pasien['id']); ?>" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?php echo BaseRouting::url('pasien/delete/' . $pasien['id']); ?>" 
                                                   class="btn btn-sm btn-danger" 
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
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ($totalPages > 1): ?>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-right">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo BaseRouting::url('pasien?page=' . $i); ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div> 