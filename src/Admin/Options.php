<?php

namespace YsGroups\Admin;

use YsGroups\Model\Groups;
use YsGroups\ViewRenderer\View;

/**
 * @since 1.0.6
 */
class Options
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'optionMenu'], 20);
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
            [$this, 'groupsOptionsRender'],
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
    public function groupsOptionsRender(): ?string
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
}
