<?php

namespace YsGroups\Controller\Admin;

/**
 * @since 1.2.1
 */
class CustomPostType
{
    /**
     * @return void
     * @since 1.2.1
     */
    public static function customPostTypeInit()
    {
        $labels = [
            'name' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'singular_name' => __('Group', YS_GROUPS_TEXT_DOMAIN),
            'menu_name' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
        ];
        $rewrite = [
            'slug' => _x('group', YS_GROUPS_TEXT_DOMAIN),
            'with_front' => true,
        ];
        $args = [
            'label' => __('groups', YS_GROUPS_TEXT_DOMAIN),
            'description' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'labels' => $labels,
            'supports' => ['title', 'editor', 'thumbnail', 'comments', 'custom-fields'],
            'taxonomies' => ['ys_group_member'],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'rewrite' => $rewrite,
            'menu_icon' => 'dashicons-groups',
            'menu_position' => 20,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'query_var' => 'ys-group',
            'capability_type' => 'post',
        ];

        register_post_type('ys-groups', $args);
    }

    /**
     * @return void
     * @since 1.2.1
     */
    public static function customTaxonomy()
    {
        $labels = [
            'name' => _x('Members', 'Taxonomy General Name', YS_GROUPS_TEXT_DOMAIN),
            'singular_name' => _x('Member', 'Taxonomy Singular Name', YS_GROUPS_TEXT_DOMAIN),
            'menu_name' => __('Members', YS_GROUPS_TEXT_DOMAIN),
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
        ];

        register_taxonomy('ys_group_member', 'ys-groups', $args);
    }
}
