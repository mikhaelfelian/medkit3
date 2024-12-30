<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('supplier') ?>">Data Supplier</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card rounded-0">
            <div class="card-header rounded-0">
                <h3 class="card-title"><?= $title ?></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Kode</th>
                        <td><?= htmlspecialchars($data->kode) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Supplier</th>
                        <td><?= htmlspecialchars($data->nama) ?></td>
                    </tr>
                    <tr>
                        <th>NPWP</th>
                        <td><?= htmlspecialchars($data->npwp) ?></td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td><?= nl2br(htmlspecialchars($data->alamat)) ?></td>
                    </tr>
                    <tr>
                        <th>Kota</th>
                        <td><?= htmlspecialchars($data->kota) ?></td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td><?= htmlspecialchars($data->no_tlp) ?></td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td><?= htmlspecialchars($data->no_hp) ?></td>
                    </tr>
                    <tr>
                        <th>Contact Person</th>
                        <td><?= htmlspecialchars($data->cp) ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <a href="<?= BaseRouting::url('supplier') ?>" class="btn btn-default rounded-0">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= BaseRouting::url('supplier/edit/' . $data->id) ?>" class="btn btn-warning rounded-0">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 