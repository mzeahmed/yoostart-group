<?php

namespace YsGroups\Model;

/**
 * @since 1.2.0
 */
class FeedPost extends Db
{
    /**
     * Récuperation des posts
     *
     * @return array|object|null
     * @since 1.2.0
     */
    public function getFeedPosts(): array|object|null
    {
        $q = "SELECT * FROM {$this->prefix}ys_feed_posts";

        return $this->wpdb->get_results($q, 'OBJECT');
    }
}
