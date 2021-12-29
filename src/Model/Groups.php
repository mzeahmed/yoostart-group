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
        $q = "SELECT * FROM {$this->ys_groups_prefix}groups ORDER BY $orderby $order";

        return $this->wpdb->get_results($q, 'ARRAY_A');
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
        $q = $this->wpdb->prepare("SELECT slug from {$this->ys_groups_prefix}groups WHERE slug = %s", $slug);
        $result = $this->wpdb->get_results($q);

        return (bool)$result;
    }

    /**
     * Persistance des données en bdd
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
    public function persist(
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
                ['%d', '%s', '%s', '%s', '%s', '%s']
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
    public function delete($group_ids): bool|int
    {
        $q = "DELETE FROM {$this->ys_groups_prefix}groups WHERE id IN($group_ids)";

        return $this->wpdb->query($q);
    }
}
