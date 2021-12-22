<?php

namespace YsGroups\Admin;

/**
 * @since 1.0.6
 */
class GroupsList extends \WP_List_Table
{
    public function __construct()
    {
        parent::__construct([
            'singular' => __('Group', YS_GROUPS_TEXT_DOMAIN),
            'plural' => __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'ajax' => false,
        ]);
    }

    public static function getGroups()
    {
    }
}
