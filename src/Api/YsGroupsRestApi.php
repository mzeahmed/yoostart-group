<?php

namespace YsGroups\Api;

use WP_REST_Server;
use WP_REST_Response;
use YsGroups\Model\FeedPost;

class YsGroupsRestApi
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'ysGroupsRestApiInit']);
    }

    /**
     * @since 1.2.0
     */
    public function ysGroupsRestApiInit()
    {
        register_rest_route(
            'ys-groups/v1',
            '/feed-posts',
            [
                'method' => WP_REST_Server::READABLE,
                'callback' => [$this, 'feedPosts'],
                'permission_calback' => '__return true',
            ]
        );
    }

    /**
     * @param $request
     *
     * @return WP_REST_Response
     * @since 1.2.0
     */
    public function feedPosts($request): WP_REST_Response
    {
        $response = (new FeedPost())->getFeedPosts();

        return rest_ensure_response($response);
    }
}
