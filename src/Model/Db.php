<?php

namespace YsGroup\Model;

/**
 * @since 1.0.6
 */
class Db
{
    /**
     * Instance de wpdb
     *
     * @var \wpdb
     */
    protected \wpdb $wpdb;

    /**
     * Prefix de la base de données
     *
     * @var string
     */
    protected string $prefix;

    /**
     * Prefix des tables créés par le plugin
     *
     * @var string
     */
    protected string $ys_groups_prefix;

    public function __construct()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        global $wpdb;

        $this->wpdb = $wpdb;
        $this->prefix = $this->wpdb->prefix;
        $this->ys_groups_prefix = YS_GROUP_DB_PREFIX;
    }
}
