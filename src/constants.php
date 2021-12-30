<?php

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
define('YS_GROUPS_DB_PREFIX', $wpdb->prefix . 'ys_group_');

// Rajouter le nom des pages nécessaires
const YS_GROUPS_POSTS = [
    'groupes',
];
