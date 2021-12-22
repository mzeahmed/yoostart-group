<?php

namespace YsGroups\Model;

/**
 * @since 1.0.6
 */
class Db
{
    protected \wpdb $wpdb;

    /**
     * Prefix de la base de données
     *
     * @var string
     */
    protected string $prefix;

    public function __construct()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        global $wpdb;

        $this->wpdb   = $wpdb;
        $this->prefix = $this->wpdb->prefix;
    }
}
