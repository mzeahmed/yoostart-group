<?php

/**
 * @package YsGroups\Admin
 * @since   1.0.7.3
 */

?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form method="post" name="ys_group_form">
                <?php if (! current_user_can('manage_options')) : ?>
                    <?php wp_die(__('Unauthorized user', YS_GROUPS_TEXT_DOMAIN)) ?>
                <?php endif; ?>
                <?php wp_nonce_field(site_url() . $_SERVER['REQUEST_URI'], '_ys_create_group_nonce') ?>

                <div class="form-group">
                    <label for="ys_group_name"><?php _e('Name', YS_GROUPS_TEXT_DOMAIN); ?></label>
                    <input type="text" class="form-control" id="ys_group_name" required>
                </div>
                <div class="form-group">
                    <label for="ys_group_description"><?php _e('Description', YS_GROUPS_TEXT_DOMAIN); ?></label>
                    <textarea class="form-control" id="ys_group_description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="ys_group_status"><?php _e('Status', YS_GROUPS_TEXT_DOMAIN); ?></label>
                    <select name="ys_group_status" id="ys_group_status" class="form-select">
                        <option value="public">
                            <?php _e('Public', YS_GROUPS_TEXT_DOMAIN) ?>
                        </option>
                        <option value="private">
                            <?php _e('Private', YS_GROUPS_TEXT_DOMAIN) ?>
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?php _e('Save', YS_GROUPS_TEXT_DOMAIN); ?>
                </button>
            </form>
        </div>
    </div>
</div>
