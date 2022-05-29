<?php

namespace YsGroup\Controller\Admin\Metaboxes\TermMetas;

use YsGroup\Controller\AbstractController;

class YsGroupsMemberTermMeta extends AbstractController
{
    private array $args;

    public function __construct()
    {
        parent::__construct();

        $this->args = [
            'name' => YS_GROUP_MEMBER_USER_TERM_META_KEY,
            'id' => YS_GROUP_MEMBER_USER_TERM_META_KEY,
        ];

        add_action('ys_group_member_add_form_fields', [$this, 'addFormField']);
        add_action('ys_group_member_edit_form_fields', [$this, 'editFormField'], 10, 2);

        add_filter('manage_edit-ys_group_member_columns', [$this, 'manageColumns']);
        add_action('manage_ys_group_member_custom_column', [$this, 'showMetaValue'], 10, 3);

        add_action('created_ys_group_member', [$this, 'saveYsGroupMemberField']);
        add_action('edited_ys_group_member', [$this, 'saveYsGroupMemberField']);
    }

    /**
     * Champs page de création
     *
     * @param $taxonomy | ys_group_member
     * @wp-hook {$taxonomy}_add_form_fields
     *
     * @return string|null
     * @since 1.2.2
     */
    public function addFormField($taxonomy): ?string
    {
        return $this->render('admin/custom-fields/taxonomies/ys-group-member-add', [
            'args' => $this->args,
        ]);
    }

    /**
     * Champs page d'édition
     *
     * @param $term
     * @param $taxonomy
     * @wp-hook {$taxonomy}_edit_form_fields
     *
     * @return string|null
     * @since 1.2.2
     */
    public function editFormField($term, $taxonomy): ?string
    {
        $userId = get_term_meta($term->term_id, YS_GROUP_MEMBER_USER_TERM_META_KEY, true);
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
     * @wp-hook manage_edit-{$taxonomy}_columns
     * @return array
     * @since   1.2.2
     */
    public function manageColumns($columns): array
    {
        if (isset($columns['description'])) {
            unset($columns['description']);
        }

        $columns['ys_group_member'] = __('User', YS_GROUP_TEXT_DOMAIN);

        return $columns;
    }

    /**
     * @param $deprecated
     * @param $column
     * @param $termId
     *
     * @wp-hook manage_{$taxonomy}_custom_column
     * @return void
     * @since   1.2.2
     */
    public function showMetaValue($deprecated, $column, $termId)
    {
        /**
         * Valeur de la meta, ID de l'utilisateur lié à la taxonomie
         */
        $value = get_term_meta($termId, YS_GROUP_MEMBER_USER_TERM_META_KEY, true);
        $user = get_userdata($value);

        $userSlug = get_user_meta($value, YS_USER_SLUG);

        if ($column === 'ys_group_member') :
            if ($user) :?>
                <a href="<?php echo home_url('/profil/' . $userSlug[0]); ?>" target="_blank">
                    <?php echo $user->display_name ?>
                </a>
            <?php endif;
        endif;
    }

    /**
     * Persistance du champs personnamisé
     *
     * @param $termId
     *
     * @return void
     * @since   1.2.2
     * @wp-hook created_{$taxonomy}
     * @wp-hook edited_{$taxonomy}
     */
    public function saveYsGroupMemberField($termId)
    {
        if (isset($_POST[YS_GROUP_MEMBER_USER_TERM_META_KEY])) {
            update_term_meta($termId, YS_GROUP_MEMBER_USER_TERM_META_KEY, $_POST[YS_GROUP_MEMBER_USER_TERM_META_KEY]);
        }
    }
}
