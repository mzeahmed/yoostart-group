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
    public function getGroups(string $orderby = 'created_at', string $order = 'DESC'): object|array|null
    {
        $query = "SELECT * FROM {$this->ys_groups_prefix}groups ORDER BY $orderby $order";

        return $this->wpdb->get_results($query, 'ARRAY_A');
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
     * @param int         $author_id
     * @param string|null $cover_photo
     * @param string      $name
     * @param string      $slug
     * @param string      $description
     * @param string      $status
     * @param string      $created_at
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
        $query = "DELETE FROM {$this->ys_groups_prefix}groups WHERE id IN($group_ids)";

        return $this->wpdb->query($query);
    }
}
