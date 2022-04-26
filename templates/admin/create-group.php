<?php

/**
 * @package AdminGroupsController\Admin
 * @since   1.0.7
 */

?>

<div class="wrap">
    <h1><?php echo get_bloginfo('name') . ' - ' . __('Create new group', YS_GROUP_TEXT_DOMAIN); ?></h1>

    <div class="ys-groups-dashboard">
        <?php include __DIR__ . '/partials/_form.php' ?>
    </div>
</div>
