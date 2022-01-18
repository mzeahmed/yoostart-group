<?php

namespace YsGroups\Controller\Admin;

use YsGroups\Controller\AbstractController;

/**
 * @since 1.1.0
 */
class MetaBox extends AbstractController
{
    /**
     * @param object $item Informations sur le groupe actuellement affiché.
     *
     * @return string|null
     * @since 1.1.0
     */
    public function editMetaboxStatus(object $item): ?string
    {
        $baseUrl = add_query_arg([
            'page' => 'ys_options_groups',
            'gid' => $item->id,
        ], admin_url('admin.php'));

        return $this->render('admin/metabox/edit-metabox-status', ['baseUrl' => $baseUrl]);
    }
}
