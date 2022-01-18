<?php

/**
 * @package YsGroups\Front
 * @since   1.1.0
 */

?>

<div class="ys-groups-list">
    <?php foreach ($groups as $group) : ?>
        <div class="card ys-group" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?php echo $group['name'] ?></h5>
                <p class="card-text"><?php echo $group['description'] ?></p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>