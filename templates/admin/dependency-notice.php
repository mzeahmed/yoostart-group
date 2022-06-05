<?php

/**
 * @package AdminGroupsController
 * @since   1.0.0
 */

?>

<div class="notice notice-error is-dismissible">
    <p>
        <?php
        printf(
            __(
                "The main <strong>Yoostart</strong> plugin is required to run <strong>%s</strong>, please activate it",
                YS_GROUP_TEXT_DOMAIN
            ),
            YS_GROUP_PLUGIN_NAME
        )
        ?>
    </p>
</div>
