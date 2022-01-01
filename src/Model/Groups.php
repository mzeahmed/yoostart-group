<?php

namespace YsGroups\Model;

/**
 * @since 1.0.6
 */
class Groups extends Db
{
    /**
     * Recupération de tout les groupes
     *
     * @param string $orderby
     * @param string $order
     *
     * @return object|array|null
     * @since 1.0.7
     */
    public function getGroups(string $orderby, string $order): object|array|null
    {
        $query = "SELECT * FROM {$this->ys_groups_prefix}groups ORDER BY $orderby $order";

        return $this->wpdb->get_results($query, 'ARRAY_A');
    }

    /**
     * Check si un slug exist deja
     *
     * @param string $slug
     *
     * @return bool
     * @since 1.0.8
     */
    public function slugExist(string $slug): bool
    {
        $query = $this->wpdb->prepare("SELECT slug from {$this->ys_groups_prefix}groups WHERE slug = %s", $slug);
        $result = $this->wpdb->get_results($query);

        return (bool)$result;
    }

    /**
     * Persistance du groupe en bdd
     *
     * @param int $author_id
     * @param string|null $cover_photo
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
        ?string $cover_photo,
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
                    'cover_photo' => $cover_photo,
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
        $q = "DELETE FROM {$this->ys_groups_prefix}groups WHERE id IN($group_ids)";

        return $this->wpdb->query($q);
    }
}
