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
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <form action="<?= BaseRouting::url('stockitems') ?>" method="GET" class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control rounded-0" name="search" 
                                       value="<?= $search ?>" placeholder="Search...">
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
                            <th>Kode</th>
                            <th>Item</th>
                            <th>Alias</th>
                            <th class="text-right">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $item): ?>
                                <tr>
                                    <td><?= $item->kode ?></td>
                                    <td><?= $item->item ?></td>
                                    <td><?= $item->item_alias ?></td>
                                    <td class="text-right"><?= Angka::format($item->total_stock) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No data available</td>
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