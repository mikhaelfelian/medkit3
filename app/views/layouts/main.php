<?php
$settings = ViewHelper::loadModel('Pengaturan')->getSettings();
$faviconPath = !empty($settings->favicon) ? $settings->favicon : 'assets/theme/admin-lte-3/dist/img/AdminLTELogo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?> | <?= htmlspecialchars((string)($settings->judul_app ?? 'NUSANTARA HMVC')) ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BaseRouting::url($faviconPath) ?>">
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/dist/css/adminlte.min.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <!-- Additional CSS -->
    <?= $this->getSection('css') ?>
	
    <!-- Core Scripts -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/dist/js/adminlte.min.js') ?>"></script>

    <!-- jQuery -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
	
    <!-- Datepicker -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap-datepicker/bootstrap-datepicker.id.min.js') ?>"></script>
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>">

    <!-- Select2 -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
	<link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/select2/css/select2.min.css') ?>">
	<link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">

    <!-- Toastr -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/toastr/toastr.min.css') ?>">
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/toastr/toastr.min.js') ?>"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php require APP_PATH . '/views/layouts/navbar.php'; ?>
        <?php require APP_PATH . '/views/layouts/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?php require APP_PATH . '/views/partials/toastr.php'; ?>
            <?= $content ?>
        </div>

        <?php require APP_PATH . '/views/layouts/footer.php'; ?>
    </div>

    
    <!-- Page specific scripts -->
    <?php $controller->getSection('script') ?>
    <?php if (isset($pageScripts)) echo $pageScripts; ?>
</body>
</html> 