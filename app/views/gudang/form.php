<?php
require_once APP_PATH . '/helpers/GudangHelper.php';
?>

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
                    <li class="breadcrumb-item"><a href="<?= BaseRouting::url('gudang') ?>">Data Gudang</a></li>
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
                <div class="card-tools">
                    <a href="<?= BaseRouting::url('gudang') ?>" class="btn btn-tool">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
            <form action="<?= $data ? BaseRouting::url('gudang/edit/' . $data->id) : BaseRouting::url('gudang/add') ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                <div class="card-body rounded-0">
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" class="form-control rounded-0" id="kode" name="kode"
                            value="<?= $data ? htmlspecialchars((string)$data->kode) : generateGudangCode() ?>" 
                            placeholder="Kode akan dibuat otomatis"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="gudang">Nama Gudang</label>
                        <input type="text" class="form-control rounded-0" id="gudang" name="gudang"
                            value="<?= $data ? htmlspecialchars((string)$data->gudang) : '' ?>"
                            placeholder="Masukkan nama gudang"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control rounded-0" id="keterangan" name="keterangan" rows="3"
                            placeholder="Masukkan keterangan"><?= $data ? htmlspecialchars((string)$data->keterangan) : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="d-flex gap-3">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="status1" name="status" value="1" <?= (!$data || ($data && $data->status == '1')) ? 'checked' : '' ?> required>
                                <label for="status1" class="custom-control-label">Aktif</label>
                            </div>
                            <div class="custom-control custom-radio ml-3">
                                <input class="custom-control-input" type="radio" id="status0" name="status" value="0" <?= ($data && $data->status == '0') ? 'checked' : '' ?> required>
                                <label for="status0" class="custom-control-label">Non Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Gudang Utama</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" 
                                   id="status_gd" name="status_gd" value="1"
                                   <?= ($data && $data->status_gd == '1') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="status_gd">Aktifkan sebagai gudang utama</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer rounded-0">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?= BaseRouting::url('gudang') ?>" class="btn btn-default rounded-0">
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
</section> 