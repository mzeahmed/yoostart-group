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

// Postmetas
const YS_GROUP_STATUS_META_KEY = '_ys_group_status';
const GROUP_ADMIN_META_KEY = '_group_admin_meta_key';
const YS_GROUP_ID_META_KEY = '_ys_group_id_meta_key';
const YS_GROUP_COVER_PHOTO_META_KEY = 'ys_group_cover_photo_meta_key';

// Term meta
const YS_GROUP_MEMBER_USER_TERM_META_KEY = '_ys_group_member_user';

// Rajouter le nom des pages nécessaires
const YS_GROUPS_POSTS = [
    'groupes',
    'groupe',
];

function myspace_get_posts_by_tag(WP_REST_Request $request)
{
    // get slug and page number
    $slug = $request['slug'];
    $page = $request['page'];

    // get tag -> more info here: https://www.coditty.com/code/wordpress-rest-api-get-posts-by-tag
    $term = get_term_by('slug', $slug, 'post_tag');

    $args = [
        'tag__in' => $term->term_id,
        'posts_per_page' => $posts_per_page,
        'paged' => $page,
        'orderby' => 'date',
        'order' => 'desc',
    ];
    // use WP_Query to get the results with pagination
    $query = new WP_Query($args);

    // if no posts found return
    if (empty($query->posts)) {
        return new WP_Error('no_posts', __('No post found'), ['status' => 404]);
    }

    // set max number of pages and total num of posts
    $max_pages = $query->max_num_pages;
    $total = $query->found_posts;

    $posts = $query->posts;

    // prepare data for output
    $controller = new WP_REST_Posts_Controller('post');

    foreach ($posts as $post) {
        $response = $controller->prepare_item_for_response($post, $request);
        $data[] = $controller->prepare_response_for_collection($response);
    }

    // set headers and return response
    $response = new WP_REST_Response($data, 200);

    $response->header('X-WP-Total', $total);
    $response->header('X-WP-TotalPages', $max_pages);

    return $response;
}
