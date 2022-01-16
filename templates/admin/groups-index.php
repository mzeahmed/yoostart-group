<?php

/**
 * @package YsAdminGroups\Admin
 * @since   1.0.6
 */

?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php echo get_bloginfo('name') . ' - ' . __('Groups', YS_GROUPS_TEXT_DOMAIN); ?></h1>

    <?php if (is_user_logged_in() && user_can(wp_get_current_user(), 'manage_options')) : ?>
        <a class="page-title-action" href="?page=ys_options_groups&action=create">
            <?php _e('Add new group', YS_GROUPS_TEXT_DOMAIN); ?>
        </a>
    <?php endif; ?>

    <div class="ys-groups-dashboard">
        <div class="container">
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

            <?php if (! empty($_REQUEST['s'])) : ?>
                <span class="subtitle">
                    <?php printf(
                        __('Search results for &#8220;%s&#8221;', YS_GROUPS_TEXT_DOMAIN),
                        wp_html_excerpt(esc_html(stripslashes($_REQUEST['s'])), 50)
                    ); ?>
                </span>
            <?php endif; ?>
            <hr class="wp-header-end">

            <div class="row">
                <?php $groupList->views(); ?>

                <form id="ys-groups-form" method="get">
                    <?php $groupList->search_box(__('Search all Groups', YS_GROUPS_TEXT_DOMAIN), 'ys-groups') ?>
                    <input type="hidden" name="page" value="<?php $pluginPage ?>"/>
                    <?php $groupList->display() ?>
                </form>
            </div>
        </div>
    </div>
</div>