<?php

namespace YsGroups;

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
     * @return void
     * @since 1.0.0
     */
    private function initHooks()
    {
        register_activation_hook(YS_GROUPS_PLUGIN_FILE, [OnPluginActivation::class, 'activation']);

        add_action('init', function () {
            load_plugin_textdomain(YS_GROUPS_TEXT_DOMAIN, false, YS_GROUPS_PATH . '/languages');
        });

        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
    }
}
