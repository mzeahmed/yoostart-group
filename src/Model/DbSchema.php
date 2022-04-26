<?php

namespace YsGroup\Model;

/**
 * @since 1.0.4
 */
class DbSchema extends Db
{
    /**
     * @var string
     */
    private string $charsetCollate;

    /**
     * @var string
     */
    private string $groups;

    /**
     * @var string
     */
    private string $groupsMembers;

    /**
     * @var string
     * @since 1.2.0
     */
    private string $groupsPosts;

    /**
     * @var string
     * @since 1.2.0
     */
    private string $groupsPostsComments;

    /**
     * @var array
     */
    private array $query;

    public function __construct()
    {
        parent::__construct();

        $this->charsetCollate = $this->wpdb->get_charset_collate();
        $this->groups = $this->ys_groups_prefix . 'groups';
        $this->groupsMembers = $this->ys_groups_prefix . 'members';
        $this->groupsPosts = $this->ys_groups_prefix . 'posts';
        $this->groupsPostsComments = $this->ys_groups_prefix . 'posts_comments';
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

        // Table ys_group_posts
        $this->query[] = "CREATE TABLE {$this->groupsPosts} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        group_id bigint(20) NOT NULL,
                        author_id bigint(20) NOT NULL,
                        content longtext NOT NULL,
                        attached_media varchar(250) NULL,
                        status varchar(250) NOT NULL DEFAULT 'public',
                        created_at datetime NOT NULL
                    ) {$this->charsetCollate};";

        // Table ys_group_posts_comments
        $this->query[] = "CREATE TABLE {$this->groupsPostsComments} (
                        id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        author_id bigint(20) NOT NULL,
                        post_id bigint(20) NOT NULL,
                        content longtext NOT NULL,
                        created_at datetime NOT NULL
                    ) {$this->charsetCollate};";

        dbDelta($this->query);
    }
}
