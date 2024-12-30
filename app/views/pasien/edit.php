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
        <form action="<?= BaseRouting::url('pasien/update/' . $data->id) ?>" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Foto Pasien</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <!-- Camera preview -->
                            <div id="camera-preview" style="width:100%; height:200px;"></div>

                            <!-- Captured photo will be shown here -->
                            <div id="camera-result" style="display:none; width:100%; height:240px;">
                                <img id="photo" style="width:100%; height:100%; object-fit:cover;">
                                <input type="hidden" name="foto_pasien" id="foto_pasien">
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <button type="button" onclick="takeSnapshot()" class="btn btn-primary btn-flat btn-block"><i
                                    class="fa fa-camera"></i> Ambil Gambar
                            </button>
                        </div>
                    </div>
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Foto Identitas</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <!-- Camera preview for KTP -->
                            <div id="camera-preview-ktp" style="width:100%; height:200px;"></div>

                            <!-- Captured KTP photo will be shown here -->
                            <div id="camera-result-ktp" style="display:none; width:100%; height:240px;">
                                <img id="photo-ktp" style="width:100%; height:100%; object-fit:cover;">
                                <input type="hidden" name="foto_ktp" id="foto_ktp">
                            </div>
                        </div>
                        <div class="card-footer p-0">
                            <button type="button" onclick="takeKtpSnapshot()"
                                class="btn btn-primary btn-flat btn-block"><i class="fa fa-camera"></i> Ambil Gambar
                            </button>
                        </div>
                    </div>
                    <div class="card card-primary card-outline rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Foto Pasien</h3>
                        </div>
                        <div class="card-body box-profile rounded-0">
                            <div class="text-center">                                                               
                                <img class="img-thumbnail img-fluid img-lg" src="<?= !empty($data->file_foto) ? BaseRouting::url($data->file_foto) : BaseRouting::asset('assets/theme/admin-lte-3/dist/img/icon_putra.png') ?>" alt="User profile picture" style="width: 256px; height: 192px;">
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary card-outline rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Foto Identitas</h3>
                        </div>
                        <div class="card-body box-profile rounded-0">
                            <div class="text-center">                                                               
                                <img class="img-thumbnail img-fluid img-lg" src="<?= !empty($data->file_ktp) ? BaseRouting::url($data->file_ktp) : BaseRouting::asset('assets/theme/admin-lte-3/dist/img/icon_putra.png') ?>" alt="User profile picture" style="width: 256px; height: 192px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="card-title">Edit Data Pasien</h3>
                            <div class="card-tools">
                                <a href="<?= BaseRouting::url('pasien') ?>" class="btn btn-tool rounded-0">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <?= BaseSecurity::getInstance()->csrfField() ?>

                        <div class="card-body">
                            <?php Notification::render(); ?>

                            <div class="form-group">
                                <label for="no_rm">Nomor RM <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="no_rm" name="no_rm" required
                                    value="<?= $data->kode ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control rounded-0" id="nik" name="nik" maxlength="16"
                                    placeholder="Masukkan NIK" value="<?= $data->nik ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="id_gelar">Gelar <span class="text-danger">*</span></label>
                                        <select class="form-control select2 rounded-0" id="id_gelar" name="id_gelar"
                                            required>
                                            <option value="">Pilih Gelar</option>
                                            <?php foreach ($gelars as $gelar): ?>
                                                <option value="<?= $gelar->id ?>" <?= ($data->id_gelar == $gelar->id) ? 'selected' : '' ?>><?= $gelar->gelar ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-0" id="nama" name="nama" required
                                            placeholder="Masukkan nama lengkap" value="<?= $data->nama ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="jns_klm">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control rounded-0" id="jns_klm" name="jns_klm" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" <?= ($data->jns_klm == 'L') ? 'selected' : '' ?>>Laki-laki
                                            </option>
                                            <option value="P" <?= ($data->jns_klm == 'P') ? 'selected' : '' ?>>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tmp_lahir">Tempat Lahir</label>
                                        <input type="text" class="form-control rounded-0" id="tmp_lahir"
                                            name="tmp_lahir" placeholder="Masukkan tempat lahir"
                                            value="<?= $data->tmp_lahir ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="date" class="form-control rounded-0" id="tgl_lahir"
                                            name="tgl_lahir" value="<?= $data->tgl_lahir ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control rounded-0" id="alamat" name="alamat" rows="3"
                                            placeholder="Masukkan alamat lengkap"><?= $data->alamat ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="alamat_domisili">Alamat Domisili</label>
                                        <textarea class="form-control rounded-0" id="alamat_domisili"
                                            name="alamat_domisili" rows="3"
                                            placeholder="Masukkan alamat domisili"><?= $data->alamat_domisili ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rt">RT</label>
                                        <input type="text" class="form-control rounded-0" id="rt" name="rt"
                                            maxlength="3" placeholder="RT" value="<?= $data->rt ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rw">RW</label>
                                        <input type="text" class="form-control rounded-0" id="rw" name="rw"
                                            maxlength="3" placeholder="RW" value="<?= $data->rw ?>">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <input type="text" class="form-control rounded-0" id="kelurahan"
                                            name="kelurahan" placeholder="Masukkan kelurahan"
                                            value="<?= $data->kelurahan ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <input type="text" class="form-control rounded-0" id="kecamatan"
                                            name="kecamatan" placeholder="Masukkan kecamatan"
                                            value="<?= $data->kecamatan ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kota">Kota</label>
                                        <input type="text" class="form-control rounded-0" id="kota" name="kota"
                                            placeholder="Masukkan kota" value="<?= $data->kota ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_hp">No HP</label>
                                        <input type="text" class="form-control rounded-0" id="no_hp" name="no_hp"
                                            placeholder="Masukkan nomor HP" value="<?= $data->no_hp ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pekerjaan">Pekerjaan</label>
                                        <input type="text" class="form-control rounded-0" id="pekerjaan"
                                            name="pekerjaan" placeholder="Masukkan pekerjaan"
                                            value="<?= $data->pekerjaan ?>">
                                    </div>
                                </div>
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
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
    // Photos Patient Handling
    // Initialize camera when page loads
    window.addEventListener('load', function () {
        // Check if browser supports getUserMedia
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    const video = document.createElement('video');
                    video.style.width = '100%';
                    video.style.height = '100%';
                    video.style.objectFit = 'cover';
                    video.autoplay = true;

                    // Add video element to preview div
                    document.getElementById('camera-preview').appendChild(video);
                    video.srcObject = stream;

                    // Store stream globally to stop it later
                    window.stream = stream;
                })
                .catch(function (error) {
                    console.error("Camera error:", error);
                    alert("Could not access camera. Please check permissions.");
                });
        } else {
            alert("Sorry, your browser does not support camera access");
        }
    });

    // Function to capture photo
    function takeSnapshot() {
        const preview = document.getElementById('camera-preview');
        const result = document.getElementById('camera-result');
        const video = preview.querySelector('video');

        if (!video) return;

        // Create canvas to capture frame
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw video frame to canvas
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0);

        // Convert to base64
        const imageData = canvas.toDataURL('image/png');

        // Show captured photo
        document.getElementById('photo').src = imageData;
        document.getElementById('foto_pasien').value = imageData;

        // Hide preview, show result
        preview.style.display = 'none';
        result.style.display = 'block';

        // Stop camera stream
        if (window.stream) {
            window.stream.getTracks().forEach(track => track.stop());
        }
    }


    // KTP Camera handling
    let ktpCamera = null;

    // Initialize camera when page loads
    window.addEventListener('load', function () {
        // Request camera access
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                // Create video element
                let video = document.createElement('video');
                video.style.width = '100%';
                video.style.height = '100%';
                video.autoplay = true;

                // Add video stream to preview
                video.srcObject = stream;
                document.getElementById('camera-preview-ktp').appendChild(video);

                ktpCamera = video;
            })
            .catch(function (err) {
                console.error("Camera error: ", err);
                alert("Could not access camera");
            });
    });

    // Take photo function
    function takeKtpSnapshot() {
        if (!ktpCamera) {
            alert('Camera not ready');
            return;
        }

        // Create canvas
        let canvas = document.createElement('canvas');
        canvas.width = ktpCamera.videoWidth;
        canvas.height = ktpCamera.videoHeight;

        // Draw video frame to canvas
        let context = canvas.getContext('2d');
        context.drawImage(ktpCamera, 0, 0);

        // Convert to base64
        let imageData = canvas.toDataURL('image/png');

        // Show result
        document.getElementById('photo-ktp').src = imageData;
        document.getElementById('foto_ktp').value = imageData;

        // Hide preview, show result
        document.getElementById('camera-preview-ktp').style.display = 'none';
        document.getElementById('camera-result-ktp').style.display = 'block';
    }

    // Stop camera when leaving page
    window.addEventListener('beforeunload', function () {
        if (ktpCamera && ktpCamera.srcObject) {
            ktpCamera.srcObject.getTracks().forEach(track => track.stop());
        }
    });
</script>