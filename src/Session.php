<?php

namespace YsGroups;

/**
 * Besoin de la session pour les messages flash, on la gere ici
 *
 * @since 1.0.9
 */
class Session
{
    public function __construct()
    {
        add_action('init', [$this, 'sessionStart'], 1);
        add_action('wp_login', [$this, 'sessionDestroy']);
        add_action('wp_logout', [$this, 'sessionDestroy']);
    }

    /**
     * @return void
     * @since 1.0.9
     */
    public function sessionStart()
    {
        if (! session_id()) {
            session_start();
        }
    }

    /**
     * @return void
     * @since 1.0.9
     */
    public function sessionDestroy()
    {
        session_destroy();
    }
}
