<?php

namespace YsGroups;

class Install
{
    /**
     * @return void
     * @since 1.0.0
     */
    public static function install()
    {
        // Vérifie si nous ne sommes pas déjà en train d'exécuter cette action
        if ('yes' === get_transient('ys_groups_installing')) {
            return;
        }

        // Si nous sommes arrivés jusqu'ici, rien n'est encore en marche, réglons le transient maintenant.
        set_transient('', 'yes', MINUTE_IN_SECONDS * 10);
        maybeDefineConstant('YS_GROUPS_INSTALLING', true);

        self::createTables();
        self::createOptions();

        delete_transient('ys_groups_installing');

        do_action('ys_groups_installed');
    }

    /**
     * Creation des tables en base de données
     *
     * @return void
     * @since 1.0.0
     */
    private static function createTables()
    {
        global $wpdb;
        $wpdb->hide_errors();

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        // créer les tables nécessaires
    }

    /**
     * Creation des options
     *
     * @return void
     * @since 1.0.0
     */
    private static function createOptions()
    {
    }

    /**
     * Creation des pages
     *
     * @return void
     * @since 1.0.0
     */
    private static function createPages()
    {
    }
}
