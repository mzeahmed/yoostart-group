<?php

namespace YsGroups\Model;

/**
 * @since 1.0.4
 */
class DbSchema extends Db
{
    private string $charsetCollate;

    private string $groups;

    private string $groupsMembers;

    private array $query;

    public function __construct()
    {
        parent::__construct();

        $this->charsetCollate = $this->wpdb->get_charset_collate();
        $this->groups = $this->ys_groups_prefix . 'groups';
        $this->groupsMembers = $this->ys_groups_prefix . 'members';
        $this->query = [];
    }

    /**
     * Creation des tables en base de données
     *
     * @return void
     * @since 1.0.4
     */
    public function createTables()
    {
        // Table ys_group_groups
        $this->query[] = "CREATE TABLE {$this->groups} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        creator_id bigint(20) NOT NULL,
                        name varchar(100) NOT NULL,
                        slug varchar(200) NOT NULL UNIQUE,
                        description longtext NOT NULL,
                        status varchar(10) NOT NULL DEFAULT 'public',
                        cover_photo varchar(250) NULL,
                        avatar varchar(250) NULL,
                        created_at datetime NOT NULL,
                        KEY creator_id (creator_id),
                        Key status (status)
                    ) {$this->charsetCollate};";

        // Table ys_group_groups_members
        $this->query[] = "CREATE TABLE {$this->groupsMembers} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        group_id bigint(20) NOT NULL,
                        user_id bigint(20) NOT NULL,
                        inviter_id bigint(20) NULL,
                        is_admin tinyint(1) NOT NULL DEFAULT '0',
                        modified_at datetime NOT NULL,
                        is_confirmed tinyint(1) NOT NULL DEFAULT '0',
				        is_banned tinyint(1) NOT NULL DEFAULT '0',
                        KEY group_id (group_id),
                        KEY is_admin (is_admin),
                        KEY user_id (user_id),
                        KEY inviter_id (inviter_id),
                        KEY is_confirmed (is_confirmed)
                    ) {$this->charsetCollate};";

        dbDelta($this->query);
    }

    /**
     * Modification de la table ys_feed_posts
     *
     * @return void
     * @since 1.2.0
     */
    public function alterTables()
    {
        $feedPosts = $this->wpdb->get_row("SELECT * FROM {$this->prefix}ys_feed_posts");

        if (! isset($feedPosts->group_id)) {
            $this->wpdb->query(
                "ALTER TABLE {$this->prefix}ys_feed_posts ADD group_id bigint(20) NULL AFTER `user_id`;"
            );
        }
    }
}
