<?php

/**
 * @since 1.1.6
 */

// dump($ysGroupVars)
?>

<div id="ysCoverFormModal" class="modal fade form-edit" tabindex="-1" aria-labelledby="ysCoverFormModal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered popup">
        <div class="modal-content popup-content">
            <div class="modal-header">
                <h5 class="modal-title popup-title" id="ysCoverFormModal">
                    <?php _e("Edit group cover image", YS_GROUP_TEXT_DOMAIN); ?>
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="popup-image"></div>

                <form action="#" name="ys_cover_form" method="post" enctype="multipart/form-data">
                    <?php wp_nonce_field('ys_group_ajax_nonce', '_cover_nonce') ?>
                    <div class="text-center p4">
                        <div class="popup-choose-file">
                            <label for="ys_group_cover_file_input">
                                <?php _e('Choose photo', YS_GROUP_TEXT_DOMAIN); ?>
                            </label>
                            <input type="file" id="ys_group_cover_file_input" name="ys_group_cover_file_input"
                                   class="popup-choose-file-field cover-input">
                        </div>

                        <input
                            type="submit"
                            name="ys_group_cover_submit"
                            class="btn btn-primary ys-group-update-cover ys-group-update-image"
                            value="<?php _e('Update', YS_GROUP_TEXT_DOMAIN); ?>"
                        >
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  const openBtn = document.querySelectorAll('[data-modal-target]');
  const closeBtn = document.querySelectorAll('[data-modal-close]');
  const overlay = document.getElementById('overlay');
  const nextbtn = document.querySelector('.nextbtn');
  const currentParagraph = document.querySelector('.current');
  const nextParagraph = document.querySelector('.next');
  const tooltip = document.querySelector('.tooltip');

  nextbtn.addEventListener('click', (() => {
    currentParagraph.classList.toggle('inactive');
    nextParagraph.classList.toggle('active');
    tooltip.classList.toggle('active');
  }));

  openBtn.forEach((btn) => {
    //Checks the target of our data-modal-target. could have also used '.modal'
    const modal = document.querySelector(btn.dataset.modalTarget);
    btn.addEventListener('click', (() => {
      openModal(modal);
    }));
  });

  closeBtn.forEach((btn) => {
    const modal = btn.closest('.modal');
    btn.addEventListener('click', (() => {
      closeModal(modal);
    }));
  });

  overlay.addEventListener('click', (() => {
    const modals = document.querySelectorAll('.modal.active');
    modals.forEach((modal) => {
      closeModal(modal);
    });
  }));

  function openModal (modal) {
    if (modal == undefined) return;
    modal.classList.add('active');
    overlay.classList.add('active');
  }

  function closeModal (modal) {
    if (modal == undefined) return;
    modal.classList.remove('active');
    overlay.classList.remove('active');
  }

</script>