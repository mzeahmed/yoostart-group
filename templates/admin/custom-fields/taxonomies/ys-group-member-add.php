<?php

/**
 * @since 1.2.2
 */

?>

<div class="form-field">
    <label for="ys_group_member_user"><?php _e('User', YS_GROUP_TEXT_DOMAIN); ?></label>
    <?php wp_dropdown_users($args) ?>
</div>
