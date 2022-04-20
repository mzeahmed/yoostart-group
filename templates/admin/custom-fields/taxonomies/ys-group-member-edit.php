<?php

/**
 * @since 1.2.2
 */

?>

<tr class="form-field">
    <th scope="row" valign="top">
        <label for="ys_group_member_user">
            <?php _e('User', YS_GROUPS_TEXT_DOMAIN); ?>
        </label>
    </th>
    <td>
        <?php wp_dropdown_users($args) ?>

        <p class="description"><?php _e('User associated to this taxonomy', YS_GROUPS_TEXT_DOMAIN); ?></p>
    </td>
</tr>
