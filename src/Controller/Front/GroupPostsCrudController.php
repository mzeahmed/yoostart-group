<?php

namespace YsGroup\Controller\Front;

class GroupPostsCrudController
{
    /**
     * Url à appeler {wp-json/ys-group/v1/posts?_ys_group_id_meta_key=$group_id}
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @throws \Exception
     * @since 1.2.0
     */
    public static function getPosts(\WP_REST_Request $request): \WP_REST_Response
    {
        $groupdId = json_decode($request->get_param('_ys_group_id_meta_key'));

        /**
         * @param $param
         * @param $key
         *
         * @return array[]|null
         * @since 1.2.5
         */
        function queryArgument($param, $key): ?array
        {
            if ($param) {
                return [
                    [
                        'key' => $key,
                        'value' => $param,
                        'type' => 'NUMERIC',
                        'compare' => '=',
                    ],
                ];
            }

            return null;
        }

        $posts = new \WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'ys-group-post',
            'orderby' => 'date',
            'order' => 'desc',
            'post_status' => 'publish',
            'meta_query' => queryArgument($groupdId, '_ys_group_id_meta_key'),
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
     * Url à appeler {wp-json/ys-group/v1/posts/create}
     *
     * @param \WP_REST_Request $request
     * @return \WP_REST_Response
     */
    public static function createPost(\WP_REST_Request $request): \WP_REST_Response
    {
        $post['post_title'] = substr($request->get_param('content'), 0, 5);
        $post['post_content'] = sanitize_text_field($request->get_param('content'));
        $post['post_status'] = 'publish';
        $post['post_type'] = 'ys-group-post';

        $newPostId = wp_insert_post($post);

        $response['status'] = 200;
        if (!is_wp_error($newPostId)) {
            $response['success'] = true;
            $response['data'] = get_post($newPostId);
        } else {
            $response['success'] = false;
            $response['message'] = __('No post found!', YS_GROUP_TEXT_DOMAIN);
        }

        return new \WP_REST_Response($response);
    }
}
