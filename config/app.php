<?php

require_once __DIR__ . '/constants.php';

$errors = function (string $message, string $subtitle = '', string $title = '') {
    $title = $title ?? esc_html__('Error', YS_GROUP_TEXT_DOMAIN);
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p>";
    wp_die($message);
};

/** Test de la version de php */
if (version_compare('7.4', phpversion(), '>=')) {
    $errors(
        esc_html__('Please install 7.4 or higher', YS_GROUP_TEXT_DOMAIN),
        esc_html__('Incompatible PHP version', YS_GROUP_TEXT_DOMAIN)
    );
}

/** Test de la version de Wordpress */
if (version_compare('5.4', get_bloginfo('version'), '>=')) {
    $errors(
        esc_html__('Please install 5.4 or higher', YS_GROUP_TEXT_DOMAIN),
        esc_html__('Incompatible WordPress version', YS_GROUP_TEXT_DOMAIN)
    );
}


if (! file_exists($composer = YS_GROUP_PATH . 'vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>', YS_GROUP_TEXT_DOMAIN));
}

require_once $composer;
