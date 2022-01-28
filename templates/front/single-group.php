<?php

/**
 * @since 1.1.4
 */

global $wp_query;
extract($wp_query->query_vars);
?>

<?php require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>
<?php require YS_GROUPS_PATH . 'templates/front/partials/group-header.php'; ?>

<div class="ys-group-content ">
    <div class="ys-group-inner-content">
        <nav class="navbar navbar-expand-md navbar-light bg-light ys-group-nav">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ysGroupNavbarCollapse"
                    aria-controls="ysGroupNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ys-group-nav-content" id="ysGroupNavbarCollapse">
                <ul class="navbar-nav ys-group-nav-menu">
                    <li class="nav-item ys-group-home-li">
                        <a class="nav-link" href="">
                            <i class="fas fa-home"></i>
                            <?php _e('Home', YS_GROUPS_TEXT_DOMAIN) ?>
                        </a>
                    </li>
                    <li class="nav-item ys-group-members-li">
                        <a class="nav-link" href="">
                            <i class="fas fa-users"></i>
                            <?php _e('Members', YS_GROUPS_TEXT_DOMAIN) ?>
                        </a>
                    </li>
                    <li class="nav-item ys-group-invite-li">
                        <a class="nav-link" href="">
                            <i class="fas fa-paper-plane"></i>
                            <?php _e('Invite member', YS_GROUPS_TEXT_DOMAIN) ?>
                        </a>
                    </li>
                    <?php if ($ysGroupVars['user']->ID == $ysGroupVars['groupAdminId']) : ?>
                        <li class="nav-item ys-group-manage-li">
                            <a class="nav-link" href="">
                                <i class="fas fa-cog"></i>
                                <?php _e('Group manage', YS_GROUPS_TEXT_DOMAIN) ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="ys-group-join">
                    <a class="btn btn-primary" href="">
                        <i class="fas fa-sign-in-alt"></i>
                        <?php _e('Join group', YS_GROUPS_TEXT_DOMAIN) ?>
                    </a>
                </div>
            </div>
        </nav>
        <main class="ys-group-main-content">
            <div id="group-feed"></div>
        </main>
    </div>
</div>

<?php get_footer() ?>
