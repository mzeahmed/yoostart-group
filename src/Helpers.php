<?php

namespace YsGroups;

use YsGroups\Model\Groups;

/**
 * @since 1.1.0
 */
class Helpers
{
    /**
     * Récuperation du nom des groupes en fonction des ids passés en parametres
     *
     * @param array|string $gid
     *
     * @return array
     * @since 1.1.0
     */
    public static function getGroupsName(array|string $gid): array
    {
        $groupsName = (new Groups())->getGroupsName($gid);

        $name = [];
        foreach ($groupsName as $groupName) {
            $obj_vars = get_object_vars($groupName);

            foreach ($obj_vars as $var) {
                $name[] = $var;
            }
        }

        return $name;
    }
}
