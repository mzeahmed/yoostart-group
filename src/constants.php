<?php

if (!function_exists('get_plugin_data')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

// dump(get_post_type_archive_link('ys-groups'));

global $wpdb;
$plugin_data = get_plugin_data(YS_GROUP_PLUGIN_FILE);
$uploadDir = wp_upload_dir();

const DS = DIRECTORY_SEPARATOR;

define('YS_GROUP_VERSION', $plugin_data['Version']);
define('YS_GROUP_PLUGIN_NAME', $plugin_data['Name']);
define('YS_GROUP_TEXT_DOMAIN', $plugin_data['TextDomain']);

define('YS_GROUP_PATH', dirname(YS_GROUP_PLUGIN_FILE) . DS);
define('YS_GROUP_URI', dirname(plugin_dir_url(__FILE__)));
define('YS_GROUP_URL', home_url('group/'));

const YS_GROUP_FRONT_IMG_URI = YS_GROUP_URI . DS . 'public' . DS . 'build' . DS . 'images' . DS;

define('YS_GROUP_UPLOAD_DIR', $uploadDir['basedir'] . DS . 'yoostartwp-groups' . DS);
define('YS_GROUP_UPLOAD_BASE_URL', $uploadDir['baseurl']);

define('YS_GROUP_DB_PREFIX', $wpdb->prefix . 'ys_group_');

// Postmetas
const YS_GROUP_STATUS_META_KEY = '_ys_group_status';
const YS_GROUP_ADMIN_META_KEY = '_ys_group_admin_meta_key';
const YS_GROUP_ID_META_KEY = '_ys_group_id_meta_key';
const YS_GROUP_COVER_PHOTO_META_KEY = 'ys_group_cover_photo_meta_key';

// Term meta
const YS_GROUP_MEMBER_USER_TERM_META_KEY = '_ys_group_member_user';

// Rajouter le nom des pages nécessaires
// const YS_GROUP_POSTS = [
//     'groupes',
//     'groupe',
// ];
