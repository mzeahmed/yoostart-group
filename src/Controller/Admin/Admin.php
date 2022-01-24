<?php

namespace YsGroups\Controller\Admin;

use YsGroups\Model\PluginPosts;
use YsGroups\Controller\AbstractController;

/**
 * @since 1.0.6
 */
class Admin extends AbstractController
{
    public AdminGroups $ysGroups;

    public string $page;

    /**
     * @param AdminGroups $ysGroups
     *
     * @since 1.0.6
     */
    public function __construct(AdminGroups $ysGroups)
    {
        parent::__construct();

        $this->ysGroups = $ysGroups;
        $this->page = $_GET['page'] ?? '';

        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_notices', [$this, 'dependencyNotice']);
        add_filter('display_post_states', [$this, 'displayPostStates'], 10, 2);
        add_action('admin_init', [$this, 'redirectIfMainPluginNotActiv']);
    }

    /**
     * Chargement des css admin
     *
     * @return void
     * @since 1.0.6
     */
    public function enqueueScripts()
    {
        if (! empty($this->page) && ($this->page === 'ys_options_groups')) {
            wp_enqueue_style(
                'ys-groups-admin',
                YS_GROUPS_URI . '/public/css/admin.css',
                [],
                YS_GROUPS_VERSION,
                'all'
            );

            wp_enqueue_script(
                'ys-groups-admin',
                YS_GROUPS_URI . '/public/js/admin.js',
                [],
                YS_GROUPS_VERSION,
                true
            );

            wp_localize_script('ys-group-admin', 'ys_group_ajaxurl', [admin_url('admin-ajax.php')]);
        }
    }

    /**
     * Affichage notice si plugin principal inactif
     *
     * @return string|null
     */
    public function dependencyNotice(): ?string
    {
        if (! class_exists('Yoostart')) {
            return $this->render('admin/dependency-notice', []);
        }

        return null;
    }

    /**
     * Redirection si plugin principal inactif et tentatif d'acceder à la page du plugin actuel
     *
     * @return void
     * @since 1.1.0
     */
    public function redirectIfMainPluginNotActiv()
    {
        if ((! empty($this->page) && ($this->page === 'ys_options_groups')) && ! class_exists('Yoostart')) {
            wp_safe_redirect(admin_url('plugins.php'));
            die();
        }
    }

    /**
     * Affiche le nom du plugin à coté des pages créés par le plugin
     *
     * @param array    $posts_states
     * @param \WP_Post $post
     *
     * @return array
     * @see   YS_GROUPS_POSTS
     * @since 1.0.5
     */
    public function displayPostStates(array $posts_states, \WP_Post $post): array
    {
        $postIds = (new PluginPosts())->getPostsId(YS_GROUPS_POSTS);

        foreach ($postIds as $id) {
            if ($id == $post->ID) {
                $posts_states[] = 'Yoostart Groups';
            }
        }

        return $posts_states;
    }
}
