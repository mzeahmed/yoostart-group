<?php

namespace YsGroup\Controller\Front;

use YsGroup\Helpers\Helpers;

class GroupPostsCrudController
{
    /**
     * Url à appeler :
     * {wp-json/ys-group/v1/posts?_ys_group_id_meta_key=$group_id&_ys_group_post_count_meta_key=$post_count}
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @throws \Exception
     * @since 1.2.0
     */
    public static function getPosts(\WP_REST_Request $request): \WP_REST_Response
    {
        $groupId = json_decode($request->get_param('_ys_group_id_meta_key'));

        $posts = new \WP_Query([
            'posts_per_page' => -1,
            'post_type' => YS_GROUP_POST_CPT,
            'orderby' => 'date',
            'order' => 'desc',
            'post_status' => 'publish',
            'meta_query' => Helpers::queryArgument($groupId, '_ys_group_id_meta_key'),
        ]);

        $data = [];
        $i = 0;

        foreach ($posts->posts as $post) {
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
            $data[$i]['slug'] = $post->post_name;
            $data[$i]['author'] = get_ys_user_details($post->post_author);
            $data[$i]['content'] = wp_strip_all_tags($post->post_content);
            $data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
            $data[$i]['featured_image']['medium'] = get_the_post_thumbnail_url($post->ID, 'medium');
            $data[$i]['featured_image']['large'] = get_the_post_thumbnail_url($post->ID, 'large');
            // $data[$i]['date'] = date_format(new \DateTime($post->post_date), 'Y/m/d H:i:s');
            $data[$i]['date'] = $post->post_date;
            $data[$i]['group_id'] = intval($post->_ys_group_id_meta_key);
            $i++;
        }

        if (empty($data)) {
            return new \WP_REST_Response([
                'Message' => __('No post found', YS_GROUP_TEXT_DOMAIN),
            ], 404);
        }

        return rest_ensure_response($data);
    }

    /**
     * Création de la publication de groupe
     * Url à appeler {wp-json/ys-group/v1/posts/create}
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     */
    public static function createPost(\WP_REST_Request $request): \WP_REST_Response
    {
        $post['post_title'] = substr($request->get_param('post_content'), 0, 5);
        $post['post_content'] = sanitize_text_field($request->get_param('post_content'));
        $post['post_author'] = $request->get_param('post_author');
        $post['post_status'] = 'publish';
        $post['post_type'] = YS_GROUP_POST_CPT;

        /** @var $newPostId | Persistance du post en bdd */
        $newPostId = wp_insert_post($post);

        $response['status'] = 200;
        if (! is_wp_error($newPostId)) {
            $response['success'] = true;
            $response['data'] = get_post($newPostId);

            $groupId = $request->get_param('group_id');
            // $count = self::postCount($groupId);

            $obj = new \WP_Query([
                'post_type' => YS_GROUP_POST_CPT,
                'meta_query' => Helpers::queryArgument($groupId, YS_GROUP_ID_META_KEY)
            ]);

            $count = $obj->post_count;

            /** On lie le post au group en question */
            update_post_meta($response['data']->ID, YS_GROUP_ID_META_KEY, $groupId);
        } else {
            $response['success'] = false;
            $response['message'] = __('No post found!', YS_GROUP_TEXT_DOMAIN);
        }

        return new \WP_REST_Response($response);
    }
}
