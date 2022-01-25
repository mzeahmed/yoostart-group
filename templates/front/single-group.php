<?php

/**
 * @since 1.1.4
 */

global $wp_query;
extract($wp_query->query_vars);
?>

<?php require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>
<?php require YS_GROUPS_PATH . 'templates/front/partials/group-header.php'; ?>

<div class="container">

</div>

<?php get_footer() ?>
