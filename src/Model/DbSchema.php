<?php

namespace YsGroups\Model;

class DbSchema
{
    /**
     * Creation des tables en base de données
     *
     * @return void
     * @since 1.0.4
     */
    public static function createTables()
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();

        $groups        = YS_GROUP_DB_PREFIX . 'groups';
        $groupsMembers = YS_GROUP_DB_PREFIX . 'groups_members';

        $query = [];

        // Table ys_group_groups
        $query[] = "CREATE TABLE {$groups} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        creator_id bigint(20) NOT NULL,
                        name varchar(100) NOT NULL,
                        slug varchar(200) NOT NULL,
                        description longtext NOT NULL,
                        status varchar(10) NOT NULL DEFAULT 'public',
                        created_at datetime NOT NULL,
                        KEY creator_id (creator_id),
                        Key status (status)
                    ) {$charsetCollate};";

        // Tbale ys_group_groups_members
        $query[] = "CREATE TABLE {$groupsMembers} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        group_id bigint(20) NOT NULL,
                        user_id bigint(20) NOT NULL,
                        inviter_id bigint(20) NOT NULL,
                        is_admin tinyint(1) NOT NULL DEFAULT '0',
                        modified_at datetime NOT NULL,
                        is_confirmed tinyint(1) NOT NULL DEFAULT '0',
				        is_banned tinyint(1) NOT NULL DEFAULT '0',
                        KEY group_id (group_id),
                        KEY is_admin (is_admin),
                        KEY user_id (user_id),
                        KEY inviter_id (inviter_id),
                        KEY is_confirmed (is_confirmed)
                    ) {$charsetCollate};";

        dbDelta($query);
    }
}
