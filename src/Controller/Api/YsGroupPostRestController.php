<?php

namespace YsGroup\Controller\Api;

use YsGroup\Controller\Front\GroupPostsCrudController;

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
        // GET
        register_rest_route(
            $this->namespace,
            $this->resourceName,
            [
                'methods' => \WP_REST_Server::READABLE,
                'callback' => [GroupPostsCrudController::class, 'getPosts'],
                'permission_calback' => [$this, 'getPostsPermissionsCheck'],
            ],
        );

        // POST
        register_rest_route(
            $this->namespace,
            $this->resourceName . '/create',
            [
                'methods' => \WP_REST_Server::CREATABLE,
                'callback' => [GroupPostsCrudController::class, 'createPost']
            ]
        );

        /** Id du du group lié */
        register_rest_field(
            YS_GROUP_POST_CPT,
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
     * Récuperation de l'ID du groupe lié au post
     *
     * @param $obj
     *
     * @return mixed
     * @since 1.2.5
     */
    public function registerGroupIdMetaKeyField($obj): mixed
    {
        return get_post_meta($obj->ID, YS_GROUP_ID_META_KEY, true);
    }
}
