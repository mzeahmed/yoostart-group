<?php

/**
 * @package YsGroups
 * @since   1.0.0
 */

?>

<div class="notice notice-error is-dismissible">
    <p>
        <?php
        printf(
            __(
                "Le plugin Yoostart est nécessaire pour le bon fonctionnement de <strong>%s</strong>, veuillez l'activer",
                YS_GROUPS_TEXT_DOMAIN
            ),
            YS_GROUPS_PLUGIN_NAME
        )
        ?>
    </p>
</div>
