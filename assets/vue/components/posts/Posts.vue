<script setup>
  import { __ } from '@wordpress/i18n';
  import { ref } from 'vue';
  import { YS_GROUP_GET_POSTS_ENDPOINT, YS_GROUP_JWT, YS_GROUP_TEXT_DOMAIN } from '../../config';
  import PostForm from '../forms/PostForm';
  import PostContent from './content/PostContent';
  import PostFooter from './footer/PostFooter';
  import PostHeader from './header/PostHeader';

  const post = ref(null);
  const error = ref(null);

  fetch(YS_GROUP_GET_POSTS_ENDPOINT, {
    headers: {
      'Authorization': `Bearer ${YS_GROUP_JWT}`,
    },
  })
      .then((res) => res.json())
      .then((json) => (post.value = json))
      .catch((err) => (error.value = err));

</script>

<template>
  <PostForm />

  <div v-if="error" class="ys-group-posts">
    <p class="post">{{ __('Oops! Error encountered: ', YS_GROUP_TEXT_DOMAIN) }} {{ error.message }}</p>
  </div>

  <div v-else-if="post" class="ys-group-posts">
    <div class="post" v-for="p in post">
      <PostHeader
          :avatar=p.author.avatar_image
          :author_name=p.author.fullname
          :date=p.date
          :profile_url=p.author.profile_url
      />
      <PostContent
          :content=p.content
          :featured_image=p.featured_image.thumbnail
          :title=p.title
      />
      <PostFooter
          :post_id=p.id
      />
    </div>
  </div>

  <div v-else>
    <div class="ys-group-posts-loader text-center-lg">
      {{ __('Loading...', YS_GROUP_TEXT_DOMAIN) }}
    </div>
  </div>
</template>

<style scoped>
  .post {
    background: #fff;
    box-shadow: 0 1px 3px #a7a5a5;
    margin-bottom: 20px;
    padding: 10px;
    border-radius: 7px;
    position: relative;
  }
</style>

