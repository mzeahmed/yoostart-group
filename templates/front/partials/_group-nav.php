<?php

/**
 * @since 1.1.6
 */

?>

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
                    <?php _e('Invite a member', YS_GROUPS_TEXT_DOMAIN) ?>
                </a>
            </li>
            <?php //if (wp_get_current_user()->ID == $ysGroupVars['groupAdminId']) : ?>
            <li class="nav-item ys-group-manage-li">
                <a class="nav-link" href="">
                    <i class="fas fa-cog"></i>
                    <?php _e('Group settings', YS_GROUPS_TEXT_DOMAIN) ?>
                </a>
            </li>
            <?php //endif; ?>
        </ul>

        <?php //if (! $ysGroupVars['isMember']) : ?>
        <div class="ys-join-group">
            <!--                <form action="--><?php //$ysGroupVars['action'] ?><!--" method="post" name="ys_join_group_form">-->
            <!--                    --><?php //wp_nonce_field($ysGroupVars['action'], '_ys_single_join_group_nonce') ?>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt"></i>
                <?php _e('Join the group', YS_GROUPS_TEXT_DOMAIN) ?>
            </button>
            <!--            </form>-->
        </div>
        <?php //endif; ?>
    </div>
</nav>
