<?php

namespace YsGroup\Controller\Admin;

use YsGroup\Controller\AbstractController;
use YsGroup\Controller\Admin\Metaboxes\PostMetas\GroupAdminMetabox;
use YsGroup\Controller\Admin\Metaboxes\PostMetas\StatusPostMetaBox;
use YsGroup\Controller\Admin\Metaboxes\PostMetas\GroupIdPostMetaBox;
use YsGroup\Controller\Admin\Metaboxes\PostMetas\CoverPhotoPostMetaBox;
use YsGroup\Controller\Admin\Metaboxes\TermMetas\YsGroupsMemberTermMeta;

/**
 * @since 1.0.6
 */
class Admin extends AbstractController
{
    public YsGroupCPT $ysGroupCPT;

    public YsGroupPostCPT $ysGroupPostCPT;

    public StatusPostMetaBox $metabox;

    public GroupAdminMetabox $groupAdminMetabox;

    public CoverPhotoPostMetaBox $coverPhotoMetaBox;

    public GroupIdPostMetaBox $ysGroupIdMetaBox;

    public YsGroupsMemberTermMeta $ysGroupsMemberTermMeta;

    public string $page;

    /**
     * @param YsGroupCPT             $ysGroupCPT
     * @param StatusPostMetaBox      $metaBox
     * @param GroupAdminMetabox      $groupAdminMetabox
     * @param CoverPhotoPostMetaBox  $coverPhotoMetaBox
     * @param YsGroupPostCPT         $ysGroupPostCPT
     * @param GroupIdPostMetaBox     $ysGroupIdMetaBox
     * @param YsGroupsMemberTermMeta $ysGroupsMemberTermMeta
     *
     * @since 1.0.6
     */
    public function __construct(
        YsGroupCPT $ysGroupCPT,
        StatusPostMetaBox $metaBox,
        GroupAdminMetabox $groupAdminMetabox,
        CoverPhotoPostMetaBox $coverPhotoMetaBox,
        YsGroupPostCPT $ysGroupPostCPT,
        GroupIdPostMetaBox $ysGroupIdMetaBox,
        YsGroupsMemberTermMeta $ysGroupsMemberTermMeta
    ) {
        parent::__construct();

        $this->ysGroupCPT = $ysGroupCPT;
        $this->metabox = $metaBox;
        $this->groupAdminMetabox = $groupAdminMetabox;
        $this->coverPhotoMetaBox = $coverPhotoMetaBox;
        $this->ysGroupPostCPT = $ysGroupPostCPT;
        $this->ysGroupIdMetaBox = $ysGroupIdMetaBox;
        $this->ysGroupsMemberTermMeta = $ysGroupsMemberTermMeta;

        $this->page = $_GET['page'] ?? '';

        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_notices', [$this, 'dependencyNotice']);
        // add_filter('display_post_states', [$this, 'displayPostStates'], 10, 2);
        add_action('admin_init', [$this, 'redirectIfMainPluginNotActiv']);
    }

    /**
     * Chargement des css admin
     *
     * @return void
     * @since 1.0.6
     */
    public function enqueueScripts(): void
    {
        global $current_screen;

        if (
            (! empty($this->page) && ($this->page === 'ys_options_groups'))
            || $current_screen->taxonomy === 'ys_group_member'
            || $current_screen->post_type === 'ys-group-post'
            || $current_screen->post_type === 'ys-group'
        ) {
            wp_enqueue_style(
                'ys-groups-admin',
                YS_GROUP_URI . '/public/css/admin.css',
                [],
                YS_GROUP_VERSION,
                'all'
            );

            wp_enqueue_script(
                'ys-groups-admin',
                YS_GROUP_URI . '/public/js/admin.js',
                ['jquery'],
                YS_GROUP_VERSION,
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
    public function redirectIfMainPluginNotActiv(): void
    {
        if ((! empty($this->page) && ($this->page === 'ys_options_groups')) && ! class_exists('Yoostart')) {
            wp_safe_redirect(admin_url('plugins.php'));
            die();
        }
    }
}
