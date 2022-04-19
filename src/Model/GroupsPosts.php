<?php

namespace YsGroups\Model;

/**
 * @since 1.2.0
 */
class GroupsPosts extends Db
{
    /**
     * Récuperation des posts
     *
     * @return array|object|null
     * @since 1.2.0
     */
    public function getPosts(): array|object|null
    {
        $query = "SELECT * FROM {$this->ys_groups_prefix}posts ORDER BY created_at DESC";

        return $this->wpdb->get_results($query, 'ARRAY_A');
    }
}
