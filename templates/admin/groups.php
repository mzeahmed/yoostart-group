<?php

/**
 * @package YsGroups\Admin
 * @since   1.0.6
 */

?>

<div class="wrap">
    <h1><?php echo get_bloginfo('name') . ' - ' . __('Groups', YS_GROUPS_TEXT_DOMAIN); ?></h1>

    <div class="ys-groups-dashboard">
        <?php include __DIR__ . '/partials/_tab-nav.php' ?>

        <div class="container">
            <div class="row">
                <form id="ys-groups-filter" method="get">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                    <?php $groupList->display() ?>
                </form>
            </div>
        </div>
    </div>
</div>