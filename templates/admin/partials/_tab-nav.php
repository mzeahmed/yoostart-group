<?php

/**
 * @package YsGroups\Admin
 * @since   1.0.7.3
 */

?>
<?php $page = $_GET['page'] ?? 'ys_options_groups' ?>

<h2 class="nav-tab-wrapper">
    <a href="?page=ys_options_groups"
       class="nav-tab <?= $page === 'ys_options_groups' ? 'nav-tab-active' : ''; ?>">
        <?php _e('Groups', YS_GROUPS_TEXT_DOMAIN); ?>
    </a>
    <a href="?page=ys_create_group"
       class="nav-tab <?= $page === 'ys_create_group' ? 'nav-tab-active' : ''; ?>">
        <?php _e('Create new groupe', YS_GROUPS_TEXT_DOMAIN); ?>
    </a>
</h2>