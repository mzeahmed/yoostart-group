<?php

namespace YsGroups\Services;

/**
 * Classe pour gerer les redirections des urls interdite aux visisteurs
 *
 * @since 1.1.5
 */
class NotLoggedInRedirections
{
    /**
     * @var string|mixed Uri courant
     */
    public string $requestUri;

    /**
     * @var array|string[] elements de la requete segmentés dans un tableau
     */
    public array $explodedRequestUri;

    public function __construct()
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->explodedRequestUri = explode('/', $this->requestUri);

        add_action('template_redirect', [$this, 'redirectGroupsDirectory']);
        add_action('template_redirect', [$this, 'redirectSingleGroup']);
    }

    /**
     * @return void
     * @since 1.1.5
     */
    public function redirectGroupsDirectory()
    {
        if (! is_user_logged_in() && $this->requestUri === '/groupes/') {
            wp_safe_redirect(home_url());
            die();
        }
    }

    /**
     * @return void
     * @since 1.1.5
     */
    public function redirectSingleGroup()
    {
        if (! is_user_logged_in() && $this->explodedRequestUri[1] === 'groupe') {
            wp_safe_redirect(home_url());
            die();
        }
    }
}
