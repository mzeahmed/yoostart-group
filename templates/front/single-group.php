<?php

/**
 * @since 1.1.4
 */

global $wp_query;
extract($wp_query->query_vars);

?>

<?php require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>
<?php require YS_GROUPS_PATH . 'templates/front/partials/_group-header.php'; ?>

<div class="ys-group-content ">
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
            <div id="group-feed"></div>
        </main>
    </div>
</div>

<?php get_footer() ?>
