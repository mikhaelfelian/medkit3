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
                                <a href="<?= BaseRouting::url('icd/create') ?>" 
                                   class="btn btn-primary btn-sm rounded-0">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <div class="col-md-6">
                                <form action="<?= BaseRouting::url('icd') ?>" method="GET" class="float-right">
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
                    <div class="card-body">
                        <?php Notification::render(); ?>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>ICD</th>
                                        <th>Diagnosa (EN)</th>
                                        <th>Aksi</th>
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
                                                <td><?= $item->kode ?></td>
                                                <td><?= $item->icd ?></td>
                                                <td><?= $item->diagnosa_en ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?= BaseRouting::url('icd/edit/' . $item->id) ?>" 
                                                           class="btn btn-warning btn-sm rounded-0">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('icd/delete/' . $item->id) ?>" 
                                                           class="btn btn-danger btn-sm rounded-0" 
                                                           onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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