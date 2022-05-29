<?php

namespace YsGroup\Controller\Admin\Metaboxes\PostMetas;

use YsGroup\Model\Groups;
use YsGroup\Controller\AbstractController;

/**
 *
 */
class GroupIdPostMetaBox extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_action('add_meta_boxes', [$this, 'addGroupIdMetabox'], 10, 2);
        add_action('save_post', [$this, 'saveGroupIdMetakey'], 10, 2);
    }

    /**
     * @param string $postType
     * @param \WP_Post $post
     *
     * @return void
     */
    public function addGroupIdMetabox(string $postType, \WP_Post $post): void
    {
        if ($postType == 'ys-group-post' && current_user_can('publish_posts', $post)) {
            add_meta_box(
                YS_GROUP_ID_META_KEY . '_postbox',
                __('Group', YS_GROUP_TEXT_DOMAIN),
                [$this, 'renderGroupIdBox'],
                'ys-group-post',
                'normal',
                'high'
            );
        }
    }

    /**
     * @param $post
     *
     * @return string|null
     */
    public function renderGroupIdBox($post): ?string
    {
        $groups = (new Groups())->getGroups();
        $groupId = get_post_meta($post->ID, YS_GROUP_ID_META_KEY, true);

        return $this->render('admin/metabox/group-id-metabox', [
            'groups' => $groups,
            'groupId' => $groupId,
        ]);
    }

    /**
     * Persistance de la meta en bdd
     *
     * @param int $postId
     * @param \WP_Post $post
     *
     * @return void
     */
    public function saveGroupIdMetakey(int $postId, \WP_Post $post): void
    {
        if (
            !isset($_POST['_ys_group_id_nonce'])
            && !wp_verify_nonce($_POST['_ys_group_id_nonce'], '_ys_group_id_nonce')
        ) {
            return;
        }

        if (isset($_POST['ys_group_id_meta']) && current_user_can('publish_posts', $post)) {
            update_post_meta($postId, YS_GROUP_ID_META_KEY, $_POST['ys_group_id_meta']);
        }
    }
}
