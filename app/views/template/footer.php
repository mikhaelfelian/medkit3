    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> <?= APP_VERSION ?>
        </div>
        <strong>Copyright &copy; <?= date('Y') ?> <a href="<?= BASE_URL ?>"><?= APP_NAME ?></a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= BASE_URL ?>/assets/theme/admin-lte-3/dist/js/adminlte.min.js"></script>
<?php if(isset($extra_js)): ?>
    <?= $extra_js ?>
<?php endif; ?>
</body>
</html> 