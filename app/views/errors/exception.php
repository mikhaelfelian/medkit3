<!DOCTYPE html>
<html>
<head>
    <title>Error <?= $code ?></title>
    <link rel="stylesheet" href="<?= BaseRouting::assets('vendor/adminlte/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition">
    <div class="content-wrapper d-flex align-items-center justify-content-center" style="min-height: 100vh; margin-left: 0;">
        <div class="error-page">
            <h2 class="headline text-danger"><?= $code ?></h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
                <p><?= $message ?></p>
                <p>
                    <a href="<?= BaseRouting::url('') ?>" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html> 