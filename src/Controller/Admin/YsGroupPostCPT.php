<?php

namespace YsGroup\Controller\Admin;

use YsGroup\Controller\AbstractController;

/**
 * @since 1.2.4
 */
class YsGroupPostCPT extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_action('init', [$this, 'registerPostType']);

        add_filter('manage_ys-group-post_posts_columns', [$this, 'manageCustomColumns']);
        add_action('manage_ys-group-post_posts_custom_column', [$this, 'showMetaValue'], 10, 3);

        add_filter('manage_edit-ys-group-post_sortable_columns', [$this, 'sortableColumn']);
    }

    /**
     * @return void
     * @since 1.2.4
     */
    public function registerPostType(): void
    {
        $labels = [
            'name' => __('Group posts', YS_GROUP_TEXT_DOMAIN),
            'singular_name' => __('Group post', YS_GROUP_TEXT_DOMAIN),
            'menu_name' => __('Group posts', YS_GROUP_TEXT_DOMAIN),
            'all_items' => __('All group posts', YS_GROUP_TEXT_DOMAIN),
            'add_new' => __('Create new group post', YS_GROUP_TEXT_DOMAIN),
            'new_item' => __('New group post', YS_GROUP_TEXT_DOMAIN),
            'edit_tem' => __('Edit group post', YS_GROUP_TEXT_DOMAIN),
            'update_item' => __('Update group  post', YS_GROUP_TEXT_DOMAIN),
            'view_item' => __('View group post', YS_GROUP_TEXT_DOMAIN),
            'not_found' => __('No group post found', YS_GROUP_TEXT_DOMAIN),
        ];

        $capabilities = [];

        $args = [
            'label' => __('groups posts', YS_GROUP_TEXT_DOMAIN),
            'description' => __('Yoostart group posts', YS_GROUP_TEXT_DOMAIN),
            'labels' => $labels,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields', 'comments'],
            'taxonomies' => [],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'has_archive' => true,
            'show_in_rest' => true,
            'rewrite' => false,
            'menu_icon' => 'dashicons-book',
            'menu_position' => 21,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'query_var' => 'ys_group_post',
            'capability_type' => 'post',
            'capabilities' => $capabilities,
        ];

        register_post_type(YS_GROUP_POST_CPT, $args);
    }

    /**
     * @param $columns
     *
     * @wp-hook manage_{$post_type}_posts_columns
     * @return array|null
     * @since   1.2.4
     */
    public function manageCustomColumns($columns): ?array
    {
        $columns['ys-group-post'] = __('Group title', YS_GROUP_TEXT_DOMAIN);

        return $columns;
    }

    /**
     * Affichage du titre du groupe lié au post
     *
     * @param $column
     * @param $postId
     *
     * @wp-hook manage_{$post_type}posts_custom_column
     * @return void
     * @since   1.2.4
     */
    public function showMetaValue($column, $postId): void
    {
        $groupId = get_post_meta($postId, YS_GROUP_ID_META_KEY, true);

        $group = get_post($groupId);

        if ($column === 'ys-group-post') {
            if (! empty($groupId)) {
                echo $group->post_title;
            }
        }
    }

    /**
     * Permet de trier la colonne
     *
     * @param $columns
     *
     * @wp-hook manage_{$screen->id}_sortable_column
     * @return mixed
     * @since   1.2.4
     */
    public function sortableColumn($columns): mixed
    {
        $columns['ys-group-post'] = 'ys-group-post';

        return $columns;
    }
}
