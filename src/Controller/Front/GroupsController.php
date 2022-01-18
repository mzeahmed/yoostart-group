<?php

namespace YsGroups\Controller\Front;

use YsGroups\Model\Groups;
use YsGroups\Controller\AbstractController;

/**
 * @since 1.1.0
 */
class GroupsController extends AbstractController
{
    public function __construct()
    {
        add_shortcode('ys_groups', [$this, 'groups']);
    }

    /**
     * Affichage de la page du repertoire des groupes
     *
     * @return string|null
     * @since 1.1.0
     */
    public function groups(): ?string
    {
        $groups = (new Groups())->getGroups();

        return $this->render('front/groups', [
            'groups' => $groups,
        ]);
    }
}
