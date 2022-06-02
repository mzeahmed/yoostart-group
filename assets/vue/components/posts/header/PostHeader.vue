<script setup>
  import moment from 'moment';

  defineProps({
    avatar: {},
    author_name: {},
    date: {},
    profile_url: {},
  });
</script>

<template>
  <div class="post-header">
    <div class="post-author d-flex">
      <a v-bind:href=profile_url><img v-bind:src=avatar alt=""></a>
      <div class="author-name post-date">
        <div class="name"><a v-bind:href=profile_url>{{ author_name }}</a></div>
        <div class="date">
          <i content="fas fa-globe-europe"></i>
          {{ moment(date).fromNow() }}
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .author-name {
    margin-left: 15px;
  }

  img {
    width: 45px;
    height: 45px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
    border-radius: 50%;
    background-color: #efefef;
  }

  .post-date .date {
    font-size: 13px
  }
</style>