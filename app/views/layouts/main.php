<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
    $settings = ViewHelper::loadModel('Pengaturan')->getSettings();
    $faviconPath = !empty($settings->favicon) ? BaseRouting::url($settings->favicon) : BaseRouting::asset('theme/admin-lte-3/dist/img/AdminLTELogo.png');
    ?>
    <link rel="icon" type="image/x-icon" href="<?= $faviconPath ?>">
    <title><?php echo $title ?? 'Dashboard'; ?> | <?php echo $settings->judul_app ?? 'NUSANTARA HMVC'; ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo BaseRouting::asset('theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo BaseRouting::asset('theme/admin-lte-3/dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <?php 
        $layoutPath = ROOT_PATH . '/app/views/layouts/';
        require_once $layoutPath . 'navbar.php';
        require_once $layoutPath . 'sidebar.php';
        
        echo $content;
        
        require_once $layoutPath . 'footer.php';
        ?>
    </div>

    <!-- jQuery -->
    <script src="<?php echo BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js'); ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo BaseRouting::asset('theme/admin-lte-3/dist/js/adminlte.min.js'); ?>"></script>
</body>
</html> 