<?php

namespace YsGroups\Admin;

use YsGroups\Model\Groups;
use YsGroups\ViewRenderer\View;

/**
 * @since 1.0.6
 */
class OptionsMenu
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'optionMenu'], 20);
        add_action('admin_init', [$this, 'persistDatas']);
    }

    /**
     * @return void
     * @since 1.0.6
     */
    public function optionMenu()
    {
        add_submenu_page(
            'ys_options',
            __('Groups', YS_GROUPS_TEXT_DOMAIN),
            __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'manage_options',
            'ys_options_groups',
            [$this, 'groupsRender'],
            4
        );

        add_submenu_page(
            '',
            __('Create group', YS_GROUPS_TEXT_DOMAIN),
            __('Create group', YS_GROUPS_TEXT_DOMAIN),
            'manage_options',
            'ys_create_group',
            [$this, 'formRender']
        );
    }

    /**
     * @return string|null
     * @since 1.0.6
     */
    public function groupsRender(): ?string
    {
        $groupList = new GroupListTable();
        $groupList->prepare_items();

        return View::render('admin/groups-main', [
            'groupList' => $groupList,
        ]);
    }

    /**
     * @return string|null
     */
    public function formRender(): ?string
    {
        return View::render('admin/create-group', []);
    }

    /**
     * @return void
     */
    public function persistDatas()
    {
        $action = admin_url() . 'admin.php?page=ys_create_group';
        $user = wp_get_current_user();
        $groups = new Groups();

        if (isset($_POST['_ys_create_group_nonce'])) {
            if (! wp_verify_nonce($_POST['_ys_create_group_nonce'], $action)) {
                wp_die(
                    printf(
                        esc_html__(
                            'Sorry, nonce %s  dit not verify',
                            YS_GROUPS_TEXT_DOMAIN
                        ),
                        '_ys_create_group_nonce'
                    )
                );
            }

            if (
                isset($_POST['ys_group_name'])
                && isset($_POST['ys_group_description'])
                && isset($_POST['ys_group_status'])
            ) {
                $slug = str_replace(' ', '-', $_POST['ys_group_name']);

                $groups->persist(
                    $user->ID,
                    sanitize_text_field($_POST['ys_group_name']),
                    $groups->slugExist($slug) ?
                        sanitize_text_field($slug . '-' . rand(1, 10)) :
                        sanitize_text_field($slug),
                    sanitize_textarea_field($_POST['ys_group_description']),
                    $_POST['ys_group_status'],
                    wp_date('Y-m-d H:i:s')
                );

                wp_redirect(wp_get_referer(), 302, 'Yoostart Groups');
            }
        }
    }
}
