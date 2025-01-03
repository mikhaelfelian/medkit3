<?php if (NotificationHelper::has()): ?>
    <?php foreach (NotificationHelper::get() as $notification): ?>
        <div data-notification-type="<?= $notification['type'] ?>">
            <?= $notification['message'] ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?> 