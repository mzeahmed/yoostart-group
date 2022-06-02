<script setup>
  import { __ } from '@wordpress/i18n';
  import { ref } from 'vue';
  import { YS_GROUP_JWT } from '../../../js/constants/constants';
  import { YOOSTART_USER, YS_GROUP_TEXT_DOMAIN } from '../../config';
  import PostFeaturedMedias from '../featured-media/PostFeaturedMedias';

  const show = ref(false);
  const submitting = ref(false);

  async function handleSubmit (e) {
    e.preventDefault();
    show.value = true;

    await fetch('', {
      method: 'post',
      headers: {
        'Content-Type': 'application/json',
        'accept': 'application/json',
        'Authorization': `Bearer ${YS_GROUP_JWT}`,
      },
    });
  }
</script>

<template>
  <button class="post-input-button" type="button" data-toggle="modal" data-target="#ysGroupPostModal">
    {{
      __(YOOSTART_USER.firstname + ' share your service offers or submit an issue to the community', YS_GROUP_TEXT_DOMAIN)
    }}
  </button>

  <div class="modal fade ys-group-post-modal" id="ysGroupPostModal" tabindex="-1" role="dialog"
       aria-labelledby="ysGroupPostModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ __('Publish post', YS_GROUP_TEXT_DOMAIN) }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <span class="ys-group-submitting-loader"></span>

        <div class="modal-body">
          <form>
            <div class="form-group">
              <textarea
                  class="form-control"
                  name="post_content"
                  :placeholder="YOOSTART_USER.firstname + ' ' + __('publish something', YS_GROUP_TEXT_DOMAIN)"
                  is="textarea-autogrow"
              >
              </textarea>
            </div>
          </form>
        </div>

        <PostFeaturedMedias />

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">{{ __('Publish', YS_GROUP_TEXT_DOMAIN) }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>