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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('radiologi') ?>">Data Radiologi</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="<?= BaseRouting::url('radiologi/update/' . $data->id) ?>" method="POST">
                        <?= BaseSecurity::getInstance()->csrfField() ?>
                        <div class="card-body rounded-0">
                    <div class="form-group">
                        <label for="kode">Kode <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="kode" name="kode"
                            value="<?= $data->kode ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                        <select class="form-control select2 rounded-0" id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategoris as $kategori): ?>
                                <option value="<?= $kategori->id ?>" <?= $data->id_kategori == $kategori->id ? 'selected' : '' ?>>
                                    <?= $kategori->kode . ' - ' . $kategori->kategori ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="item">Nama Tindakan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-0" id="item" name="item"
                            value="<?= $data->item ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0">Rp</span>
                            </div>
                            <input type="text" class="form-control rounded-0 currency" id="harga_jual" name="harga_jual"
                                value="<?= Angka::format($data->harga_jual) ?>" required
                                onkeyup="formatCurrency(this)">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"><label class="control-label">Remunerasi</label></div>
                        <div class="col-lg-2"><label class="control-label">%</label></div>
                        <div class="col-lg-6"><label class="control-label">Rp</label></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select name="remun_tipe" class="form-control rounded-0">
                                    <option value="">[Tipe]</option>
                                    <option value="1" <?= $data->remun_tipe == '1' ? 'selected' : '' ?>>Persen</option>
                                    <option value="2" <?= $data->remun_tipe == '2' ? 'selected' : '' ?>>Nominal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="text" 
                                       class="form-control rounded-0" 
                                       id="remun_perc" 
                                       name="remun_perc"
                                       value="<?= (float)$data->remun_perc ?>" 
                                       placeholder="Masukkan %" 
                                       oninput="validateNumber(this)"
                                       maxlength="3"
                                       <?= $data->remun_tipe != '1' ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" 
                                       class="form-control rounded-0 currency" 
                                       id="remun_nom" 
                                       name="remun_nom"
                                       value="<?= Angka::format($data->remun_nom) ?>" 
                                       placeholder="Masukkan nominal" 
                                       onkeyup="formatCurrency(this)"
                                       <?= $data->remun_tipe != '2' ? 'disabled' : '' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"><label class="control-label">Apresiasi</label></div>
                        <div class="col-lg-2"><label class="control-label">%</label></div>
                        <div class="col-lg-6"><label class="control-label">Rp</label></div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <select name="apres_tipe" class="form-control rounded-0">
                                    <option value="">[Tipe]</option>
                                    <option value="1" <?= $data->apres_tipe == '1' ? 'selected' : '' ?>>Persen</option>
                                    <option value="2" <?= $data->apres_tipe == '2' ? 'selected' : '' ?>>Nominal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <input type="text" 
                                       class="form-control rounded-0" 
                                       id="apres_perc" 
                                       name="apres_perc"
                                       value="<?= (float)$data->apres_perc ?>" 
                                       placeholder="Masukkan %" 
                                       oninput="validateNumber(this)"
                                       maxlength="3"
                                       <?= $data->apres_tipe != '1' ? 'disabled' : '' ?>>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" 
                                       class="form-control rounded-0 currency" 
                                       id="apres_nom" 
                                       name="apres_nom"
                                       value="<?= Angka::format($data->apres_nom) ?>" 
                                       placeholder="Masukkan nominal" 
                                       onkeyup="formatCurrency(this)"
                                       <?= $data->apres_tipe != '2' ? 'disabled' : '' ?>>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" id="status_stok" name="status_stok" value="1" <?= $data->status_stok == '1' ? 'checked' : '' ?>>
                            <label for="status_stok" class="custom-control-label">Stockable</label>
                            <small class="form-text text-muted">Jika dicentang maka mengurangi stok</small>
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
                                    <a href="<?= BaseRouting::url('radiologi') ?>" class="btn btn-default rounded-0">
                                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary rounded-0">
                                        <i class="fas fa-save mr-2"></i>Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    function formatCurrency(input) {
        // Remove non-digit characters
        let value = input.value.replace(/\D/g, '');

        // Convert to number and format
        if (value !== '') {
            value = parseInt(value);
            value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Update input value
        input.value = value;
    }

    function validateNumber(input) {
        // Remove any non-digit characters except decimal point
        input.value = input.value.replace(/[^\d]/g, '');
        
        // Ensure value is between 0 and 100
        let value = parseInt(input.value);
        if (value > 100) {
            input.value = '100';
        }

        // If this is remun_perc, calculate remun_nom
        if (input.id === 'remun_perc') {
            calculateRemunNom();
        }
    }

    function calculateRemunNom() {
        const hargaJual = parseInt($('#harga_jual').val().replace(/\./g, '') || 0);
        const remunPerc = parseInt($('#remun_perc').val() || 0);
        
        if (hargaJual && remunPerc) {
            const remunNom = Math.round((hargaJual * remunPerc) / 100);
            $('#remun_nom').val(remunNom.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
        }
    }

    function calculateApresNom() {
        const hargaJual = parseInt($('#harga_jual').val().replace(/\./g, '') || 0);
        const apresPerc = parseInt($('#apres_perc').val() || 0);
        
        if (hargaJual && apresPerc) {
            const apresNom = Math.round((hargaJual * apresPerc) / 100);
            $('#apres_nom').val(apresNom.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'));
        }
    }

    function calculateRemunPerc() {
        const hargaJual = parseInt($('#harga_jual').val().replace(/\./g, '') || 0);
        const remunNom = parseInt($('#remun_nom').val().replace(/\./g, '') || 0);
        
        if (hargaJual && remunNom) {
            const remunPerc = Math.round((remunNom * 100) / hargaJual);
            const finalPerc = Math.min(remunPerc, 100);
            $('#remun_perc').val(finalPerc);
        }
    }

    function calculateApresPerc() {
        const hargaJual = parseInt($('#harga_jual').val().replace(/\./g, '') || 0);
        const apresNom = parseInt($('#apres_nom').val().replace(/\./g, '') || 0);
        
        if (hargaJual && apresNom) {
            const apresPerc = Math.round((apresNom * 100) / hargaJual);
            const finalPerc = Math.min(apresPerc, 100);
            $('#apres_perc').val(finalPerc);
        }
    }

    function handleRemunTipeChange() {
        const remunTipe = $('select[name="remun_tipe"]').val();
        
        // Reset fields
        $('#remun_perc, #remun_nom').val('').prop('disabled', true);
        
        if (remunTipe === '1') { // Persen
            $('#remun_perc').prop('disabled', false);
            $('#remun_nom').prop('disabled', true);
        } else if (remunTipe === '2') { // Nominal
            $('#remun_perc').prop('disabled', true);
            $('#remun_nom').prop('disabled', false);
        }
    }

    function handleApresTipeChange() {
        const apresTipe = $('select[name="apres_tipe"]').val();
        
        // Reset fields
        $('#apres_perc, #apres_nom').val('').prop('disabled', true);
        
        if (apresTipe === '1') { // Persen
            $('#apres_perc').prop('disabled', false);
            $('#apres_nom').prop('disabled', true);
        } else if (apresTipe === '2') { // Nominal
            $('#apres_perc').prop('disabled', true);
            $('#apres_nom').prop('disabled', false);
        }
    }

    $(document).ready(function() {
        // Initially disable all fields
        $('#remun_perc, #remun_nom, #apres_perc, #apres_nom').prop('disabled', true);

        // Handle type changes
        $('select[name="remun_tipe"]').on('change', handleRemunTipeChange);
        $('select[name="apres_tipe"]').on('change', handleApresTipeChange);

		
        // Handle harga_jual changes
        $('#harga_beli').on('keyup', function() {
            const remunTipe = $('select[name="remun_tipe"]').val();
            const apresTipe = $('select[name="apres_tipe"]').val();

            if (remunTipe === '1') calculateRemunNom();
            if (remunTipe === '2') calculateRemunPerc();
            if (apresTipe === '1') calculateApresNom();
            if (apresTipe === '2') calculateApresPerc();
        });
		
        // Handle harga_jual changes
        $('#harga_jual').on('keyup', function() {
            const remunTipe = $('select[name="remun_tipe"]').val();
            const apresTipe = $('select[name="apres_tipe"]').val();

            if (remunTipe === '1') calculateRemunNom();
            if (remunTipe === '2') calculateRemunPerc();
            if (apresTipe === '1') calculateApresNom();
            if (apresTipe === '2') calculateApresPerc();
        });

        // Handle percentage inputs
        $('#remun_perc').on('input', function() {
            if ($('select[name="remun_tipe"]').val() === '1') {
                calculateRemunNom();
            }
        });

        $('#apres_perc').on('input', function() {
            if ($('select[name="apres_tipe"]').val() === '1') {
                calculateApresNom();
            }
        });

        // Handle nominal inputs
        $('#remun_nom').on('keyup', function() {
            if ($('select[name="remun_tipe"]').val() === '2') {
                calculateRemunPerc();
            }
        });

        $('#apres_nom').on('keyup', function() {
            if ($('select[name="apres_tipe"]').val() === '2') {
                calculateApresPerc();
            }
        });

        // Handle form submission
        $('form').on('submit', function(e) {
            $('.currency').each(function() {
                var value = $(this).val().replace(/\./g, '');
                $(this).val(value);
            });
        });

        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: function() {
                return $(this).data('placeholder');
            },
            allowClear: true
        });

        // Add keypress validation for percentage fields
        $('#remun_perc, #apres_perc').on('keypress', function(e) {
            // Allow only numbers (0-9)
            if (e.which < 48 || e.which > 57) {
                e.preventDefault();
            }
            
            // Prevent input if current value is 100 and trying to add more digits
            if (this.value === '100' || (this.value.length === 2 && parseInt(this.value + e.key) > 100)) {
                e.preventDefault();
            }
        });
    });
</script>