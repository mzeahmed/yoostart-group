<?php

/**
 * @package AdminGroupsController\Admin
 * @since   1.0.7
 * @see     createGroupe()
 */

?>

<div class="container ys-group-form-container">
    <div class="row">
        <div class="col-md-6">
            <form action="<?php $action ?>" method="post" name="ys_group_form" enctype="multipart/form-data">
                <?php if (! current_user_can('manage_options')) : ?>
                    <?php wp_die(__('Unauthorized user', YS_GROUPS_TEXT_DOMAIN)) ?>
                <?php endif; ?>
                <?php wp_nonce_field($action, '_ys_create_group_nonce') ?>

                <div class="form-group">
                    <label for="ys_group_name"><?php _e('Name', YS_GROUPS_TEXT_DOMAIN); ?></label>
                    <input type="text" class="form-control" name="ys_group_name" id="ys_group_name" required>
                </div>

                <div class="form-group">
                    <label for="ys_group_description"><?php _e('Description', YS_GROUPS_TEXT_DOMAIN); ?></label>
                    <textarea
                        class="form-control"
                        name="ys_group_description"
                        id="ys_group_description"
                        is="textarea-autogrow"
                        required
                    ></textarea>
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