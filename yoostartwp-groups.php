<?php

/**
 * @link              yoostart.com
 * @since             1.0.0
 * @package           Yoostartwp_Groups
 *
 * @wordpress-plugin
 * Plugin Name:       Yoostart Groups
 * Plugin URI:        https://yoostart.com
 * Description:       Plugin de gestion des groupes, nécessite le plugin yoostartwp
 * Version:           1.0.5
 * Author:            Yoostart
 * Author URI:        yoostart.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       yoostartwp-groups
 * Domain Path:       /languages
 */

use YsGroups\Model\PluginPosts;

defined('ABSPATH') || die;

if (! defined('YS_GROUPS_PLUGIN_FILE')) {
    define('YS_GROUPS_PLUGIN_FILE', __FILE__);
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * @return \YsGroups\YsGroups|null
 * @since 1.0.0
 */
function yoostart_groups(): ?\YsGroups\YsGroups
{
    return \YsGroups\YsGroups::getInstance();
}

yoostart_groups();

$posts = (new PluginPosts())->getPostsId(YS_GROUPS_POSTS);
