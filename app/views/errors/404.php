<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page not found | <?= APP_NAME ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/theme/admin-lte-3/dist/css/adminlte.min.css">
</head>
<body class="hold-transition">
    <div class="wrapper">
        <!-- Content Wrapper -->
        <div class="content-wrapper" style="margin-left: 0; background: white;">
            <!-- Main content -->
            <section class="content">
                <div class="error-page" style="margin-top: 100px;">
                    <h2 class="headline text-warning">404</h2>
                    <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                        <p>
                            We could not find the page you were looking for.
                            Meanwhile, you may <a href="<?= BASE_URL ?>">return to dashboard</a>.
                        </p>
                    </div>
                </div>
                <!-- /.error-page -->
            </section>
            <!-- /.content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/dist/js/adminlte.min.js"></script>
</body>
</html> 