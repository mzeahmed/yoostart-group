<?php

namespace YsGroups\Admin;

use YsGroups\Admin\AdminHelpers;
use YsGroups\Model\DbSchema;

/**
 * @since 1.0.0
 */
class OnPluginActivation
{
    /**
     * @return void
     * @since 1.0.0
     */
    public static function activation()
    {
        // Vérifie si nous ne sommes pas déjà en train d'exécuter cette action
        if ('yes' === get_transient('ys_groups_installing')) {
            return;
        }

        // Si nous sommes arrivés jusqu'ici, rien n'est encore en marche, réglons le transient maintenant.
        set_transient('', 'yes', MINUTE_IN_SECONDS * 10);
        AdminHelpers::maybeDefineConstant('YS_GROUPS_INSTALLING', true);

        self::createTables();
        self::createPages();

        delete_transient('ys_groups_installing');

        do_action('ys_groups_installed');
    }

    /**
     * Creation des tables en base de données
     *
     * @return void
     * @since 1.0.4
     */
    private static function createTables()
    {
        (new DbSchema())->createTables();
    }

    /**
     * Creation des pages
     *
     * @return void
     * @since 1.0.0
     */
    private static function createPages()
    {
        $pages = apply_filters(
            'ys_groups_create_pages',
            [
                'groupes' => [
                    'name' => _x('groups', 'Page slug', YS_GROUPS_TEXT_DOMAIN),
                    'title' => _x('Groups', 'Page title', YS_GROUPS_TEXT_DOMAIN),
                    'content' => '<!-- wp:shortcode -->[ys_groupes]<!-- /wp:shortcode -->',
                ],
            ]
        );

        foreach ($pages as $key => $page) {
            AdminHelpers::createPage(
                esc_sql($page['name']),
                'ys_groups_' . $key . '_page_id',
                $page['title'],
                $page['content'],
                0,
                ! empty($page['post_status']) ? $page['post_status'] : 'publish'
            );
        }
    }
}
