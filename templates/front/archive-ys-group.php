<?php

/**
 * @since 1.2.3
 */

defined('ABSPATH') || die;

require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>

<?php if (have_posts()) : ?>
    <div class="container">
        <div class="ys-groups-list">
            <?php while (have_posts()) : ?>
                <?php the_post(); ?>
                <div class="ys-groups">
                    <div class="ys-group-content">
                        <h1><?php the_title() ?></h1>
                        <?php the_content() ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>