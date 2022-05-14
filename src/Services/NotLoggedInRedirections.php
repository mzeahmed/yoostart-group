<?php

namespace YsGroup\Services;

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
    private string $requestUri;

    public function __construct()
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];

        add_action('template_redirect', [$this, 'redirectGroupsDirectory']);
        add_action('template_redirect', [$this, 'redirectSingleGroup']);
    }

    /**
     * @return void
     * @since 1.1.5
     */
    public function redirectGroupsDirectory(): void
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
    public function redirectSingleGroup(): void
    {
        $slug = get_query_var('gslug');

        if (! is_user_logged_in() && ! empty($slug)) {
            wp_safe_redirect(home_url());
            die();
        }
    }
}
