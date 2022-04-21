<?php

namespace YsGroups\Controller\Admin\Metaboxs;

use YsGroups\Controller\AbstractController;

/**
 * @since 1.1.0
 */
class StatusMetaBox extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_action('add_meta_boxes', [$this, 'addStatusMetabox'], 10, 2);
        add_action('save_post', [$this, 'saveStatusMetaKey'], 10, 2);
    }

    /**
     * @param string   $postType
     * @param \WP_Post $post
     *
     * @return void
     */
    public function addStatusMetabox(string $postType, \WP_Post $post)
    {
        if ($postType == 'ys-group' && current_user_can('publish_posts', $post)) {
            add_meta_box(
                YS_GROUP_STATUS_META_KEY . '_postbox',
                'Status',
                [$this, 'renderStatusBox'],
                'ys-group',
                'side',
                'high'
            );
        }
    }

    /**
     * @param $post
     *
     * @return string|null
     */
    public function renderStatusBox($post): ?string
    {
        $value = get_post_meta($post->ID, YS_GROUP_STATUS_META_KEY, true);

        return $this->render('admin/metabox/status-metabox', ['value' => $value]);
    }

    /**
     * Persistance de la meta en bdd
     *
     * @param int      $postId
     * @param \WP_Post $post
     *
     * @return void
     */
    public function saveStatusMetaKey(int $postId, \WP_Post $post)
    {
        if (
            ! isset($_POST['_ys_group_status_nonce'])
            && ! wp_verify_nonce($_POST['_ys_group_status_nonce'], '_ys_group_status_nonce')
        ) {
            return;
        }

        if (isset($_POST['ys_group_status_meta']) && current_user_can('publish_posts', $post)) {
            update_post_meta($postId, YS_GROUP_STATUS_META_KEY, $_POST['ys_group_status_meta']);
        }
    }
}
