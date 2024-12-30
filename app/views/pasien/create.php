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
                        <h3 class="card-title">Tambah Data Pasien</h3>
                        <div class="card-tools">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool rounded-0">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <form action="<?= BaseRouting::url('pasien/store') ?>" method="POST">
                        <?= BaseSecurity::getInstance()->csrfField() ?>

                        <div class="card-body">
                            <?php Notification::render(); ?>

                            <div class="form-group">
                                <label for="no_rm">Nomor RM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="no_rm" name="no_rm" required
                                    value="<?= ViewHelper::loadModel('Pasien')->generateKode() ?>" readonly>
                            </div>

                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control rounded-0" id="nik" name="nik" maxlength="16"
                                    placeholder="Masukkan NIK">
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_gelar">Gelar <span class="text-danger">*</span></label>
                                        <select class="form-control select2 rounded-0" id="id_gelar" name="id_gelar" required>
                                            <option value="">Pilih Gelar</option>
                                            <?php
                                            $gelars = ViewHelper::loadModel('Gelar')->getAll();
                                            foreach ($gelars as $gelar):
                                                ?>
                                                <option value="<?= $gelar->id ?>"><?= $gelar->gelar ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="nama" name="nama" required
                                            placeholder="Masukkan nama lengkap">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="jns_klm">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control rounded-0" id="jns_klm" name="jns_klm" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tmp_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control rounded-0" id="tmp_lahir" name="tmp_lahir" 
                                            placeholder="Masukkan tempat lahir">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control rounded-0" id="tgl_lahir" name="tgl_lahir" 
                                            placeholder="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input type="text" class="form-control rounded-0" id="no_hp" name="no_hp"
                                    placeholder="Masukkan nomor HP">
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control rounded-0" id="alamat" name="alamat" rows="3"
                                    placeholder="Masukkan alamat lengkap"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="alamat_domisili">Alamat Domisili</label>
                                <textarea class="form-control rounded-0" id="alamat_domisili" name="alamat_domisili"
                                    rows="3" placeholder="Masukkan alamat domisili"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control rounded-0" id="rt" name="rt"
                                            maxlength="3" placeholder="RT">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control rounded-0" id="rw" name="rw"
                                            maxlength="3" placeholder="RW">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control rounded-0" id="kelurahan"
                                            name="kelurahan" placeholder="Masukkan kelurahan">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control rounded-0" id="kecamatan"
                                            name="kecamatan" placeholder="Masukkan kecamatan">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control rounded-0" id="kota" name="kota"
                                            placeholder="Masukkan kota">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control rounded-0" id="pekerjaan" name="pekerjaan"
                                    placeholder="Masukkan pekerjaan">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-default rounded-0 float-left">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary rounded-0">
                                <i class="fas fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>