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
            || (is_single() && get_post_type() == 'ys-group')
            || (is_archive() && get_post_type() == 'ys-group')
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
                ['wp-element', 'wp-i18n'],
                YS_GROUPS_VERSION,
                true,
            );

            /**
             * Variables dont on besoin d'envoyer à javascript, React etc...
             */
            $config = [
                'ajax_url' => admin_url('admin-ajax.php'),
                '_cover_nonce' => wp_create_nonce('ys_group_ajax_nonce'),
                'rest_url' => rest_url(),
            ];

            wp_localize_script(
                'ys-group',
                'ys_group_config',
                $config
            );
        }
    }
}
