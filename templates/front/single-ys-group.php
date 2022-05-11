<?php

/**
 * Template d'un single group
 *
 * @since 1.2.3
 */

defined('ABSPATH') || die;
// dump(carbon_get_post_meta(get_the_ID(), YS_GROUP_COVER_PHOTO_META_KEY));
global $wp_query;
extract($wp_query->query_vars);

require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>

<?php if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>

        <?php require YS_GROUP_PATH . 'templates/front/partials/_group-header.php' ?>

        <div class="ys-group-content">
            <div class="ys-group-inner-content">
                <?php require YS_GROUP_PATH . 'templates/front/partials/_group-nav.php'; ?>

                <!-- Message flash-->
                <?php
                if (isset($_SESSION['ys_flash']['message'])) : ?>
                    <div class="container">
                        <div class="alert alert-<?= $_SESSION['ys_flash']['type'] ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><?php
                                echo $_SESSION['ys_flash']['message'] ?></h4>
                        </div>
                    </div>
                    <?php $_SESSION['ys_flash'] = []; ?>
                <?php endif; ?>
                <!-- Message flash-->

                <main class="ys-group-main-content container">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <!-- Affichage du feed du group -->
                            <div id="group_posts" data-group-id="<?= get_the_ID() ?>"></div>
                        </div>
                    </div>
                </main>

            </div>
        </div>
    <?php endwhile;
endif;
?>

<?php get_footer();