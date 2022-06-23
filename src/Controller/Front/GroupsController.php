<?php

namespace YsGroup\Controller\Front;

use WP_User;
use YsGroup\Model\Groups;
use YsGroup\Helpers\Helpers;
use YsGroup\Services\Mailer;
use YsGroup\Model\GroupsPosts;
use YsGroup\Model\GroupsMembers;
use YsGroup\Controller\AbstractController;

/**
 * @since 1.1.0
 */
class GroupsController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_filter('template_include', [$this, 'single'], 99);
        add_filter('template_include', [$this, 'archive']);
    }

    /**
     * @param $template
     *
     * @return string
     * @since 1.2.3
     */
    public function single($template): string
    {
        $postMeta = get_post_meta(get_the_ID(), YS_GROUP_STATUS_META_KEY);
        $coverImageId = carbon_get_post_meta(get_the_ID(), YS_GROUP_COVER_PHOTO_META_KEY);
        $coverImageUrl = wp_get_attachment_image_url($coverImageId);

        if (is_single() && get_post_type() == YS_GROUP_CPT) {
            $template = $this->template(
                'front/single',
                'ysGroupMeta',
                [
                    'postMeta' => $postMeta,
                    'coverImageUrl' => $coverImageUrl,
                ]
            );
        }

        return $template;
    }

    /**
     * @param $template
     *
     * @return string
     * @since 1.2.4
     */
    public function archive($template): string
    {
        if (is_post_type_archive(YS_GROUP_CPT)) {
            $template = $this->template(
                'front/archive',
                '',
                []
            );
        }

        return $template;
    }
}
