<!-- Content Header -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Gudang</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Data Gudang</li>
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
                                <a href="<?= BaseRouting::url('gudang/add') ?>" class="btn btn-primary btn-sm rounded-0">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <div class="col-md-6">
                                <!-- Search form on right -->
                                <form action="<?= BaseRouting::url('gudang') ?>" method="GET" class="float-right">
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
                                        <th width="15%">Kode</th>
                                        <th>Nama Gudang</th>
                                        <th width="20%">Status</th>
                                        <th width="15%" class="text-center">Gudang Utama</th>
                                        <th width="12%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $i => $item): ?>
                                            <tr>
                                                <td class="text-center"><?= $i + 1 ?></td>
                                                <td><?= htmlspecialchars((string)$item->kode) ?></td>
                                                <td><?= htmlspecialchars((string)$item->gudang) ?></td>
                                                <td>
                                                    <?php
                                                    switch($item->status) {
                                                        case '1':
                                                            echo 'Gudang Aktif';
                                                            break;
                                                        case '2':
                                                            echo 'Gudang Bazar';
                                                            break;
                                                        case '3':
                                                            echo 'Gudang Brg Keluar';
                                                            break;
                                                        default:
                                                            echo 'Gudang Simpan';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input toggle-status" 
                                                               id="primarySwitch<?= $item->id ?>" 
                                                               data-id="<?= $item->id ?>"
                                                               data-status="<?= $item->status_gd ?>"
                                                               <?= $item->status_gd == '1' ? 'checked' : '' ?>>
                                                        <label class="custom-control-label" for="primarySwitch<?= $item->id ?>">
                                                            <span class="status-text"><?= $item->status_gd == '1' ? 'Aktif' : 'Non Aktif' ?></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="<?= BaseRouting::url('gudang/show/' . $item->id) ?>" 
                                                           class="btn btn-info btn-sm" title="Detail">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('gudang/edit/' . $item->id) ?>" 
                                                           class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="<?= BaseRouting::url('gudang/delete/' . $item->id) ?>" 
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
                                            <td colspan="5" class="text-center">Tidak ada data</td>
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

<!-- Add the script directly -->
<script>
$(document).ready(function() {
    $(".toggle-status").on("change", function() {
        const id = $(this).data("id");
        const status = $(this).is(":checked") ? "1" : "0";
        const $switch = $(this);
        const $statusText = $switch.closest(".custom-control").find(".status-text");
        
        // Disable all switches while processing
        $(".toggle-status").prop("disabled", true);
        
        $.ajax({
            url: "<?= BaseRouting::url('gudang/set_primary') ?>",
            type: "POST",
            data: {
                id: id,
                status: status
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    // Update status text
                    $statusText.text(status === "1" ? "Aktif" : "Non Aktif");
                    Notification.success("Status gudang utama berhasil diperbarui");
                } else {
                    // Revert switch state
                    $switch.prop("checked", !$switch.prop("checked"));
                    Notification.error(response.message || "Gagal memperbarui status gudang utama");
                }
            },
            error: function() {
                // Revert switch state
                $switch.prop("checked", !$switch.prop("checked"));
                Notification.error("Gagal memperbarui status gudang utama");
            },
            complete: function() {
                // Re-enable all switches
                $(".toggle-status").prop("disabled", false);
            }
        });
    });
});
</script> 