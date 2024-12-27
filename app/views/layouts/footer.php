        </div>
        <!-- /.content-wrapper -->
        
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2024 <a href="#">Medkit3</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <!-- Select2 -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/plugins/select2/js/select2.full.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= BaseRouting::asset('theme/admin-lte-3/dist/js/adminlte.min.js') ?>"></script>

    <!-- Initialize page-specific scripts -->
    <?php if (isset($pageScripts)) echo $pageScripts; ?>

    <script>
    // Global initialization for Select2
    $(document).ready(function() {
        if ($.fn.select2) {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
        }
    });
    </script>
</body>
</html>