<?php

namespace YsGroups\Admin;

use YsGroups\ViewRenderer\View;

/**
 * @since 1.1.0
 */
class MetaBox
{
    /**
     * @param object $item Informations sur le groupe actuellement affiché.
     *
     * @return string|null
     * @since 1.1.0
     */
    public static function editMetaboxStatus(object $item): ?string
    {
        $baseUrl = add_query_arg([
            'page' => 'ys_options_groups',
            'gid' => $item->id,
        ], admin_url('admin.php'));

        return View::render('admin/metabox/edit-metabox-status', ['baseUrl' => $baseUrl]);
    }
}
