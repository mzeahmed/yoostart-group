<?php

namespace YsGroups\Services;

class FixSomeErrors
{
    public function __construct()
    {
        add_filter('request', [$this, 'fixCustomPostsPerPage']);
    }

    /**
     * Fix erreur 404 lors de la pagination des custom post types
     *
     * @param $query_string
     *
     * @return array|mixed
     */
    public function fixCustomPostsPerPage($query_string): mixed
    {
        if (is_admin() || ! is_array($query_string)) {
            return $query_string;
        }

        $post_types_to_fix = [
            [
                'post_type' => 'ys-group',
                'posts_per_page' => 6,
            ],

            /*
            array(
                'post_type' => 'other_post_type',
                'posts_per_page' => 2
            ),
            */
        ];

        foreach ($post_types_to_fix as $fix) {
            if (
                array_key_exists('post_type', $query_string)
                && $query_string['post_type'] == $fix['post_type']
            ) {
                $query_string['posts_per_page'] = $fix['posts_per_page'];

                return $query_string;
            }
        }

        return $query_string;
    }
}
