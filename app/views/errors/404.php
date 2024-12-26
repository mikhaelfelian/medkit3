<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Not Found</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= BaseRouting::asset('theme/admin-lte-3/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition">
    <div class="wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>404 Error Page</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-warning"> 404</h2>
                <div class="error-content">
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>
                    <p>
                        <?= $_SESSION['error_message'] ?? 'We could not find the page you were looking for.' ?>
                    </p>
                    <p>
                        <a href="<?= BaseRouting::url('') ?>" class="btn btn-primary">Return to Dashboard</a>
                    </p>
                </div>
            </div>
        </section>
    </div>

    <!-- jQuery -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/dist/js/adminlte.min.js') ?>"></script>
</body>
</html> 