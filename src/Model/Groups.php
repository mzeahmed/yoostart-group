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
     * @param int    $perPage
     * @param        $paged
     *
     * @return object|array|null
     * @since 1.0.7
     */
    public function getGroups(string $orderby, int $perPage, $paged): object|array|null
    {
        $q = $this
            ->wpdb->prepare(
                "SELECT * FROM {$this->ys_groups_prefix}groups ORDER BY $orderby LIMIT %d OFFSET %d",
                $perPage,
                $paged
            );

        return $this->wpdb->get_results($q, 'ARRAY_A');
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
