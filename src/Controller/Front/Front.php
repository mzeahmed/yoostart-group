<?php

namespace YsGroups\Controller\Front;

/**
 * @since 1.0.9
 */
class Front
{
    public GroupsController $groups;

    public function __construct(GroupsController $groups)
    {
        $this->groups = $groups;

        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Chargement des css et js du front
     *
     * @return void
     * @since 1.1.0
     */
    public function enqueueScripts()
    {
        if (
            str_contains($_SERVER['REQUEST_URI'], 'groupes')
            || str_contains($_SERVER['REQUEST_URI'], 'groupe')
        ) {
            wp_enqueue_style(
                'ys-group',
                YS_GROUPS_URI . '/public/css/app.css',
                [],
                YS_GROUPS_VERSION,
                'all'
            );

            wp_enqueue_style('dashicons');

            wp_enqueue_script(
                'ys-group',
                YS_GROUPS_URI . '/public/js/app.js',
                [],
                YS_GROUPS_VERSION,
                true,
            );

            /**
             * Chargement des composants React
             *
             * @since 1.1.5.1
             */
            wp_enqueue_script(
                'ys-group-react-components',
                YS_GROUPS_URI . '/build/index.js',
                ['wp-element'],
                YS_GROUPS_VERSION,
                true
            );
        }
    }
}
