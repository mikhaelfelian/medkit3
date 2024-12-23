<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? APP_NAME ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= AssetHelper::theme('plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= AssetHelper::theme('dist/css/adminlte.min.css') ?>">
    <!-- Custom CSS -->
    <?php if (AssetHelper::exists('custom/css/style.css')): ?>
    <link rel="stylesheet" href="<?= AssetHelper::custom('css/style.css') ?>">
    <?php endif; ?>
    
    <?= $this->yield('styles') ?>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include ROOT_PATH . '/app/views/template/navbar.php'; ?>
        <?php include ROOT_PATH . '/app/views/template/sidebar.php'; ?>
        
        <!-- Content -->
        <?= $content ?>
        
        <?php include ROOT_PATH . '/app/views/template/footer.php'; ?>
    </div>

    <!-- jQuery -->
    <script src="<?= AssetHelper::theme('plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= AssetHelper::theme('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= AssetHelper::theme('dist/js/adminlte.min.js') ?>"></script>
    <!-- Custom Scripts -->
    <?php if (AssetHelper::exists('custom/js/script.js')): ?>
    <script src="<?= AssetHelper::custom('js/script.js') ?>"></script>
    <?php endif; ?>
    
    <?= $this->yield('scripts') ?>
    <script src="<?= AssetHelper::theme('plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
    <script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
    </script>
</body>
</html> 