<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $settings->judul_app ?> - <?= $title ?? '' ?></title>
    
    <?php if ($settings->favicon): ?>
    <link rel="icon" type="image/x-icon" href="<?= BaseRouting::url($settings->favicon) ?>">
    <?php endif; ?>
    
    <!-- Other head elements -->
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= BaseRouting::url('') ?>" class="brand-link">
                <?php if ($settings->logo): ?>
                <img src="<?= BaseRouting::url($settings->logo) ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <?php endif; ?>
                <span class="brand-text font-weight-light"><?= $settings->judul_app ?></span>
            </a>
            
            <!-- Sidebar content -->
        </aside>

        <!-- Content -->
        <?= $content ?>
        
        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y') ?> <?= $settings->judul_app ?></strong>
            All rights reserved.
        </footer>
    </div>
    <!-- Scripts -->
</body>
</html> 