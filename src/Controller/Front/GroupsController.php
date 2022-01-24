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
        parent::__construct();

        add_shortcode('ys_groups', [$this, 'groups']);
        add_filter('template_include', [$this, 'show'], 99);
    }

    /**
     * Affichage de la page du repertoire des groupes
     *
     * @return string|null
     * @since 1.1.0
     */
    public function groups(): ?string
    {
        /**
         * Interdire l'accés aux utilisateur non connectés
         *
         * @since 1.1.2
         */
        if (! is_user_logged_in()) {
            wp_safe_redirect(home_url());
            die();
        }

        $itemsPerPage = 9;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $offset = ($paged * $itemsPerPage) - $itemsPerPage;

        $paginatedGroups = (new Groups())->getPaginatedGroups($itemsPerPage, $offset);

        $groupsTotal = (new Groups())->groupsTotalQuery();
        $currentPage = max(1, get_query_var('paged'));
        $totalPages = ceil($groupsTotal / $itemsPerPage);

        $paginateLinks = paginate_links([
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%/',
            'current' => $currentPage,
            'total' => $totalPages,
            'prev_text' => __('&laquo; Prev', YS_GROUPS_TEXT_DOMAIN),
            'next_text' => __('Next &raquo;', YS_GROUPS_TEXT_DOMAIN),
            'type' => 'list',
        ]);

        return $this->render('front/groups', [
            'paginatedGroups' => $paginatedGroups,
            'groupsTotal' => $groupsTotal,
            'paginateLinks' => $paginateLinks,
        ]);
    }

    /**
     * Affichage d'un groupe
     *
     * @since 1.1.3
     */
    public function show($template)
    {
        $slug = get_query_var('gslug');
        $feedPosts = [];

        if (! empty($slug)) {
            $url = $this->groupsDirectoryUri . $slug;

            $template = $this->locateTemplate(
                'front/single-group',
                'ys_single_group_var',
                [
                    'singleGroupUrl' => $url,
                    'feedPosts' => $feedPosts,
                ]
            );
        }

        return $template;
    }
}
