<script setup>
  import { YOOSTART_USER } from '../../config';
  import PostModal from '../modals/PostModal';</script>

<template>
  <div class="ys-group-new-post-form" id="ys_group_post_form">
    <div class="row">
      <div class="col-md-2 user-avatar">
        <div class="avatar">
          <a v-bind:href=YOOSTART_USER.profile_url><img v-bind:src=YOOSTART_USER.avatar_image alt="" /></a>
        </div>
      </div>
      <div class="col-md-10 ys-group-post-input">
        <PostModal />
      </div>
    </div>
  </div>
</template>

<style scoped>
  .ys-group-new-post-form {
    background: #fff;
    box-shadow: 0 1px 3px #a7a5a5;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 7px;
    position: relative;
  }

  .avatar img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
  }
</style>