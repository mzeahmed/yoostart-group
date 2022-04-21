<?php

namespace YsGroups\Api;

use YsGroups\Model\GroupsPosts;

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
            '/posts',
            [
                'method' => \WP_REST_Server::READABLE,
                'callback' => [$this, 'groupPosts'],
                'permission_calback' => '__return true',
            ]
        );
    }

    /**
     * @param \WP_REST_Request $request
     *
     * @return \WP_REST_Response
     * @since 1.2.0
     */
    public function groupPosts(\WP_REST_Request $request): \WP_REST_Response
    {
        $itemsPerPage = 9;
        $paged = (get_query_var('paged') ? get_query_var('paged') : 1);
        $offset = ($paged * $itemsPerPage) - $itemsPerPage;

        $response = (new GroupsPosts())->getPostsByGroupId(1, $itemsPerPage, $offset);

        $postsTotal = (new GroupsPosts())->groupPostsTotalQuery(1);
        $currentPage = max(1, get_query_var('paged'));
        $totalPages = ceil($postsTotal / $itemsPerPage);

        if (empty($response)) {
            return new \WP_REST_Response([
                'Message' => __('No post found', YS_GROUPS_TEXT_DOMAIN),
            ], 400);
        }

        return rest_ensure_response($response);
    }
}
