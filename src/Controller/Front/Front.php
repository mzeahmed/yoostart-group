<?php

namespace YsGroup\Controller\Front;

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
        add_action('wp_logout', [$this, 'unsetJWT'], 99);
    }

    /**
     * Chargement des css et js du front
     *
     * @return void
     * @since 1.1.0
     */
    public function enqueueScripts(): void
    {
        if (
            str_contains($_SERVER['REQUEST_URI'], 'groupes')
            || str_contains($_SERVER['REQUEST_URI'], 'groupe')
            || (is_single() && get_post_type() == 'ys-group')
            || (is_archive() && get_post_type() == 'ys-group')
        ) {
            wp_enqueue_style(
                'ys-group',
                YS_GROUP_URI . '/public/build/app.css',
                [],
                YS_GROUP_VERSION,
                'all'
            );

            wp_enqueue_style('dashicons');

            wp_enqueue_script(
                'ys-group',
                YS_GROUP_URI . '/public/build/app.js',
                ['wp-element', 'wp-i18n'],
                YS_GROUP_VERSION,
                true,
            );

            /**
             * Variables dont on besoin d'envoyer à javascript, React etc...
             */
            $config = [
                'ajax_url' => admin_url('admin-ajax.php'),
                '_cover_nonce' => wp_create_nonce('ys_group_ajax_nonce'),
                'rest_url' => rest_url(),
                'yoostart_user' => get_ys_user_details(get_current_user_id()),
                'wp_user' => wp_get_current_user(),
                'text_domain' => YS_GROUP_TEXT_DOMAIN,
                '_ys_group_jwt' => get_transient('_ys_group_jwt')
            ];

            wp_localize_script(
                'ys-group',
                'ys_group_config',
                $config
            );
        }
    }

    /**
     * Unset du jwt à la déconnexion
     *
     * @since 1.3.5
     */
    public function unsetJWT(): void
    {
        delete_transient('_ys_group_jwt');
    }
}
