<?php

/**
 * @package YsAdminGroups\Admin
 * @since   1.1.0
 */

?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Delete Groups', YS_GROUPS_TEXT_DOMAIN); ?></h1>
    <hr class="wp-header-end">

    <p><?php _e('You are about to delete the following groups:', YS_GROUPS_TEXT_DOMAIN) ?></p>

    <ul class="ys-group-delete-list">
        <?php foreach ($names as $name) : ?>
            <li><?php echo esc_html($name); ?></li>
        <?php endforeach; ?>
    </ul>

    <p><strong><?php _e('This action cannot be undone', YS_GROUPS_TEXT_DOMAIN); ?></strong></p>

    <a class="button-primary" href="<?php echo esc_url(wp_nonce_url(
        add_query_arg(['action' => 'do_delete', 'gid' => implode(',', $group_ids)], $base_url),
        'ys-groups-delete'
    )) ?>"><?php _e('Delete Permanently', YS_GROUPS_TEXT_DOMAIN); ?></a>
    <a class="button" href="<?php echo esc_attr($base_url) ?>"><?php _e('Cancel', YS_GROUPS_TEXT_DOMAIN); ?></a>
</div>