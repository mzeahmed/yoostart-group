<?php

if (! function_exists('get_plugin_data')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

global $wpdb;
$plugin_data = get_plugin_data(YS_GROUPS_PLUGIN_FILE);
$uploadDir = wp_upload_dir();

define('YS_GROUPS_VERSION', $plugin_data['Version']);
define('YS_GROUPS_PLUGIN_NAME', $plugin_data['Name']);
define('YS_GROUPS_TEXT_DOMAIN', $plugin_data['TextDomain']);

define('YS_GROUPS_PATH', dirname(YS_GROUPS_PLUGIN_FILE) . DIRECTORY_SEPARATOR);
define('YS_GROUPS_URI', dirname(plugin_dir_url(__FILE__)));
define('YS_GROUPS_URL', home_url('groupes/'));

define('YS_GROUPS_UPLOAD_DIR', $uploadDir['basedir'] . '/yoostartwp-groups/');
define('YS_GROUPS_UPLOAD_BASE_URL', $uploadDir['baseurl']);

define('YS_GROUPS_DB_PREFIX', $wpdb->prefix . 'ys_group_');

// Postmeta contenant le nom des images
const YS_GROUP_AVATAR_POSTMETA = 'ys_group_avatar_image';
const YS_GROUP_COVER_POSTMETA = 'ys_group_cover_image';

// Term meta
const YS_GROUP_MEMBER_USER = 'ys_group_member_user';

// Rajouter le nom des pages nécessaires
const YS_GROUPS_POSTS = [
    'groupes',
    'groupe',
];
