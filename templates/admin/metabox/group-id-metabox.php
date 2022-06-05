<?php

/**
 * @since 1.2.3
 */

wp_nonce_field('_ys_group_id_nonce', '_ys_group_id_nonce');

?>

<input type="hidden" value="0" name="<?php echo YS_GROUP_STATUS_META_KEY ?>">

<label for="ys_group_id_meta"><?php _e('Select group', YS_GROUP_TEXT_DOMAIN); ?></label><br>
<select name="ys_group_id_meta">
    <?php foreach ($groups as $group) : ?>
        <option <?= selected($groupId, $group->ID) ?> value="<?php echo esc_attr($group->ID); ?>">
            <?php echo esc_html($group->post_title); ?>
        </option>
    <?php endforeach; ?>
</select>
