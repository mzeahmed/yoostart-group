<?php

namespace YsGroups\Controller\Admin;

use YsGroups\Model\Groups;
use YsGroups\Helpers\Helpers;
use YsGroups\Model\GroupsMembers;
use YsGroups\Controller\AbstractController;

/**
 * @since 1.0.6
 */
class AdminGroups extends AbstractController
{
    public string $pluginPage;

    public string $groupsIndexScreen;

    public string $action;

    public function __construct()
    {
        parent::__construct();

        if (isset($_GET['page'])) {
            $this->pluginPage = wp_unslash($_GET['page']);
            $this->pluginPage = plugin_basename($this->pluginPage);
        }

        $this->groupsIndexScreen = admin_url('admin.php?page=ys_options_groups');
        $this->action = $this->groupsIndexScreen . '&action=create';

        add_action('admin_menu', [$this, 'adminMenu'], 20);
        add_action('admin_init', [$this, 'createGroupHandler']);
    }

    /**
     * @return void
     * @since 1.0.6
     */
    public function adminMenu()
    {
        $hook = add_submenu_page(
            'ys_options',
            __('Groups', YS_GROUPS_TEXT_DOMAIN),
            __('Groups', YS_GROUPS_TEXT_DOMAIN),
            'manage_options',
            'ys_options_groups',
            [$this, 'groupsScreen'],
            4
        );

        add_action("load-$hook", [$this, 'groupsAdminLoad']);
    }

    /**
     * Selectionne l'ecran approprié et l'affiche
     *
     * @return void
     * @since 1.0.9
     */
    public function groupsScreen()
    {
        $doaction = Helpers::listTableCurrentBulkAction();

        if ('edit' == $doaction && ! empty($_GET['gid'])) {
        } elseif ('delete' == $doaction && ! empty($_GET['gid'])) {
            $this->deleteGroup();
        } elseif ('create' == $doaction) {
            $this->createGroupe();
        } else {
            $this->groupsIndex();
        }
    }

    /**
     * Affichage du tableau des groupes
     *
     * @return string|null
     * @since 1.0.6
     */
    public function groupsIndex(): ?string
    {
        $groupList = new GroupListTable();
        $messages = [];

        if (! empty($_REQUEST['deleted'])) {
            $deleted = ! empty($_REQUEST['deleted']) ? (int)$_REQUEST['deleted'] : 0;

            if ($deleted > 0) {
                /* traductions: %s: nombre de groupes supprimés */
                $messages[] = sprintf(
                    _n(
                        '%s group has been permanently deleted.',
                        '%s groups have permanently deleted.',
                        $deleted,
                        YS_GROUPS_TEXT_DOMAIN
                    ),
                    number_format_i18n($deleted)
                );
            }
        }

        $groupList->prepare_items();

        /**
         * Se déclenche avant l'affichage des messages pour le formulaire d'édition.
         *
         * @param array $messages
         *
         * @since 1.1.0
         */
        do_action('ys_groups_admin_index', $messages);

        return $this->render('admin/groups-index', [
            'groupList' => $groupList,
            'pluginPage' => $this->pluginPage,
        ]);
    }

    /**
     * Affichage du formulaire de création de groupe
     *
     * @return string|null
     */
    public function createGroupe(): ?string
    {
        return $this->render('admin/create-group', ['action' => $this->action]);
    }

    /**
     * Gestionnaire du formulaire de création de groupe
     *
     * @return void
     * @since 1.0.8
     */
    public function createGroupHandler()
    {
        $user = wp_get_current_user();
        $groups = new Groups();
        $groupsMember = new GroupsMembers();

        if (isset($_POST['_ys_create_group_nonce'])) {
            if (! wp_verify_nonce($_POST['_ys_create_group_nonce'], $this->action)) {
                wp_die(
                    sprintf(
                        esc_html__(
                            '<strong>Sorry, nonce %s  did not verifyed</strong>',
                            YS_GROUPS_TEXT_DOMAIN
                        ),
                        '_ys_create_group_nonce'
                    )
                );
            }

            if (
                isset($_POST['ys_group_name'])
                && isset($_POST['ys_group_description'])
                && isset($_POST['ys_group_status'])
            ) {
                $groups->persistGroup(
                    $user->ID,
                    sanitize_text_field($_POST['ys_group_name']),
                    Helpers::checkGroupSlug(esc_attr($_POST['ys_group_name'])),
                    sanitize_textarea_field($_POST['ys_group_description']),
                    $_POST['ys_group_status'],
                    wp_date('Y-m-d H:i:s')
                );

                $groupId = $groups->getLastId();

                $groupsMember->persistMember(
                    $groupId,
                    $user->ID,
                    null,
                    true,
                    wp_date('Y-m-d H:i:s'),
                    true,
                    false
                );

                $this->addFlash(
                    'success',
                    sprintf(
                        __('Group (%s) has been successfully created', YS_GROUPS_TEXT_DOMAIN),
                        $_POST['ys_group_name']
                    )
                );

                wp_safe_redirect($this->groupsIndexScreen, 302, YS_GROUPS_PLUGIN_NAME);
            }
        }
    }

    /**
     * Affichage de l'ecran de confirmation de suppression de groupes
     *
     * @return string|null
     * @since 1.1.0
     */
    public function deleteGroup(): ?string
    {
        $group_ids = $_REQUEST['gid'] ?? 0;

        if (! is_array($group_ids)) {
            $group_ids = explode(',', $group_ids);
        }
        $group_ids = wp_parse_id_list($group_ids);

        $group_names = Helpers::getGroupsName($group_ids);

        $base_url = remove_query_arg(['action', 'action2', 'paged', 's', '_wpnonce', 'gid'], $_SERVER['REQUEST_URI']);

        return $this->render('admin/delete-confirm', [
            'names' => $group_names,
            'group_ids' => $group_ids,
            'base_url' => $base_url,
        ]);
    }

    /**
     * @return void
     * @since 1.1.0
     */
    public function groupsAdminLoad()
    {
        $groupListTable = new GroupListTable();

        // Construction de l'URL de redirection
        $redirect_to = remove_query_arg([
            'action',
            'action2',
            'gid',
            'deleted',
            'error',
            'updated',
            'success_new',
            'error_new',
            'success_modified',
            'error_modified',
        ], $_SERVER['REQUEST_URI']);

        $doaction = Helpers::listTableCurrentBulkAction();

        /**
         * @param string $doaction action $_GET courrante
         *
         * @since 1.0.9
         */
        do_action('ys_groups_admin_load', $doaction);

        if ('do_delete' == $doaction && ! empty($_GET['gid'])) {
            check_admin_referer('ys-groups-delete');

            $group_ids = wp_parse_id_list($_GET['gid']);

            $count = 0;
            foreach ($group_ids as $group_id) {
                if ((new Groups())->deleteGroup($group_id)) {
                    $count++;
                }
            }

            $redirect_to = add_query_arg('deleted', $count, $redirect_to);

            wp_safe_redirect($redirect_to);
        } elseif ('edit' == $doaction && ! empty($_GET['gid'])) {
            add_screen_option('layout_columns', ['default' => 2, 'max' => 2]);

            get_current_screen()->add_help_tab([
                'id' => 'ys-group-edit-overview',
                'title' => __('Overview', YS_GROUPS_TEXT_DOMAIN),
                'content' =>
                    '<p>' . __(
                        'This page is a convenient way to edit the details associated with one of your groups.',
                        YS_GROUPS_TEXT_DOMAIN
                    ) . '</p>' .
                    '<p>' . __(
                        'The Name and Description box is fixed in place, but you can reposition all the other boxes using drag and drop, and can minimize or expand them by clicking the title bar of each box. Use the Screen Options tab to hide or unhide, or to choose a 1- or 2-column layout for this screen.',
                        YS_GROUPS_TEXT_DOMAIN
                    ) . '</p>',
            ]);
        }
    }
}
