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
     * @param int $perPage
     * @param int $pageNumber
     *
     * @return array
     * @since 1.0.7.1
     */
    public function getGroups(int $perPage = 5, int $pageNumber = 1): array
    {
        $q = "SELECT * FROM {$this->prefix}groups";

        if (! empty($_REQUEST['orderby'])) {
            $q .= 'ORDER BY' . esc_sql($_REQUEST['orderby']);
            $q .= ! empty($_REQUEST['order']) ? '' . esc_sql($_REQUEST['order']) : 'ASC';
        }

        $q .= " LIMIT $perPage";
        $q .= ' offset ' . ($pageNumber - 1) * $perPage;

        return $this->wpdb->get_results($q, 'ARRAY_A');
    }
}