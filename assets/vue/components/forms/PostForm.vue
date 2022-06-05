<script setup>
  import { YOOSTART_USER } from '../../config';
  import PostModal from '../modals/PostModal';</script>

<template>
  <div class="ys-group-new-post-form" id="ys_group_post_form">
    <div class="user-avatar">
      <div class="avatar">
        <a v-bind:href=YOOSTART_USER.profile_url><img v-bind:src=YOOSTART_USER.avatar_image alt="" /></a>
      </div>
    </div>
    <div class="ys-group-post-input">
      <PostModal />
      <!--<PostMod />-->
    </div>
  </div>
</template>

<style lang="scss" scoped>
  .ys-group-new-post-form {
    background: #fff;
    box-shadow: 0 1px 3px #a7a5a5;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 7px;
    position: relative;
    display: flex;
    align-items: center;

    .user-avatar {
      .avatar {
        margin-right: 9px;

        img {
          width: 45px;
          height: 45px;
          border-radius: 50%;
        }
      }
    }

    .ys-group-post-input {
      height: 40px;
      width: 100%;
      background: #f7f7f7;
      border-radius: 25px;
      //cursor: pointer;

      &:hover {
        background-color: #4ab8a6;
      }
    }
  }
</style>