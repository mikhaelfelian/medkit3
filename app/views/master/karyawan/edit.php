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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('karyawan') ?>">Data Karyawan</a></li>
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
            <form action="<?= BaseRouting::url('karyawan/update/' . $data->id) ?>" method="POST">
                <?= BaseForm::csrf() ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['kode']) ? 'is-invalid' : '' ?>" 
                                    id="kode" name="kode" value="<?= old('kode', $data->kode) ?>" readonly>
                                <?php if (isset($errors['kode'])): ?>
                                    <div class="invalid-feedback"><?= $errors['kode'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['nik']) ? 'is-invalid' : '' ?>" 
                                    id="nik" name="nik" value="<?= old('nik', $data->nik) ?>">
                                <?php if (isset($errors['nik'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nik'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['nama']) ? 'is-invalid' : '' ?>" 
                                    id="nama" name="nama" value="<?= old('nama', $data->nama) ?>">
                                <?php if (isset($errors['nama'])): ?>
                                    <div class="invalid-feedback"><?= $errors['nama'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="jns_klm">Jenis Kelamin</label>
                                <select class="form-control rounded-0 <?= isset($errors['jns_klm']) ? 'is-invalid' : '' ?>" 
                                    id="jns_klm" name="jns_klm">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" <?= old('jns_klm', $data->jns_klm) == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="P" <?= old('jns_klm', $data->jns_klm) == 'P' ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <?php if (isset($errors['jns_klm'])): ?>
                                    <div class="invalid-feedback"><?= $errors['jns_klm'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="tmp_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['tmp_lahir']) ? 'is-invalid' : '' ?>" 
                                    id="tmp_lahir" name="tmp_lahir" value="<?= old('tmp_lahir', $data->tmp_lahir) ?>">
                                <?php if (isset($errors['tmp_lahir'])): ?>
                                    <div class="invalid-feedback"><?= $errors['tmp_lahir'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control rounded-0 <?= isset($errors['tgl_lahir']) ? 'is-invalid' : '' ?>" 
                                    id="tgl_lahir" name="tgl_lahir" value="<?= old('tgl_lahir', $data->tgl_lahir) ?>">
                                <?php if (isset($errors['tgl_lahir'])): ?>
                                    <div class="invalid-feedback"><?= $errors['tgl_lahir'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_poli">Poli/Unit</label>
                                <select class="form-control rounded-0 <?= isset($errors['id_poli']) ? 'is-invalid' : '' ?>" 
                                    id="id_poli" name="id_poli">
                                    <option value="">Pilih Poli/Unit</option>
                                    <?php foreach ($poli_list as $poli): ?>
                                        <option value="<?= $poli->id ?>" <?= old('id_poli', $data->id_poli) == $poli->id ? 'selected' : '' ?>>
                                            <?= $poli->poli ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['id_poli'])): ?>
                                    <div class="invalid-feedback"><?= $errors['id_poli'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="sip">SIP</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['sip']) ? 'is-invalid' : '' ?>" 
                                    id="sip" name="sip" value="<?= old('sip', $data->sip) ?>">
                                <?php if (isset($errors['sip'])): ?>
                                    <div class="invalid-feedback"><?= $errors['sip'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="str">STR</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['str']) ? 'is-invalid' : '' ?>" 
                                    id="str" name="str" value="<?= old('str', $data->str) ?>">
                                <?php if (isset($errors['str'])): ?>
                                    <div class="invalid-feedback"><?= $errors['str'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control rounded-0 <?= isset($errors['alamat']) ? 'is-invalid' : '' ?>" 
                                    id="alamat" name="alamat" rows="3"><?= old('alamat', $data->alamat) ?></textarea>
                                <?php if (isset($errors['alamat'])): ?>
                                    <div class="invalid-feedback"><?= $errors['alamat'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No. HP</label>
                                <input type="text" class="form-control rounded-0 <?= isset($errors['no_hp']) ? 'is-invalid' : '' ?>" 
                                    id="no_hp" name="no_hp" value="<?= old('no_hp', $data->no_hp) ?>">
                                <?php if (isset($errors['no_hp'])): ?>
                                    <div class="invalid-feedback"><?= $errors['no_hp'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control rounded-0 <?= isset($errors['status']) ? 'is-invalid' : '' ?>" 
                                    id="status" name="status">
                                    <option value="1" <?= old('status', $data->status) == '1' ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= old('status', $data->status) == '0' ? 'selected' : '' ?>>Non-aktif</option>
                                </select>
                                <?php if (isset($errors['status'])): ?>
                                    <div class="invalid-feedback"><?= $errors['status'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('karyawan') ?>" class="btn btn-default rounded-0">
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
</section> 