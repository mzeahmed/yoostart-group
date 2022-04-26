<?php

namespace YsGroups\Controller\Api;

class YsGroupPostRestController
{
    public string $version;

    public string $namespace;

    public string $resourceName;

    public function __construct()
    {
        $this->version = '1';
        $this->namespace = '/ys-group/v' . $this->version;
        $this->resourceName = 'posts';

        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    /**
     * @return void
     * @since 1.2.0
     */
    public function registerRoutes(): void
    {
        register_rest_route(
            $this->namespace,
            $this->resourceName,
            [
                [
                    'method' => \WP_REST_Server::READABLE,
                    'callback' => [$this, 'getPosts'],
                    'permission_calback' => [$this, 'getPostsPermissionsCheck'],
                ],
                'schema' => [$this, 'getItemSchema'],
            ],
        );

        register_rest_field(
            'ys-group-post',
            YS_GROUP_ID_META_KEY,
            [
                'get_callback' => [$this, 'registerGroupIdMetaKeyField'],
                'update_calback' => null,
                'schema' => null,
            ]
        );
    }

    /**
     * Verifie les permissions des posts
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_Error|bool
     */
    public function getPostsPermissionsCheck(\WP_REST_Request $request): \WP_Error|bool
    {
        if (! current_user_can('read')) {
            return new \WP_Error(
                'rest_forbidden',
                esc_html__('You cannot view the post resource', YS_GROUP_TEXT_DOMAIN),
                ['status' => $this->authorizationStatusCode()]
            );
        }

        return true;
    }

    /**
     * @return int
     */
    public function authorizationStatusCode(): int
    {
        $status = 401;

        if (is_user_logged_in()) {
            $status = 403;
        }

        return $status;
    }

    /**
     * Url à appeler {wp-json/ys-group/v1/posts?_ys_group_id_meta_key=$group_id}
     *
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @throws \Exception
     * @since 1.2.0
     */
    public function getPosts(\WP_REST_Request $request): \WP_REST_Response
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
     * Récuperation de l'ID du groupe lié au post
     *
     * @param $post
     * @param $fieldName
     * @param $request
     *
     * @return array
     * @since 1.2.5
     */
    public function registerGroupIdMetaKeyField($post, $fieldName, $request): array
    {
        $postMeta = get_post_meta($post->ID, YS_GROUP_ID_META_KEY);
        $meta = [];

        foreach ($postMeta as $metaKey => $metaValue) {
            $meta[$metaKey] = $metaValue[0];
        }

        return $meta;
    }
}
