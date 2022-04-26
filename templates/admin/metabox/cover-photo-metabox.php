<?php

/**
 * @since 1.2.4
 */

wp_nonce_field('_ys_group_cover_photo_nonce', '_ys_group_cover_photo_nonce');

?>

<?php if ($imageId && get_post($imageId)) : ?>
    <?php if (isset($_wp_add_additional_image_sizes['post-thumbnail'])) :
        $thumbnail_html = wp_get_attachment_image($imageId, [$content_width, $content_width]);
    else :
        $thumbnail_html = wp_get_attachment_image($imageId, ['post-thumbnail']);
    endif;

    if (! empty($thumbnail_html)) :
        echo $thumbnail_html; ?>
        <p class="hide-if-no-js">
            <a href="javascript:;" id="remove_listing_image_button">
                <?php esc_html__('Remove image', YS_GROUP_TEXT_DOMAIN) ?>
            </a>
        </p>
        <input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="<?php esc_attr($imageId); ?>">
        <?php $content_width = $old_contenwidth;
    endif;
else :?>
    <img src="" alt="" style="width: <?= esc_attr($content_width) . 'px' ?>; height: auto; border: 0; display: none">
    <p class="hide-if-no-js">
        <a
            title="<?= esc_attr__('set listing image', YS_GROUP_TEXT_DOMAIN) ?>"
            href="javascript:;"
            id="upload_listing_image_button"
            data-uploader_title="<?= esc_attr__('Choose an image', YS_GROUP_TEXT_DOMAIN) ?>"
            data-uploader_button_text="<?= esc_attr__('Set listing image', YS_GROUP_TEXT_DOMAIN) ?>"
        >
            <?php echo esc_html__('Set listing image', YS_GROUP_TEXT_DOMAIN) ?>
        </a>
    </p>
    <input type="hidden" id="upload_listing_image" name="_listing_cover_image" value=""/>
<?php endif;
