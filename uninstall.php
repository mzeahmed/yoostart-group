<?php

defined('WP_UNINSTALL_PLUGIN') || die();

register_deactivation_hook(__FILE__, function () {
    global $wp_rewrite;

    // Suppression et réécriture des règles de réécriture
    $wp_rewrite->flush_rules();
});
