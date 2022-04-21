<?php

namespace YsGroups\Controller\Admin;

use YsGroups\Controller\AbstractController;

class YsGroupPostCPT extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_action('init', [$this, 'registerPostType']);
    }

    public function registerPostType()
    {
        $labels = [
            'name' => __('Group posts', YS_GROUPS_TEXT_DOMAIN),
            'singular_name' => __('Group post', YS_GROUPS_TEXT_DOMAIN),
            'menu_name' => __('Group posts', YS_GROUPS_TEXT_DOMAIN),
            'all_items' => __('All group posts', YS_GROUPS_TEXT_DOMAIN),
            'add_new' => __('Create new post', YS_GROUPS_TEXT_DOMAIN),
            'new_item' => __('New group post', YS_GROUPS_TEXT_DOMAIN),
            'edit_tem' => __('Edit post', YS_GROUPS_TEXT_DOMAIN),
            'update_item' => __('Update post', YS_GROUPS_TEXT_DOMAIN),
            'view_item' => __('View post', YS_GROUPS_TEXT_DOMAIN),
            'not_found' => __('No post found', YS_GROUPS_TEXT_DOMAIN),
        ];

        // $rewrite = [
        //     'slug' => _x('group-post', YS_GROUPS_TEXT_DOMAIN),
        //     'with_front' => true,
        // ];

        $capabilities = [];

        $args = [
            'label' => __('groups posts', YS_GROUPS_TEXT_DOMAIN),
            'description' => __('Yoostart group posts', YS_GROUPS_TEXT_DOMAIN),
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

        register_post_type('ys-group-post', $args);
    }
}
