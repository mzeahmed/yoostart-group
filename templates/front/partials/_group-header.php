<?php

/**
 * Header des groupes
 *
 * @since 1.1.4
 */

?>

<div class="ys-group-header w-100">
    <div class="ys-group-cover" style="background-image: url()">
        <div class="ys-group-cover-content">
            <div class="ys-group-cover-inner-content d-flex">
                <div class="ys-group-img" style="background-image: url()">
                    <div class="editable edit-img" title="<?php _e('Edit group avatar', YS_GROUPS_TEXT_DOMAIN); ?>">
                        <div class="editable-content">
                            <img
                                src="<?php echo YS_GROUPS_URI . '/public/img/camera.png' ?>"
                                alt=""
                                class="icon icon-photo"
                            >
                        </div>
                    </div>
                </div>
                <div class="ys-group-details col align-self-center">
                    <div class="ys-group-name"><?php echo ucfirst($ysGroupVars['groupName']) ?></div>
                    <?php if ($ysGroupVars['groupStatus'] === 'public') : ?>
                        <div class="ys-group-status"><?php _e('Public group', YS_GROUPS_TEXT_DOMAIN); ?></div>
                    <?php else : ?>
                        <div class="ys-group-status"><?php _e('Private group', YS_GROUPS_TEXT_DOMAIN); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if ($ysGroupVars['user']->ID == $ysGroupVars['groupAdminId']) : ?>
            <div class="ys-group-action">
                <div class="editable ys-group-single-action edit-cover" data-action="ys_group_get_cover_form"
                     data-toggle="tooltip" data-placement="top"
                     title="<?php _e('Edit group cover photo', YS_GROUPS_TEXT_DOMAIN) ?>">
                    <div class="editable-content">
                        <img
                            src="<?php echo YS_GROUPS_URI . '/public/img/camera.png' ?>"
                            alt=""
                            class="icon icon-photo"
                        >
                        <button type="button" data-toggle="modal" data-target="#ysCoverFormModal">
                            <?php _e('Edit group cover', YS_GROUPS_TEXT_DOMAIN); ?>
                        </button>
                    </div>
                    <?php include YS_GROUPS_PATH . 'templates/front/partials/_cover-form-modal.php' ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
