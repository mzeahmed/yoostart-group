<?php

/**
 * Template d'un single group
 *
 * @since 1.2.3
 */

defined('ABSPATH') || die;

global $wp_query;
extract($wp_query->query_vars);

require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>

<?php if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

        <?php require YS_GROUPS_PATH . 'templates/front/partials/_group-header.php' ?>

        <div class="ys-group-content">
            <div class="ys-group-inner-content">
                <?php require YS_GROUPS_PATH . 'templates/front/partials/_group-nav.php'; ?>

                <!-- Message flash-->
                <?php if (isset($_SESSION['ys_flash']['message'])) : ?>
                    <div class="container">
                        <div class="alert alert-<?= $_SESSION['ys_flash']['type'] ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><?php echo $_SESSION['ys_flash']['message'] ?></h4>
                        </div>
                    </div>
                    <?php $_SESSION['ys_flash'] = []; ?>
                <?php endif; ?>
                <!-- Message flash-->

                <main class="ys-group-main-content">
                    <!-- Affichage du feed du group, un autre custom post type ou autre -->
                    <div id="group-feed"></div>
                </main>

            </div>
        </div>
    <?php endwhile;
endif;
?>

<?php get_footer();
