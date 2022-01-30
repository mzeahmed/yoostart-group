<?php

namespace YsGroups;

use YsGroups\Model\DbSchema;
use YsGroups\Helpers\Helpers;

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
        Helpers::maybeDefineConstant('YS_GROUPS_INSTALLING', true);

        self::createTables();
        self::createPages();

        if (! file_exists(YS_GROUP_UPLOAD_DIR)) {
            self::createUploadDir();
        }

        delete_transient('ys_groups_installing');

        /**
         * @since 1.0.4
         */
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
                    'name' => 'groupes',
                    'title' => 'Groupes',
                    'content' => '<!-- wp:shortcode -->[ys_groups]<!-- /wp:shortcode -->',
                ],
                'groupe' => [
                    'name' => 'groupe',
                    'title' => 'Groupe',
                    'content' => '',
                ],
            ]
        );

        foreach ($pages as $key => $page) {
            Helpers::createPage(
                esc_sql($page['name']),
                'ys_groups_' . $key . '_page_id',
                $page['title'],
                $page['content'],
                0,
                ! empty($page['post_status']) ? $page['post_status'] : 'publish'
            );
        }
    }

    /**
     * Créé le repertoire d'uploads des images
     *
     * @return void
     * @since 1.1.6
     */
    public static function createUploadDir()
    {
        if (! file_exists(YS_GROUP_UPLOAD_DIR)) {
            mkdir(YS_GROUP_UPLOAD_DIR, 0755);
            chmod(YS_GROUP_UPLOAD_DIR, 0755);
        }

        self::setHtaccess();
    }

    /**
     * Protege le repertoire de telechargement avec un .htaccess
     *
     * @return void
     * @since 1.1.6
     */
    private static function setHtaccess()
    {
        Helpers::blockHTTPAccess(YS_GROUP_UPLOAD_DIR);
    }
}
