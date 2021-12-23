<?php

/**
 * @package YsGroups\Admin
 * @since   1.0.6
 */

?>

<div class="wrap">
    <h1><?php echo get_bloginfo('name') . ' - ' . __('Groupes', YS_GROUPS_TEXT_DOMAIN); ?></h1>

    <div class="ys-groups-dashboard">
        <div class="main">
            <table class="wp-list-table widefat fixed striped ys-groups">

            </table>

            <?php dump($groups) ?>

            <div class="card" style="width: 18rem;">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>