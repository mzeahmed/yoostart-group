<?php

namespace YsGroups\Admin;

use YsGroups\Model\PluginPosts;

class AdminColumn
{
    public function __construct()
    {
        add_filter('display_post_states', [$this, 'displayPostStates'], 10, 2);
    }

    /**
     * Affiche le nom du plugin à coté des pages créés par le plugin
     *
     * @param array    $posts_states
     * @param \WP_Post $post
     *
     * @return array
     * @since 1.0.5
     */
    public function displayPostStates(array $posts_states, \WP_Post $post): array
    {
        $postIds = (new PluginPosts())->getPostsId(YS_GROUPS_POSTS);

        foreach ($postIds as $id) {
            if ($id == $post->ID) {
                $posts_states[] = 'Yoostart Groups';
            }
        }

        return $posts_states;
    }
}
