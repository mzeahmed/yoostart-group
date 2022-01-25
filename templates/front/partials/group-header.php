<?php

/**
 * Header des groupes
 *
 * @since 1.1.4
 */

?>

<div class="ys-group-header w-100">
    <div class="ys-group-cover" style="background-image: url()">
        <div class="ys-group-avatar row">
            <div class="avatar-img col-auto align-self-center" id="group_img"></div>
            <div class="ys-group-details col align-self-center">
                <div class="ys-group-name"><?php echo ucfirst($ysGroupVars['groupName']) ?></div>
                <div class="ys-group-status"><?php echo ucfirst($ysGroupVars['groupStatus']) ?></div>
            </div>
        </div>

        <?php if ($ysGroupVars['user']->ID == $ysGroupVars['groupAdminId']) : ?>
            <div class="ys-group-action row">
                <div id="ys_group_actions">
                    <div class="editable ys-group-single-action edit-cover">
                        <img src="" alt="" class="icon icon-photo">
                        <?php _e('Edit group cover', WPDM_TEXT_DOMAIN); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <div class="ys-group-menu">

    </div>
</div>
