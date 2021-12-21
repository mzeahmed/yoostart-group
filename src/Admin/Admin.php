<?php

namespace YsGroups\Admin;

/**
 * @since 1.0.6
 */
class Admin
{
    public static function load()
    {
        new AdminColumn();
        new Options();

        add_action('admin_enqueue_scripts', [self::class, 'enqueueStyles']);
    }

    /**
     * Chargement des css admin
     *
     * @return void
     * @since 1.0.6
     */
    public static function enqueueStyles()
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
