<?php

namespace YsGroups\Admin;

/**
 * @since 1.0.6
 */
class Admin
{
    public AdminColumn $adminColumn;
    public Options $options;

    /**
     * @param AdminColumn $adminColumn
     * @param Options     $options
     */
    public function __construct(AdminColumn $adminColumn, Options $options)
    {
        $this->adminColumn = $adminColumn;
        $this->options     = $options;

        add_action('admin_enqueue_scripts', [$this, 'enqueueStyles']);
    }

    /**
     * Chargement des css admin
     *
     * @return void
     * @since 1.0.6
     */
    public function enqueueStyles()
    {
        if (str_contains($_SERVER['REQUEST_URI'], 'ys_options_groups')) {
            wp_enqueue_style(
                'ys-groups-admin',
                YS_GROUPS_URL . '/public/css/admin.css',
                [],
                YS_GROUPS_VERSION,
                'all'
            );
        }
    }
}
