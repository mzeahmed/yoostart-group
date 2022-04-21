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
     * @param int $groupId
     *
     * @return array|object|null
     * @since 1.0.9
     */
    public function getMembers(int $groupId): object|array|null
    {
        $query = $this->wpdb->prepare(
            "SELECT user_id FROM {$this->ys_groups_prefix}members WHERE group_id = %d ORDER BY modified_at DESC",
            $groupId
        );

        return $this->wpdb->get_results($query);
    }

    /**
     * Persistance du membre en bdd
     *
     * @param int $groupId
     * @param int $userId
     * @param int|null $inviterId
     * @param bool $isAdmin
     * @param string $modifiedAt
     * @param bool $isConfirmed
     * @param bool $isBanned
     *
     * @return bool|int
     * @since 1.0.9
     */
    public function persistMember(
        int $groupId,
        int $userId,
        ?int $inviterId,
        bool $isAdmin,
        string $modifiedAt,
        bool $isConfirmed,
        bool $isBanned
    ): bool|int {
        return $this->wpdb->insert(
            $this->ys_groups_prefix . 'members',
            [
                'group_id' => $groupId,
                'user_id' => $userId,
                'inviter_id' => $inviterId,
                'is_admin' => $isAdmin,
                'modified_at' => $modifiedAt,
                'is_confirmed' => $isConfirmed,
                'is_banned' => $isBanned,
            ],
            ['%d', '%d', '%d', '%s', '%s', '%s', '%s']
        );
    }

    /**
     * Confirmation de la demande d'adhesion à un groupe
     *
     * @param int $groupId
     * @param int $userId
     *
     * @return bool|int
     */
    public function confirmMemberGroupJoin(int $groupId, int $userId): bool|int
    {
        return $this->wpdb->update(
            $this->ys_groups_prefix . 'members',
            [
                'modified_at' => wp_date('Y-m-d H:i:s'),
                'is_confirmed' => true,
            ],
            [
                'group_id' => $groupId,
                'user_id' => $userId,
            ],
            ['%d', '%d']
        );
    }

    /**
     * Recupere l'ID de l'administrateur du groupe
     *
     * @param int $groupId Id du group
     *
     * @return string|null
     * @since 1.1.5
     */
    public function getGroupAdminId(int $groupId): ?string
    {
        $query = $this->wpdb->prepare(
            "SELECT user_id FROM {$this->ys_groups_prefix}members WHERE is_admin = 1 AND group_id=%d",
            $groupId
        );

        return $this->wpdb->get_var($query);
    }

    /**
     * Teste si l'utilisateur est membre ou ps
     *
     * @param int $groupId
     * @param int $userId
     *
     * @return bool
     * @since 1.1.7
     */
    public function isGroupMember(int $groupId, int $userId): bool
    {
        $query = $this->wpdb->prepare(
            "SELECT user_id FROM {$this->ys_groups_prefix}members WHERE group_id = %d AND user_id = %d",
            $groupId,
            $userId
        );

        $result = $this->wpdb->get_var($query);

        if ($result == $userId) {
            return true;
        }

        return false;
    }
}
