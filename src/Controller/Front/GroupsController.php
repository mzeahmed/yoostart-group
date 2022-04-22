<?php

namespace YsGroups\Controller\Front;

use WP_User;
use YsGroups\Model\Groups;
use YsGroups\Helpers\Helpers;
use YsGroups\Services\Mailer;
use YsGroups\Model\GroupsPosts;
use YsGroups\Model\GroupsMembers;
use YsGroups\Controller\AbstractController;

/**
 * @since 1.1.0
 */
class GroupsController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        add_shortcode('ys_groups', [$this, 'groups']);
        // add_filter('template_include', [$this, 'show'], 100, 1);
        add_action('template_redirect', [$this, 'ajaxFileUploadHandler']);
        add_action('wp', [$this, 'joinGroupHandler']);
        add_filter('template_include', [$this, 'single'], 99);
        add_filter('template_include', [$this, 'archive']);
        // add_action('wp_ajax_ajaxFileUploadHandler', [$this, 'ajaxFileUploadHandler']);
    }

    /**
     * @param $template
     *
     * @return string
     * @since 1.2.3
     */
    public function single($template): string
    {
        $postMeta = get_post_meta(get_the_ID(), YS_GROUP_STATUS_META_KEY);
        $coverImageId = carbon_get_post_meta(get_the_ID(), YS_GROUP_COVER_PHOTO_META_KEY);
        $coverImageUrl = wp_get_attachment_image_url($coverImageId);

        // dump($coverImageId, $coverImageUrl);

        if (is_single() && get_post_type() == 'ys-group') {
            $template = $this->template(
                'front/single',
                'ysGroupMeta',
                [
                    'postMeta' => $postMeta,
                    'coverImageUrl' => $coverImageUrl,
                ]
            );
        }

        return $template;
    }

    /**
     * @param $template
     *
     * @return string
     * @since 1.2.4
     */
    public function archive($template): string
    {
        if (is_post_type_archive('ys-group')) {
            $template = $this->template(
                'front/archive',
                '',
                []
            );
        }

        return $template;
    }

    /**
     * Rendu de la page du repertoire des groupes
     *
     * @return string|null
     * @since 1.1.0
     */
    public function groups(): ?string
    {
        $itemsPerPage = 9;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $offset = ($paged * $itemsPerPage) - $itemsPerPage;

        $paginatedGroups = (new Groups())->getPaginatedGroups($itemsPerPage, $offset);

        $groupsTotal = (new Groups())->groupsTotalQuery();
        $currentPage = max(1, get_query_var('paged'));
        $totalPages = ceil($groupsTotal / $itemsPerPage);

        $paginateLinks = paginate_links([
            'base' => get_pagenum_link(1) . '%_%',
            'format' => 'page/%#%/',
            'current' => $currentPage,
            'total' => $totalPages,
            'prev_text' => __('&laquo; Prev', YS_GROUPS_TEXT_DOMAIN),
            'next_text' => __('Next &raquo;', YS_GROUPS_TEXT_DOMAIN),
            'type' => 'list',
        ]);

        return $this->render('front/groups', [
            'paginatedGroups' => $paginatedGroups,
            'groupsTotal' => $groupsTotal,
            'paginateLinks' => $paginateLinks,
        ]);
    }

    /**
     * Rendu de la page d'un groupe
     *
     * @since 1.1.3
     */
    public function show($template)
    {
        $slug = get_query_var('gslug');

        if (! empty($slug)) {
            // Group
            $groupId = intval((new Groups())->getGroupIdBySlug($slug));
            $groupDatas = Helpers::getGroupDatasBySlug($slug);
            $groupAdminId = intval((new GroupsMembers())->getGroupAdminId($groupId));
            $isMember = Helpers::isGroupMember($groupId, wp_get_current_user()->ID);
            $action = home_url('/groupes/' . $slug . '/');

            $data = '';
            foreach ($groupDatas as $v) {
                $data = $v;
            }

            // Posts
            $itemsPerPage = 9;
            $paged = (get_query_var('paged') ? get_query_var('paged') : 1);
            $offset = ($paged * $itemsPerPage) - $itemsPerPage;

            $paginatedPosts = (new GroupsPosts())->getPostsByGroupId($groupId, $itemsPerPage, $offset);

            $postsTotal = (new GroupsPosts())->groupPostsTotalQuery($groupId);
            $currentPage = max(1, get_query_var('paged'));
            $totalPages = ceil($postsTotal / $itemsPerPage);

            $paginateLinks = paginate_links([
                'base' => get_pagenum_link(1) . '%_%',
                'format' => 'page/%#%/',
                'current' => $currentPage,
                'total' => $totalPages,
                'prev_text' => __('&laquo; Prev', YS_GROUPS_TEXT_DOMAIN),
                'next_text' => __('Next &raquo;', YS_GROUPS_TEXT_DOMAIN),
                'type' => 'list',
            ]);

            $template = $this->locateTemplate(
                'front/single-group',
                'ysGroupVars',
                [
                    'groupAdminId' => $groupAdminId,
                    'groupName' => $data['name'],
                    'groupStatus' => $data['status'],
                    'groupId' => $groupId,
                    'isMember' => $isMember,
                    'action' => $action,
                    'paginatedPosts' => $paginatedPosts,
                    // 'paginateLinks' => $paginateLinks,
                ]
            );
        }

        return $template;
    }

    /**
     * @return void
     */
    public function ajaxFileUploadHandler()
    {
        $slug = get_query_var('gslug');

        if (! empty($slug)) {
            $groupId = (new Groups())->getGroupIdBySlug($slug);

            if (isset($_POST['ys_group_cover_submit'])) {
                if (! wp_verify_nonce($_POST['_cover_nonce'], 'ys_group_ajax_nonce')) :?>
                    <div class="alert alert warning">
                        <?php sprintf(
                            esc_html__(
                                '<strong>Sorry, nonce %s  did not verifyed</strong>',
                                YS_GROUPS_TEXT_DOMAIN
                            ),
                            '_cover_nonce'
                        ) ?>
                    </div>
                <?php endif;

                if ($_FILES['ys_group_cover_file_input']) {
                    Helpers::uploadFile($groupId, 'cover', $_FILES['ys_group_cover_file_input']);
                }

                $this->addFlash('success', __('Cover has been successfully updated', YS_GROUPS_TEXT_DOMAIN));
            }
        }
    }

    /**
     * @return void
     */
    public function joinGroupHandler()
    {
        $slug = get_query_var('gslug');
        $groupsMembers = new GroupsMembers();
        $groupId = (new Groups())->getGroupIdBySlug($slug);
        $mailer = new Mailer();
        $groupDatas = Helpers::getGroupDatasBySlug($slug);

        if (isset($_POST['_ys_single_join_group_nonce'])) {
            if (! wp_verify_nonce($_POST['_ys_single_join_group_nonce'], home_url('/groupes/' . $slug . '/'))) {
                wp_die(
                    sprintf(
                        esc_html__(
                            'Sorry, nonce %s  did not verifyed',
                            YS_GROUPS_TEXT_DOMAIN
                        ),
                        '_ys_single_join_group_nonce'
                    )
                );
            }

            $groupAdminId = (new GroupsMembers())->getGroupAdminId($groupId);
            $groupAdmin = new WP_User($groupAdminId);
            $sender = wp_get_current_user();

            $data = '';
            foreach ($groupDatas as $v) {
                $data = $v;
            }

            if (! Helpers::isGroupMember($groupId, wp_get_current_user()->ID)) {
                $groupsMembers->persistMember(
                    $groupId,
                    wp_get_current_user()->ID,
                    null,
                    false,
                    wp_date('Y-m-d H:i:s'),
                    false,
                    false
                );

                $this->addFlash(
                    'success',
                    __(
                        'Your request has been sent, it will be validated by the group administrator',
                        YS_GROUPS_TEXT_DOMAIN
                    )
                );

                wp_safe_redirect(wp_get_referer());

                $mailer->joinGroupRequestMail($groupAdmin->user_email, $sender->display_name, $data['name']);
            } else {
                $this->addFlash(
                    'warning',
                    __('You are already member', YS_GROUPS_TEXT_DOMAIN)
                );
            }
        }
    }
}
