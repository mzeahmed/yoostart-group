<?php

/**
 * @since 1.2.3
 */

defined('ABSPATH') || die;

require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php';

$theQuery = new \WP_Query([
    'posts_per_page' => 6,
    'orderby' => 'date',
    'post_type' => 'ys-group',
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
]) ?>

<?php if ($theQuery->have_posts()) : ?>
    <div class="container">
        <div class="ys-groups-list">
            <?php while ($theQuery->have_posts()) :
                $theQuery->the_post();

                $groupStatus = get_post_meta(get_the_ID(), YS_GROUP_STATUS_META_KEY);
                $coverImageId = intval(carbon_get_post_meta(get_the_ID(), YS_GROUP_COVER_PHOTO_META_KEY));
                $coverImageUrl = wp_get_attachment_image_url($coverImageId);
                $groupMembersCount = \YsGroups\Helpers\Helpers::getGroupMembersCount(get_the_ID())
                ?>
                <div class="ys-groups">
                    <div class="ys-group-content">
                        <?php if ($coverImageId != null) : ?>
                            <img
                                src="<?php echo $coverImageUrl ?>"
                                loading="lazy"
                                class="cover-img ys-group-cover"
                                alt="<?php printf(__("%s group cover's photo"), ucfirst(the_title())) ?>"
                            >
                        <?php else : ?>
                            <img
                                src="<?php echo YS_GROUP_URI . '/public/img/default-group-cover.png' ?>"
                                loading="lazy"
                                class="cover-img ys-group-cover"
                                alt="<?php printf(__("%s group cover's photo"), ucfirst('')) ?>"
                            >
                        <?php endif; ?>

                        <div class="ys-group-info">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink() ?>">
                                    <?php the_post_thumbnail() ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img
                                        src="<?php echo YS_GROUP_URI . '/public/img/default-group-avatar.png' ?>"
                                        class="ys-group-cover-content"
                                        alt="<?php printf(__("%s's avatar"), ucfirst(the_title())) ?>"
                                    >
                                </a>
                            <?php endif; ?>

                            <div class="ys-group-name">
                                <a href="<?php the_permalink(); ?>"><?= the_title() ?></a>
                            </div>

                            <div class="ys-group-status">
                                <?php if ($groupStatus === 'public') : ?>
                                    <i class="fas fa-globe-africa"></i>
                                    <?php _e('Public group', YS_GROUP_TEXT_DOMAIN) ?>
                                <?php else : ?>
                                    <?php _e('Private group', YS_GROUP_TEXT_DOMAIN) ?>
                                <?php endif; ?>
                            </div>

                            <div class="ys-group-statistics">
                                <div
                                    class="ys-group-data-item ys-group-data-last-activity"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="
                                    <?php printf(
                                        __('Last activity on %s', YS_GROUP_TEXT_DOMAIN),
                                        '10/10/21'
                                    ) ?>
                                        "
                                >
                                    <span class="dashicons dashicons-clock"></span>
                                </div>
                                <div
                                    class="ys-group-data-item ys-group-data-members"
                                    data-toggle="tooltip"
                                    data-placement="bottom"
                                    title="
                                    <?php if ($groupMembersCount <= 1) :
                                        printf(
                                            __('%s member', YS_GROUP_TEXT_DOMAIN),
                                            $groupMembersCount
                                        );
                                    else :
                                        printf(
                                            __('%s members', YS_GROUP_TEXT_DOMAIN),
                                            $groupMembersCount
                                        );
                                    endif; ?>
                                    "
                                >
                                    <span class="dashicons dashicons-groups"></span>
                                </div>
                            </div>
                        </div>

                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endwhile;

            $big = 999999999;

            echo paginate_links([
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%/',
                'current' => max(1, get_query_var('paged')),
                'total' => $theQuery->max_num_pages,
                'prev_text' => __('&laquo; Prev', YS_GROUP_TEXT_DOMAIN),
                'next_text' => __('Next &raquo;', YS_GROUP_TEXT_DOMAIN),
                'type' => 'list',
            ]); ?>
        </div>
    </div>
<?php else : ?>
    <?php _e('No group found', YS_GROUP_TEXT_DOMAIN) ?>
<?php endif; ?>

<?php wp_reset_postdata();
get_footer(); ?>