<?php

namespace YsGroups\Admin;

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
     */
    public function groupsOptionsRender(): ?string
    {
        return View::render('admin/groupes', []);
    }
}
