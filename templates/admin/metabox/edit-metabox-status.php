<?php

/**
 * @package YsAdminGroups\Admin\Metabox
 * @since   1.1.0
 */

?>

<div id="submitcomment" class="submitbox">
    <div id="major-publishing-actions">
        <div id="delete-action">
            <a class="submitdelete deletion"
               href="<?php echo esc_url(wp_nonce_url(
                   add_query_arg('action', 'delete', $baseUrl),
                   'ys-groups-delete'
               )); ?>"><?php _e('Delete Group', YS_GROUPS_TEXT_DOMAIN) ?></a>
        </div>

        <div id="publishing-action">
            <?php submit_button(__('Save Changes', YS_GROUPS_TEXT_DOMAIN), 'primary', 'save', false); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
