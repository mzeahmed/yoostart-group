<?php

/**
 * @package YsGroups\Front
 * @since   1.1.0
 */

defined('ABSPATH') || die;

global $wp;

?>
<div id="ys_groups" data-request="<?php echo home_url($wp->request) ?>"></div>
<div class="ys-groups-list">
    <?php foreach ($paginatedGroups as $group) : ?>
        <div class="ys-groups">
            <div class="ys-group-content">
                <?php if ($group['cover_photo'] != null) : ?>
                    <img
                        src="..."
                        loading="lazy"
                        class="cover-img ys-group-cover"
                        alt="<?php echo sprintf(__("%s cover's photo"), ucfirst($group['name'])) ?>"
                    >
                <?php else : ?>
                    <img
                        src="<?php echo YS_GROUPS_URI . '/public/img/default-group-cover.png' ?>"
                        loading="lazy"
                        class="cover-img ys-group-cover"
                        alt="<?php echo sprintf(__("%s's cover"), ucfirst($group['name'])) ?>"
                    >
                <?php endif; ?>
                <div class="ys-group-info">
                    <?php if ($group['avatar'] != null) : ?>
                        <a href="<?php echo home_url('groupes/' . $group['slug']) ?>">
                            <img
                                src=""
                                class="ys-group-cover-content"
                                alt="<?php echo sprintf(__("%s's avatar"), ucfirst($group['name'])) ?>"
                            >
                        </a>
                    <?php else : ?>
                        <a href="<?php echo home_url('groupes/' . $group['slug']) ?>">
                            <img
                                src="<?php echo YS_GROUPS_URI . '/public/img/default-group-avatar.png' ?>"
                                class="ys-group-cover-content"
                                alt="<?php echo sprintf(__("%s's avatar"), ucfirst($group['name'])) ?>"
                            >
                        </a>
                    <?php endif; ?>

                    <div class="ys-group-name">
                        <a href="<?php echo home_url('groupes/' . $group['slug']) ?>"><?php echo $group['name'] ?></a>
                    </div>

                    <div class="ys-group-status">
                        <?php if ($group['status'] === 'public') : ?>
                            <i class="fas fa-globe-africa"></i> <?php _e('Public group', YS_GROUPS_TEXT_DOMAIN) ?>
                        <?php else : ?>
                            <?php _e('Private group', YS_GROUPS_TEXT_DOMAIN) ?>
                        <?php endif; ?>
                    </div>

                    <div class="ys-group-statistics">
                        <div
                            class="ys-group-data-item ys-group-data-last-activity"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="<?php printf(__('Last activity on %s', YS_GROUPS_TEXT_DOMAIN), '10/10/21') ?>"
                        >
                            <span class="dashicons dashicons-clock"></span>
                        </div>
                        <div
                            class="ys-group-data-item ys-group-data-members"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="<?php printf(
                                __('%s members', YS_GROUPS_TEXT_DOMAIN),
                                count(\YsGroups\Helpers\Helpers::getMembers($group['id']))
                            ) ?>"
                        >
                            <span class="dashicons dashicons-groups"></span>
                        </div>
                    </div>
                </div>

                <hr>

                <!--                <div class="ys-join-group">-->
                <!--                    <a href="#" class="btn btn-primary">-->
                <!--                        <i class="fas fa-sign-in-alt"></i>-->
                <!--                        --><?php //_e('Join group', YS_GROUPS_TEXT_DOMAIN); ?>
                <!--                    </a>-->
                <!--                </div>-->

                <?php //if (! $ysGroupVars['isMember']) :  ?>
                <!--                <div class="ys-join-group">-->
                <!--                    <form action="" method="post" name="ys_join_group_form">-->
                <!--                        --><?php //wp_nonce_field(home_url('/groupes/'), '_ys_directory_join_group_nonce') ?>
                <!--                        <button type="submit" class="btn btn-primary">-->
                <!--                            <i class="fas fa-sign-in-alt"></i>-->
                <!--                            --><?php //_e('Join group', YS_GROUPS_TEXT_DOMAIN) ?>
                <!--                        </button>-->
                <!--                    </form>-->
                <!--                </div>-->
                <?php //endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Pagination -->
    <?php if (! empty($groupsTotal)) : ?>
        <div class="ys-groups-pagination">
            <?php echo $paginateLinks; ?>
        </div>
    <?php else : ?>
        <?php _e('No group found', YS_GROUPS_TEXT_DOMAIN) ?>
    <?php endif; ?>
</div>