<?php

namespace YsGroups\Controller\Admin\Metaboxs;

use Carbon_Fields\Field;
use Carbon_Fields\Container;
use YsGroups\Controller\AbstractController;

class CoverPhotoMetaBox extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_action('carbon_fields_register_fields', [$this, 'registerCoverPhotoMetaKey']);
    }

    public function registerCoverPhotoMetaKey()
    {
        Container::make('post_meta', __('Cover photo', YS_GROUPS_TEXT_DOMAIN))
            ->where('post_type', '=', 'ys-group')
            ->add_fields([
                Field::make('image', YS_GROUP_COVER_PHOTO_META_KEY, __('Cover photo', YS_GROUPS_TEXT_DOMAIN))
                    ->set_visible_in_rest_api(),
            ])
        ;
    }
}
