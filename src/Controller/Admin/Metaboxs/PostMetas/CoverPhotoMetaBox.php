<?php

namespace YsGroups\Controller\Admin\Metaboxs\PostMetas;

use Carbon_Fields\Field;
use Carbon_Fields\Container;

class CoverPhotoMetaBox
{
    public function __construct()
    {
        add_action('carbon_fields_register_fields', [$this, 'registerCoverPhotoMetaKey']);
    }

    public function registerCoverPhotoMetaKey()
    {
        Container::make('post_meta', __('Cover photo', YS_GROUPS_TEXT_DOMAIN))
            ->where('post_type', '=', 'ys-group')
            ->add_fields([
                Field::make(
                    'image',
                    YS_GROUP_COVER_PHOTO_META_KEY,
                    __('Choose an image of 1900px width ', YS_GROUPS_TEXT_DOMAIN)
                )
                    ->set_visible_in_rest_api(),
            ])
            ->set_context('side')
            ->set_priority('low')
        ;
    }
}
