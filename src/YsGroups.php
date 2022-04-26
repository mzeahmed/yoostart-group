<?php

namespace YsGroups;

use YsGroups\Controller\Admin\YsGroupCPT;
use YsGroups\Controller\Admin\YsGroupPostCPT;

/**
 * @package AdminGroupsController
 * @since   1.0.0
 */
class YsGroups
{
    /**
     * Instance de AdminGroupsController
     *
     * @var YsGroups|null
     */
    protected static ?YsGroups $instance = null;

    public function __construct()
    {
        $this->initHooks();
    }

    /**
     * @return void
     * @since 1.0.0
     */
    private function initHooks(): void
    {
        register_activation_hook(YS_GROUPS_PLUGIN_FILE, [OnPluginActivation::class, 'activation']);

        add_action('init', function () {
            load_plugin_textdomain(YS_GROUP_TEXT_DOMAIN, false, YS_GROUP_PATH . 'languages');
        });

        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
        add_filter('body_class', [$this, 'bodyClass']);

        /**
         * Refresh des permaliens à l'activation du plugin
         *
         * @since 1.2.1
         */
        register_activation_hook(YS_GROUPS_PLUGIN_FILE, function () {
            (new YsGroupPostCPT())->registerPostType();
            (new YsGroupCPT())->registerPostType();

            flush_rewrite_rules();
        });
    }

    /**
     * S'assure qu'une seule instance de AdminGroupsController est chargée
     *
     * @return YsGroups|null
     * @see   yoostart_groups()
     * @since 1.0.0
     */
    public static function getInstance(): ?YsGroups
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Lorsque WP a fini de charger tous les plugins, on déclenche le hook `ys_groups_loaded`.
     *
     * Cela permet de s'assurer que `ys_groups_loaded` n'est appelé
     * qu'après que tous les autres plugins aient été chargés,
     * afin d'éviter les problèmes causés par les noms des répertoires de plugins
     * qui changent l'ordre de chargement.
     *
     * @return void
     * @since 1.0.0
     */
    public function onPluginsLoaded()
    {
        do_action('ys_groups_loaded');
    }

    /**
     * Ajout de classes CSS dans la balise body
     *
     * @param $classes
     *
     * @return mixed
     * @since 1.1.2
     */
    public function bodyClass($classes): mixed
    {
        $group_slug = get_query_var('gslug');

        if (is_page('Groupes') || (is_archive() && get_post_type() == 'ys-group')) {
            $classes[] = 'ys-groups-groups';
        }

        if (isset($group_slug)) {
            $classes[] = 'ys-groups-single-group';
        }

        return $classes;
    }
}
