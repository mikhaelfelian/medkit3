<?php if (ToastrHelper::has()): ?>
    <script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        
        <?php foreach (ToastrHelper::get() as $notification): ?>
            toastr.<?= $notification['type'] ?>(
                <?= json_encode($notification['message']) ?>,
                <?= json_encode($notification['title']) ?>
            );
        <?php endforeach; ?>
    });
    </script>
<?php endif; ?> 