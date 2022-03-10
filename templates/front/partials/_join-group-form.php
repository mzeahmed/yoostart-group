<?php //if (! $ysGroupVars['isMember']) :  ?>
<div class="ys-join-group">
    <form action="<?php $ysGroupVars['action'] ?>" method="post" name="ys_join_group_form">
        <?php wp_nonce_field($ysGroupVars['action'], '_ys_join_group_nonce') ?>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i>
            <?php _e('Join group', YS_GROUPS_TEXT_DOMAIN) ?>
        </button>
    </form>
</div>
<?php //endif; ?>
