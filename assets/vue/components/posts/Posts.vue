<script setup>
  import { __ } from '@wordpress/i18n';
  import { onBeforeMount, ref } from 'vue';
  import { getPosts } from '../../api/post';
  import { YS_GROUP_TEXT_DOMAIN } from '../../config';
  import PostForm from '../forms/PostForm';
  import PostContent from './content/PostContent';
  import PostFooter from './footer/PostFooter';
  import PostHeader from './header/PostHeader';

  const posts = ref([]);
  const error = ref(null);
  const loading = ref(false);
  const postCount = ref(null);
  const totalPages = ref(null);
  const currentPage = ref(1);

  onBeforeMount(() => {
    getPosts(5, currentPage.value)
        .then((res) => {
          postCount.value = res.headers.get('X-WP-Total');
          totalPages.value = res.headers.get('X-WP-TotalPages');

          return res.json();
        })
        .then((json) => {
          loading.value = true;
          posts.value = json;

          window.onscroll = () => {
            let bottomOfWindow = (window.innerHeight + window.scrollY) >= document.body.scrollHeight;
            if (bottomOfWindow) {
              // console.log(json);
            }
          };
        })
        .catch((err) => {
          error.value = err;
          loading.value = true;
          console.log(err);
        });
  });

  // onMounted(() => {
  //   window.onscroll = () => {
  //     // let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
  //     let bottomOfWindow = (window.innerHeight + window.scrollY) >= document.body.scrollHeight;
  //     if (bottomOfWindow) {
  //       getNextPosts()
  //           .then(res => res.json())
  //           .then(result => {
  //             posts.value.push(result);
  //             // alert('allo');
  //             console.log(result);
  //           });
  //     }
  //
  //     // console.log(bottomOfWindow);
  //   };
  // });

</script>

<template>
  <PostForm />

  <div v-if="error" class="ys-group-posts">
    <p class="post">{{ __('Oops! Error encountered: ', YS_GROUP_TEXT_DOMAIN) }} <strong>{{ error.message }}</strong></p>
  </div>

  <div v-else-if="!loading">
    <div class="ys-group-posts-loader text-center">
      {{ __('Loading posts ...', YS_GROUP_TEXT_DOMAIN) }}
    </div>
  </div>

  <div v-else-if="posts" class="ys-group-posts">
    <div class="post" v-for="post in posts">
      <PostHeader
          :avatar=post.author.avatar_image
          :author_name=post.author.fullname
          :date=post.date
          :profile_url=post.author.profile_url
      />
      <PostContent
          :content=post.content
          :featured_image=post.featured_image.thumbnail
          :title=post.title
      />
      <PostFooter
          :post_id=post.id
      />
    </div>
  </div>

  <div v-else>
    <div class="ys-group-posts-loader text-center-lg">
      {{ __('No post for now', YS_GROUP_TEXT_DOMAIN) }}
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

