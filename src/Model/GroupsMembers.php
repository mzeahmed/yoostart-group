<?php

namespace YsGroups\Model;

/**
 * @since 1.0.9
 */
class GroupsMembers extends Db
{
    /**
     * Recuperations des membres d'un groupe
     *
     * @param int    $groupId
     * @param string $orderby
     * @param string $order
     *
     * @return array|object|null
     * @since 1.0.9
     */
    public function getMembers(int $groupId, string $orderby, string $order = 'ASC'): object|array|null
    {
        $query = $this->wpdb->prepare(
            "SELECT * FROM {$this->ys_groups_prefix}groups_members ORDER BY $orderby WHERE group_id = %s $order",
            $groupId
        );

        return $this->wpdb->get_results($query);
    }

    /**
     * Persistance du membre en bdd
     *
     * @param int    $groupId
     * @param int    $userId
     * @param int    $inviterId
     * @param bool   $isAdmin
     * @param string $modifiedAt
     * @param bool   $isConfirmed
     * @param bool   $isBanned
     *
     * @return bool|int
     * @since 1.0.9
     */
    public function persistMember(
        int $groupId,
        int $userId,
        int $inviterId,
        bool $isAdmin,
        string $modifiedAt,
        bool $isConfirmed,
        bool $isBanned
    ): bool|int {
        return $this->wpdb->insert(
            $this->ys_groups_prefix . 'groups_members',
            [
                'group_id' => $groupId,
                'user_id' => $userId,
                'inviter_id' => $inviterId,
                'is_admin' => $isAdmin,
                'modified_at' => $modifiedAt,
                'is_confirmed' => $isConfirmed,
                'is_banned' => $isBanned
            ],
            ['%d', '%d', '%d', '%s', '%s', '%s', '%s']
        );
    }
}
