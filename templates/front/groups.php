<?php

/**
 * @package YsGroups\Front
 * @since   1.1.0
 */

?>

<div class="user-list ys-groups-list">
    <?php foreach ($paginatedGroups as $group) : ?>
        <div class="user ys-groups">
            <div class="user-content ys-groups-data">
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
                        alt="<?php echo sprintf(__("%s's cover photo"), ucfirst($group['name'])) ?>"
                    >
                <?php endif; ?>
                <div class="user-info-core ys-groups-info">
                    <div class="nom-prenom ys-groups-name"><?php echo $group['name'] ?></div>
                </div>
                <div class="user-see-profile ys-groups-join">
                    <a href="#" class="btn btn-primary"><?php _e('Join group', YS_GROUPS_TEXT_DOMAIN); ?></a>
                </div>
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