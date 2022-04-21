<?php

/**
 * @since 1.2.3
 */

wp_nonce_field('_ys_group_status_nonce', '_ys_group_status_nonce')
?>

<input type="hidden" value="0" name="<?php echo YS_GROUP_STATUS_META_KEY ?>">

<label for="ys_group_status_meta"><?php _e('Choose group status', YS_GROUPS_TEXT_DOMAIN); ?></label><br>
<select name="ys_group_status_meta">
    <option<?= selected('private', $value) ?> value="private">
        <?php _e('Private', YS_GROUPS_TEXT_DOMAIN); ?>
    </option>

    <option <?= selected('public', $value) ?> value="public">
        <?php _e('Public', YS_GROUPS_TEXT_DOMAIN); ?>
    </option>
</select>