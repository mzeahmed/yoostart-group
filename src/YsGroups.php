<?php

namespace YsGroups;

/**
 * @package YsGroups
 * @since   1.0.0
 */
class YsGroups
{
    /**
     * Instance de YsGroups
     *
     * @var YsGroups|null
     */
    protected static ?YsGroups $instance = null;

    public function __construct()
    {
        $this->defineConstants();
        $this->initHooks();
    }

    /**
     * Lorsque WP a chargé tous les plugins, on déclenche le hook `ys_groups_loaded`.
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
     * @return YsGroups|null
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
    private function defineConstants()
    {
        if (! function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugin_data = get_plugin_data(YS_GROUPS_PLUGIN_FILE);

        define('YS_GROUPS_VERSION', $plugin_data['Version']);
        define('YS_GROUPS_PLUGIN_NAME', $plugin_data['Name']);
        define('YS_GROUPS_TEXT_DOMAIN', $plugin_data['TextDomain']);
        define('YS_GROUPS_PATH', dirname(YS_GROUPS_PLUGIN_FILE));
        define('YS_GROUPS_URL', dirname(plugin_dir_url(__FILE__)));
    }

    /**
     * @return void
     * @since 1.0.0
     */
    private function initHooks()
    {
        register_activation_hook(YS_GROUPS_PLUGIN_FILE, ['YsGroups\Install', 'install']);

        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
    }
}
