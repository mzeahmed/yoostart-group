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
            __('Groupes', YS_GROUPS_TEXT_DOMAIN),
            __('Groupes', YS_GROUPS_TEXT_DOMAIN),
            'manage_options',
            'ys_options_groups',
            [$this, 'groupsOptionsRender'],
            4
        );
    }

    /**
     * @return string|null
     * @since 1.0.6
     */
    public function groupsOptionsRender(): ?string
    {
        $groups = new Groups();

        return View::render('admin/groupes', [
            'groups' => $groups->getGroups(),
        ]);
    }
}
