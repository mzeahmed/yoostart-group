<?php

namespace YsGroups\Model;

/**
 * @since 1.0.6
 */
class Groups extends Db
{
    /**
     * Recupération de tout les groupes sous forme de tableau
     *
     * @param string $orderby
     * @param string $order
     *
     * @return array
     * @since 1.0.7
     */
    // public function getGroups(string $orderby = 'created_at', string $order = 'DESC'): array
    // {
    //     $query = "SELECT * FROM {$this->ys_groups_prefix}groups ORDER BY {$orderby} {$order}";
    //
    //     return $this->wpdb->get_results($query, 'ARRAY_A');
    // }

    /**
     * Récuperation des publications
     *
     * @param int $limit
     *
     * @return array
     */
    public function getGroups(int $limit = -1): array
    {
        return get_posts([
            'post_type' => 'ys-group',
            'numberposts' => $limit,
            'post_status' => 'publish',
        ]);
    }

    /**
     * Pagination des groupes
     *
     * @param int $itemsPerPage Nombre de groups par page
     * @param int $offset
     *
     * @return array
     * @since 1.1.2
     */
    public function getPaginatedGroups(int $itemsPerPage, int $offset = 0): array
    {
        $query = "SELECT * FROM {$this->ys_groups_prefix}groups 
                    ORDER BY created_at DESC 
                    LIMIT {$offset}, {$itemsPerPage}";

        return $this->wpdb->get_results($query, 'ARRAY_A');
    }

    /**
     * Recuperation du nombre total des groupes
     *
     * @return string|null
     * @since 1.1.2
     */
    public function groupsTotalQuery(): ?string
    {
        $query = "SELECT * FROM {$this->ys_groups_prefix}groups";
        $totalQuery = "SELECT COUNT(1) FROM (${query}) AS combinated_table";

        return $this->wpdb->get_var($totalQuery);
    }

    /**
     * Récuperation du nom des groupes en fonction des ids passés en parametres
     *
     * @param array|string $group_ids
     *
     * @return array|object|null
     * @since 1.0.9
     */
    public function getGroupsName(array|string $group_ids): object|array|null
    {
        $query = $this->wpdb->prepare("SELECT name FROM {$this->ys_groups_prefix}groups WHERE id IN(%d)", $group_ids);

        return $this->wpdb->get_results($query);
    }

    /**
     * Recupere l'ID d'un group en fonction de son slug
     *
     * @param string $slug
     *
     * @return string|null
     * @since 1.1.5
     */
    public function getGroupIdBySlug(string $slug): ?string
    {
        $query = $this->wpdb->prepare(
            "SELECT id FROM {$this->ys_groups_prefix}groups WHERE slug = %s",
            $slug
        );

        return $this->wpdb->get_var($query);
    }

    /**
     * Recupere les donnéesd'un group en fonction de son slug
     *
     * @param string $slug
     *
     * @return array
     * @since 1.1.5
     */
    public function getGroupDatasBySlug(string $slug): array
    {
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->ys_groups_prefix}groups WHERE slug = %s",
            $slug
        );

        return $this->wpdb->get_results($query, ARRAY_A);
    }

    /**
     * Recuperation de l'ID du dernier groupe créer
     *
     * @return string|null
     * @since 1.0.9
     */
    public function getLastId(): ?string
    {
        $query = "SELECT id FROM {$this->ys_groups_prefix}groups ORDER BY created_at DESC LIMIT 1";

        return $this->wpdb->get_var($query);
    }

    /**
     * Check si un slug exist deja
     *
     * @param string $slug
     *
     * @return string|null
     * @since 1.0.8
     */
    public function slugExist(string $slug): ?string
    {
        $query = $this->wpdb->prepare("SELECT slug from {$this->ys_groups_prefix}groups WHERE slug = %s", $slug);

        return $this->wpdb->get_var($query);
    }

    /**
     * Persistance du groupe en bdd
     *
     * @param int $author_id
     * @param string $name
     * @param string $slug
     * @param string $description
     * @param string $status
     * @param string $created_at
     *
     * @return bool|int
     * @since 1.0.8
     */
    public function persistGroup(
        int $author_id,
        string $name,
        string $slug,
        string $description,
        string $status,
        string $created_at
    ): bool|int {
        return $this
            ->wpdb->insert(
                $this->ys_groups_prefix . 'groups',
                [
                    'creator_id' => $author_id,
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'status' => $status,
                    'created_at' => $created_at,
                ],
                ['%d', '%s', '%s', '%s', '%s', '%s', '%s']
            );
    }

    /**
     * Suppression d'un group
     *
     * @param $group_ids
     *
     * @return bool|int
     * @since 1.0.8
     */
    public function deleteGroup($group_ids): bool|int
    {
        $query = "DELETE FROM {$this->ys_groups_prefix}groups WHERE id IN($group_ids)";

        return $this->wpdb->query($query);
    }
}
