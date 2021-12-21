<?php

namespace YsGroups\Model;

/**
 * @since 1.0.5
 */
class PluginPosts
{
    /**
     * Recuperes les ids des pages créés par le plugin
     *
     * @param array $posts Tableau des noms des pages
     *
     * @return array Tableau contenant les ids des pages
     * @since 1.0.5
     */
    public function getPostsId(array $posts): array
    {
        global $wpdb;
        $prefix = $wpdb->prefix;

        $result = [];

        foreach ($posts as $post) {
            $result[] = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT option_value FROM " . $prefix . "options WHERE option_name = %s",
                    'ys_groupes_' . $post . '_page_id'
                )
            );
        }

        return $result;
    }
}
