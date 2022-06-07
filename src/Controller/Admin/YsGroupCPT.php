<?php

namespace YsGroup\Controller\Admin;

use YsGroup\Controller\AbstractController;

/**
 * @since 1.2.1
 */
class YsGroupCPT extends AbstractController
{
    /**
     * @since 1.2.2
     */
    public function __construct()
    {
        parent::__construct();

        add_action('init', [$this, 'registerPostType']);
        add_action('init', [$this, 'registerTaxonomy']);

        add_filter('use_block_editor_for_post_type', [$this, 'disableGutenberg'], 10, 2);

        /**
         * @todo à paufinern, ne fonctionne pas
         */
        add_filter('get_the_archive_description', [$this, 'archivePageTitle'], 10);
    }

    /**
     * Enregistrement du post type ys-group
     *
     * @return void
     * @since 1.2.1
     */
    public function registerPostType(): void
    {
        $labels = [
            'name' => __('Groups', YS_GROUP_TEXT_DOMAIN),
            'singular_name' => __('Group', YS_GROUP_TEXT_DOMAIN),
            'add_new ' => _x('Add new', 'ys-group', YS_GROUP_TEXT_DOMAIN),
            'add_new_item' => __('Create new group', YS_GROUP_TEXT_DOMAIN),
            'edit_item' => __('Edit group', YS_GROUP_TEXT_DOMAIN),
            'view_item' => __('View group', YS_GROUP_TEXT_DOMAIN),
            'not_found' => __('No group found', YS_GROUP_TEXT_DOMAIN),
            'all_items' => __('All groups', YS_GROUP_TEXT_DOMAIN),
            'insert_into_item ' => __('Insert into group', YS_GROUP_TEXT_DOMAIN),
            'update_item' => __('Update group', YS_GROUP_TEXT_DOMAIN),
            'set_featured_image' => __('Add avatar', YS_GROUP_TEXT_DOMAIN),
            'remove_featured_image' => __('Remove avatar', YS_GROUP_TEXT_DOMAIN),
            'menu_name' => __('Groups', YS_GROUP_TEXT_DOMAIN),
            'new_item' => __('New group', YS_GROUP_TEXT_DOMAIN),
            'featured_image' => __('Avatar', YS_GROUP_TEXT_DOMAIN),
        ];

        $rewrite = [
            'slug' => _x('group', YS_GROUP_TEXT_DOMAIN),
            'with_front' => true,
        ];

        $capabilities = [];

        $args = [
            'label' => __('groups', YS_GROUP_TEXT_DOMAIN),
            'description' => __('Yoostart groups', YS_GROUP_TEXT_DOMAIN),
            'labels' => $labels,
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'taxonomies' => ['ys_group_member'],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'has_archive' => true,
            'show_in_rest' => true,
            'rewrite' => $rewrite,
            'menu_icon' => 'dashicons-groups',
            'menu_position' => 20,
            'exclude_from_search' => true,
            'publicly_queryable' => true,
            'query_var' => 'ys_group',
            'capability_type' => 'post',
            'capabilities' => $capabilities,
        ];

        register_post_type(YS_GROUP_CPT, $args);
    }

    /**
     * Enregistrement du taxonomy ys_group_member
     *
     * @return void
     * @since 1.2.1
     */
    public function registerTaxonomy(): void
    {
        $labels = [
            'name' => _x('Members', 'Taxonomy General Name', YS_GROUP_TEXT_DOMAIN),
            'singular_name' => _x('Member', 'Taxonomy Singular Name', YS_GROUP_TEXT_DOMAIN),
            'menu_name' => __('Members', YS_GROUP_TEXT_DOMAIN),
            'all_items' => __('All members', YS_GROUP_TEXT_DOMAIN),
            'new_item_name' => __('Add new member', YS_GROUP_TEXT_DOMAIN),
            'add_new_item' => __('Add new member', YS_GROUP_TEXT_DOMAIN),
            'edit_item' => __('Edit member', YS_GROUP_TEXT_DOMAIN),
            'update_item' => __('Updit member', YS_GROUP_TEXT_DOMAIN),
            'view_item' => __('View member', YS_GROUP_TEXT_DOMAIN),
            'not_found' => __('No group member found', YS_GROUP_TEXT_DOMAIN),
        ];

        $args = [
            'labels' => $labels,
            'hierarchical' => false,
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
        ];

        register_taxonomy('ys_group_member', YS_GROUP_CPT, $args);
    }

    /**
     * Desctaivation de Gutenberg pour les custom post type
     *
     * @param $status
     * @param $postType
     *
     * @return false|mixed
     */
    public function disableGutenberg($status, $postType): mixed
    {
        $disabledpostTypes = [YS_GROUP_CPT, YS_GROUP_POST_CPT];

        if (in_array($postType, $disabledpostTypes, true)) {
            $status = false;
        }

        return $status;
    }

    /**
     * @param string $description
     *
     * @return string
     */
    public function archivePageTitle(string $description): string
    {
        if (is_post_type_archive(YS_GROUP_CPT)) {
            $description = __('Groups', YS_GROUP_TEXT_DOMAIN) . ' - ' . get_bloginfo('name');
        }

        return $description;
    }
}
