<?php

namespace YsGroups;

use YsGroups\Model\Groups;
use YsGroups\ViewRenderer\View;
use YsGroups\Admin\OnPluginActivation;

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
     * S'assure qu'une seule instance de YsGroups est chargée
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
    private function defineConstants()
    {
        global $wpdb;

        if (! function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $plugin_data = get_plugin_data(YS_GROUPS_PLUGIN_FILE);

        define('YS_GROUPS_VERSION', $plugin_data['Version']);
        define('YS_GROUPS_PLUGIN_NAME', $plugin_data['Name']);
        define('YS_GROUPS_TEXT_DOMAIN', $plugin_data['TextDomain']);
        define('YS_GROUPS_PATH', dirname(YS_GROUPS_PLUGIN_FILE));
        define('YS_GROUPS_URL', dirname(plugin_dir_url(__FILE__)));
        define('YS_GROUP_DB_PREFIX', $wpdb->prefix . 'ys_group_');

        // Rajouter le nom des pages nécessaires
        define('YS_GROUPS_POSTS', [
            'groupes',
        ]);
    }

    /**
     * @return void
     * @since 1.0.0
     */
    private function initHooks()
    {
        register_activation_hook(YS_GROUPS_PLUGIN_FILE, [OnPluginActivation::class, 'activation']);

        add_action('plugins_loaded', [$this, 'onPluginsLoaded']);
        add_action('admin_notices', [$this, 'dependencyNotice']);
    }

    /**
     * @return bool|string
     */
    public function dependencyNotice(): bool|string
    {
        if (! class_exists('Yoostart')) {
            return View::render('admin/dependency-notice', []);
        }

        return false;
    }

    /**
     * Chargement des css et js du front
     *
     * @return void
     * @since 1.0.6
     */
    public function enqueueScripts()
    {
        if (str_contains($_SERVER['REQUEST_URI'], 'groups')) {
            wp_enqueue_style(
                'ys-group',
                YS_GROUPS_URL . '/public/css/app.css',
                [],
                YS_GROUPS_VERSION,
                'all'
            );

            wp_enqueue_script(
                'ys-group',
                YS_GROUPS_URL . '/public/js/app.js',
                [],
                YS_GROUPS_VERSION,
                true,
            );
        }
    }
}
