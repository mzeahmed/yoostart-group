<?php

namespace YsGroups\Admin;

/**
 * @since 1.0.6
 */
class Admin
{
    public PostStates $postStates;

    public OptionsMenu $options;

    public string $page;

    /**
     * @param PostStates  $postStates
     * @param OptionsMenu $options
     */
    public function __construct(PostStates $postStates, OptionsMenu $options)
    {
        $this->postStates = $postStates;
        $this->options = $options;
        $this->page = $_GET['page'] ?? '';

        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * Chargement des css admin
     *
     * @return void
     * @since 1.0.6
     */
    public function enqueueScripts()
    {
        if (isset($this->page) && ($this->page === 'ys_options_groups') || $this->page === 'ys_create_group') {
            wp_enqueue_style(
                'ys-groups-admin',
                YS_GROUPS_URL . '/public/css/admin.css',
                [],
                YS_GROUPS_VERSION,
                'all'
            );

            wp_enqueue_script(
                'ys-groups-admin',
                YS_GROUPS_URL . '/public/js/admin.js',
                [],
                YS_GROUPS_VERSION,
                true
            );
        }
    }
}
