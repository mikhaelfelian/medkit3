<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? APP_NAME ?></title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/dist/css/adminlte.min.css') ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php require APP_PATH . '/views/layouts/navbar.php'; ?>
        <?php require APP_PATH . '/views/layouts/sidebar.php'; ?>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <?= Notification::render() ?>
            <?= $content ?>
        </div>

        <?php require APP_PATH . '/views/layouts/footer.php'; ?>
    </div>

    <!-- Core Scripts -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/dist/js/adminlte.min.js') ?>"></script>
    
    <!-- Page specific scripts -->
    <?= $controller->getSection('script') ?>
</body>
</html> 