<?php

namespace YsGroup\Model;

/**
 * @since 1.2.0
 */
class GroupsPosts extends Db
{
    /**
     * Récuperation des posts
     *
     * @param int $groupId
     * @param int $itemsPerPage
     * @param int $offset
     *
     * @return array|object|null
     * @since 1.2.0
     */
    public function getPostsByGroupId(int $groupId, int $itemsPerPage, int $offset = 0): array|object|null
    {
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->ys_groups_prefix}posts 
                    WHERE group_id = %d
                    ORDER BY created_at DESC 
                    LIMIT {$offset}, {$itemsPerPage}",
            $groupId
        );

        return $this->wpdb->get_results($query, 'ARRAY_A');
    }

    /**
     * Recuperation du nombre total de posts d'un groupe
     *
     * @param int $groupId
     *
     * @return string|null
     * @since 1.2.3
     */
    public function groupPostsTotalQuery(int $groupId): ?string
    {
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->ys_groups_prefix}posts WHERE group_id = %d",
            $groupId
        );

        $totalQuery = "SELECT COUNT(1) FROM (${query}) AS combinated_table";

        return $this->wpdb->get_var($totalQuery);
    }

    /**
     * Récuperation des publications
     *
     * @param int $limit
     *
     * @return array
     */
    public function getGroupPosts(int $limit = 1): array
    {
        return get_posts([
            'post_type' => 'ys-group-post',
            'numberposts' => $limit,
            'post_status' => 'publish',
        ]);
    }
}
