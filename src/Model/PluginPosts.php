<?php

namespace YsGroups\Model;

/**
 * @since 1.0.5
 */
class PluginPosts extends Db
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
        $result = [];

        foreach ($posts as $post) {
            $result[] = $this->wpdb->get_var(
                $this->wpdb->prepare(
                    "SELECT option_value FROM " . $this->prefix . "options WHERE option_name = %s",
                    'ys_groups_' . $post . '_page_id'
                )
            );
        }

        return $result;
    }
}
