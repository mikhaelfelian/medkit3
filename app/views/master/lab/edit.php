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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('lab') ?>">Data Lab</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
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
            <div class="col-md-5">
                <div class="card rounded-0">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title ?></h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('lab') ?>" class="btn btn-tool">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('lab/update/' . $data->id) ?>" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control select2 rounded-0" id="id_kategori" name="id_kategori"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    <?php foreach ($kategoris as $kategori): ?>
                                        <option value="<?= $kategori->id ?>" <?= $data->id_kategori == $kategori->id ? 'selected' : '' ?>>
                                            <?= $kategori->kode . ' - ' . $kategori->kategori ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_merk">Merk <span class="text-danger">*</span></label>
                                <select class="form-control select2 rounded-0" id="id_merk" name="id_merk" required>
                                    <option value="">Pilih Merk</option>
                                    <?php foreach ($merks as $merk): ?>
                                        <option value="<?= $merk->id ?>" <?= $data->id_merk == $merk->id ? 'selected' : '' ?>>
                                            <?= $merk->kode . ' - ' . $merk->merk ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kode">Kode <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="kode" name="kode"
                                    value="<?= htmlspecialchars($data->kode) ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="item">Nama Pemeriksaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="item" name="item"
                                    value="<?= htmlspecialchars($data->item) ?>" placeholder="Masukkan nama pemeriksaan"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Rp</span>
                                    </div>
                                    <input type="text" class="form-control rounded-0 currency" id="harga"
                                        name="harga_beli" value="<?= (float) $data->harga_beli ?>"
                                        placeholder="Masukkan harga beli" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="harga_jual">Harga Jual<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text rounded-0">Rp</span>
                                    </div>
                                    <input type="text" class="form-control rounded-0 currency" id="harga"
                                        name="harga_jual" value="<?= (float) $data->harga_jual ?>"
                                        placeholder="Masukkan harga pemeriksaan" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="status1" name="status"
                                        value="1" <?= $data->status == '1' ? 'checked' : '' ?>>
                                    <label for="status1" class="custom-control-label">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="status0" name="status"
                                        value="0" <?= $data->status == '0' ? 'checked' : '' ?>>
                                    <label for="status0" class="custom-control-label">Non Aktif</label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?= BaseRouting::url('lab') ?>" class="btn btn-default rounded-0">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary rounded-0">
                                        <i class="fas fa-save mr-2"></i>Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card rounded-0">
                    <div class="card-header">
                        <ul class="nav nav-tabs" id="custom-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active rounded-0" id="item-referensi-tab" data-toggle="pill"
                                    href="#item-referensi" role="tab" aria-controls="item-referensi"
                                    aria-selected="true">
                                    <i class="fas fa-layer-group fa-solid fa-sharp"></i>
                                    Item Referensi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-0" id="item-lab-tab" data-toggle="pill" href="#item-lab"
                                    role="tab" aria-controls="item-lab" aria-selected="false">
                                    <i class="fas fa-layer-group fa-solid fa-microscope"></i>
                                    Item Lab
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-content">
                            <div class="tab-pane fade show active" id="item-referensi" role="tabpanel"
                                aria-labelledby="item-referensi-tab">
                                <!-- Content for Item Referensi tab -->
                                <form action="<?= BaseRouting::url('lab/store_reff') ?>" method="POST" class="mb-3">
                                    <input type="hidden" id="id" name="id" value="<?= $data->id ?>">
                                    <input type="hidden" id="item_reff_id" name="item_reff_id">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <input type="text" id="item_reff" class="form-control rounded-0"
                                                    name="item_reff" placeholder="Item" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="number" id="jml_reff" class="form-control rounded-0"
                                                    name="jml_reff" placeholder="Jumlah" min="1" step="1" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="text" id="harga_reff"
                                                    class="form-control rounded-0 currency" name="harga_reff"
                                                    placeholder="Harga" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-block rounded-0">
                                                <i class="fas fa-plus"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">No</th>
                                                <th>Item</th>
                                                <th width="15%" class="text-center">Jumlah</th>
                                                <th width="20%" class="text-right">Harga</th>
                                                <th width="20%" class="text-right">Subtotal</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($item_reffs)): ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($item_reffs as $reff): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++ ?></td>
                                                        <td class="text-left"><?= $reff->item ?></td>
                                                        <td class="text-center"><?= (int) $reff->jml ?></td>
                                                        <td class="text-right"><?= Angka::format($reff->harga) ?></td>
                                                        <td class="text-right"><?= Angka::format($reff->subtotal); ?></td>
                                                        <td>
                                                            <a href="<?= BaseRouting::url('lab/delete_reff/' . $reff->id) ?>"
                                                                class="btn btn-danger btn-sm rounded-0"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="item-lab" role="tabpanel" aria-labelledby="item-lab-tab">
                                <!-- Content for Item Lab tab -->
                                <form action="<?= BaseRouting::url('lab/store_item/' . $data->id) ?>" method="POST"
                                    class="mb-4">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="hidden" name="id" value="<?= $data->id ?>">

                                    <div class="form-group">
                                        <label>Item Pemeriksaan</label>
                                        <input type="text" name="item_name" class="form-control rounded-0"
                                            placeholder="Item Pemeriksaan..." required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Nilai</label>
                                                <input type="text" name="item_value" class="form-control rounded-0"
                                                    placeholder="Nilai Default...">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Satuan</label>
                                                <input type="text" name="item_satuan" class="form-control rounded-0"
                                                    placeholder="Nilai Satuan...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai L1</label>
                                                <input type="text" name="item_value_l1" class="form-control rounded-0"
                                                    placeholder="N. Laki Dws...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai L2</label>
                                                <input type="text" name="item_value_l2" class="form-control rounded-0"
                                                    placeholder="N. Laki Ank...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai P1</label>
                                                <input type="text" name="item_value_p1" class="form-control rounded-0"
                                                    placeholder="N. Perempuan Dws...">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nilai P2</label>
                                                <input type="text" name="item_value_p2" class="form-control rounded-0"
                                                    placeholder="N. Perempuan Ank...">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary rounded-0">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">No</th>
                                                <th>Item Pemeriksaan</th>
                                                <th width="20%" class="text-right">Nilai Default</th>
                                                <th width="20%" class="text-right">Satuan</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($item_ref_inputs)): ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($item_ref_inputs as $item): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++ ?></td>
                                                        <td>
                                                            <?= $item->item_name ?><br>
                                                            <?php if (!empty($item->item_value_l1)): ?>
                                                                <small class="text-muted">• Laki-laki Dewasa:
                                                                    <?= $item->item_value_l1 ?></small><br>
                                                            <?php endif; ?>
                                                            <?php if (!empty($item->item_value_l2)): ?>
                                                                <small class="text-muted">• Laki-laki Anak:
                                                                    <?= $item->item_value_l2 ?></small><br>
                                                            <?php endif; ?>
                                                            <?php if (!empty($item->item_value_p1)): ?>
                                                                <small class="text-muted">• Perempuan Dewasa:
                                                                    <?= $item->item_value_p1 ?></small><br>
                                                            <?php endif; ?>
                                                            <?php if (!empty($item->item_value_p2)): ?>
                                                                <small class="text-muted">• Perempuan Anak:
                                                                    <?= $item->item_value_p2 ?></small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-center"><?= $item->item_value ?></td>
                                                        <td class="text-right"><?= $item->item_satuan ?></td>
                                                        <td>
                                                            <a href="<?= BaseRouting::url('lab/delete_item/' . $item->id) ?>"
                                                                class="btn btn-danger btn-sm rounded-0"
                                                                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
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
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        // Handle autoNumeric
        $("input[id^='harga']").autoNumeric({ aSep: '.', aDec: ',', aPad: false });

        // Handle form submission
        $('form').on('submit', function (e) {
            $('.currency').each(function () {
                var value = $(this).val().replace(/\./g, '');
                $(this).val(value);
            });
        });

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: function () {
                return $(this).data('placeholder');
            },
            allowClear: true
        });

        $("#item_reff").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?= BaseRouting::url('lab/search_items') ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            select: function (event, ui) {
                $("#item_reff_id").val(ui.item.id);
                $("#item_reff").val(ui.item.item);
                $("#harga_reff").autoNumeric('set', ui.item.harga);
                $("#jml_reff").prop('readonly', false);
                $("#jml_reff").val(1);
                $("#jml_reff").focus();
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>")
                .data("item.autocomplete", item)
                .append("<a>" + item.item + "</a>")
                .appendTo(ul);
        };
    });
</script>