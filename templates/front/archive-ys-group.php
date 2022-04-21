<?php

/**
 * @since 1.2.3
 */

defined('ABSPATH') || die;

require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php';

if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>
        <h1><?php the_title() ?></h1>
        <?php dump(wp_get_current_user()->display_name);
        the_content() ?>
    <?php endwhile;
endif;

get_footer();