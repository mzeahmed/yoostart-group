<?php

namespace YsGroups\Controller\Admin;

use YsGroups\Controller\AbstractController;

/**
 * @since 1.2.1
 */
class CustomPostType extends AbstractController
{
    private array $args;

    /**
     * @since 1.2.2
     */
    public function __construct()
    {
        parent::__construct();

        $this->args = [
            'name' => YS_GROUP_MEMBER_USER,
            'id' => YS_GROUP_MEMBER_USER,
        ];

        add_action('init', [$this, 'registerCPT']);
        add_action('init', [$this, 'registerCT']);

        add_action('ys_group_member_add_form_fields', [$this, 'addFormField']);
        add_action('ys_group_member_edit_form_fields', [$this, 'editFormField'], 10, 2);

        add_filter('manage_edit-ys_group_member_columns', [$this, 'manageColumns']);
        add_action('manage_ys_group_member_custom_column', [$this, 'showMetaValue'], 10, 3);

        add_action('created_ys_group_member', [$this, 'saveYsGroupMemberField']);
        add_action('edited_ys_group_member', [$this, 'saveYsGroupMemberField']);
    }

    /**
     * Enregistrement du post type ys-groups
     *
     * @return void
     * @since 1.2.1
     */
    public function registerCPT()
    {
        $labels = [
            'name' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'singular_name' => __('Group', YS_GROUPS_TEXT_DOMAIN),
            'menu_name' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'all items' => __('All groups', YS_GROUPS_TEXT_DOMAIN),
            // 'add_new_item' => __('Add new group', YS_GROUPS_TEXT_DOMAIN),
            'add_new' => __('Create group', YS_GROUPS_TEXT_DOMAIN),
            'new_item' => __('New group', YS_GROUPS_TEXT_DOMAIN),
            'edit_item' => __('Edit group', YS_GROUPS_TEXT_DOMAIN),
            'update_item' => __('Update group', YS_GROUPS_TEXT_DOMAIN),
            'view_item' => __('View group', YS_GROUPS_TEXT_DOMAIN),
            'not_found' => __('No group found', YS_GROUPS_TEXT_DOMAIN),
        ];

        $rewrite = [
            'slug' => _x('group', YS_GROUPS_TEXT_DOMAIN),
            'with_front' => true,
        ];

        $capabilities = [];

        $args = [
            'label' => __('groups', YS_GROUPS_TEXT_DOMAIN),
            'description' => __('Yoostart groups', YS_GROUPS_TEXT_DOMAIN),
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
            'query_var' => 'ys-group',
            'capability_type' => 'post',
            'capabilities' => $capabilities,
        ];

        register_post_type('ys-groups', $args);
    }

    /**
     * Enregistrement du taxonomy ys_group_member
     *
     * @return void
     * @since 1.2.1
     */
    public function registerCT()
    {
        $labels = [
            'name' => _x('Members', 'Taxonomy General Name', YS_GROUPS_TEXT_DOMAIN),
            'singular_name' => _x('Member', 'Taxonomy Singular Name', YS_GROUPS_TEXT_DOMAIN),
            'menu_name' => __('Members', YS_GROUPS_TEXT_DOMAIN),
            'all_items' => __('All members', YS_GROUPS_TEXT_DOMAIN),
            'new_item_name' => __('Add new member', YS_GROUPS_TEXT_DOMAIN),
            'add_new_item' => __('Add new member', YS_GROUPS_TEXT_DOMAIN),
            'edit_item' => __('Edit member', YS_GROUPS_TEXT_DOMAIN),
            'update_item' => __('Updit member', YS_GROUPS_TEXT_DOMAIN),
            'view_item' => __('View member', YS_GROUPS_TEXT_DOMAIN),
            'not_found' => __('No group member found', YS_GROUPS_TEXT_DOMAIN),
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

        register_taxonomy('ys_group_member', 'ys-groups', $args);
    }

    /**
     * @param $taxonomy | ys_group_member
     *
     * @return string|null
     * @since 1.2.2
     */
    public function addFormField($taxonomy): ?string
    {
        // $args = [
        //     'name' => YS_GROUP_MEMBER_USER,
        //     'id' => YS_GROUP_MEMBER_USER,
        // ];

        // dump($taxonomy);

        return $this->render('admin/custom-fields/taxonomies/ys-group-member-add', [
            'args' => $this->args,
        ]);
    }

    /**
     * @param $term
     * @param $taxonomy
     *
     * @return string|null
     * @since 1.2.2
     */
    public function editFormField($term, $taxonomy): ?string
    {
        $userId = get_term_meta($term->term_id, YS_GROUP_MEMBER_USER, true);
        $user = get_userdata($userId);

        $args = ['fields' => ['ID', 'display_name'],];
        $users = get_users($args);

        $this->args['selected'] = $user->ID;

        return $this->render('admin/custom-fields/taxonomies/ys-group-member-edit', [
            'user' => $user,
            'users' => $users,
            'args' => $this->args,
        ]);
    }

    /**
     * @param $columns
     *
     * @return array
     * @since 1.2.2
     */
    public function manageColumns($columns): array
    {
        if (isset($columns['description'])) {
            unset($columns['description']);
        }

        $columns['ys_group_member'] = __('User', YS_GROUPS_TEXT_DOMAIN);

        return $columns;
    }

    /**
     * @param $deprecated
     * @param $column
     * @param $termId
     *
     * @return void
     * @since 1.2.2
     */
    public function showMetaValue($deprecated, $column, $termId)
    {
        /**
         * Valeur de la meta, ID de l'utilisateur lié à la taxonomie
         */
        $value = get_term_meta($termId, YS_GROUP_MEMBER_USER, true);
        $user = get_userdata($value);

        $userSlug = get_user_meta($value, YS_USER_SLUG);

        // dump($userSlug[0], home_url('/profil/' . $userSlug[0]));

        if ($column === 'ys_group_member') :?>
            <a href="<?php echo home_url('/profil/' . $userSlug[0]); ?>" target="_blank">
                <?php echo $user->display_name ?>
            </a>
        <?php endif;
    }

    /**
     * @param $termId
     *
     * @return void
     * @since 1.2.2
     */
    public function saveYsGroupMemberField($termId)
    {
        if (isset($_POST[YS_GROUP_MEMBER_USER])) {
            update_term_meta($termId, YS_GROUP_MEMBER_USER, $_POST[YS_GROUP_MEMBER_USER]);
        }
    }
}
