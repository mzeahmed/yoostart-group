<?php

/**
 * @since 1.1.4
 */

global $wp_query;
extract($wp_query->query_vars);

?>

<?php require YOOSTART_PLUGIN_DIR_PATH . 'public/partials/template-parts/user-header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php dump($ys_single_group_var['singleGroupUrl']) ?>
        </div>
    </div>
</div>

<?php get_footer() ?>
