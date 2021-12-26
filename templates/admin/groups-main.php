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
                <?php //foreach ($groups as $group) : ?>
                <!--    <div class="col-md-4">-->
                <!--        <div class="card" style="width: 18rem;">-->
                <!--            <img src="..." class="card-img-top" alt="...">-->
                <!--            <div class="card-body">-->
                <!--                <h5 class="card-title">--><?php //echo $group['name'] ?><!--</h5>-->
                <!--                <p class="card-text">--><?php //echo $group['description'] ?><!--</p>-->
                <!--                <a href="#">--><?php //_e('Modifier', YS_GROUPS_TEXT_DOMAIN) ?><!--</a>-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <?php //endforeach; ?>

                <form id="ys-groups-filter" method="get">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
                    <?php $groupList->display() ?>
                </form>
            </div>
        </div>
    </div>
</div>