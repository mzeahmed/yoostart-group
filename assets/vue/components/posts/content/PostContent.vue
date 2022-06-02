<script setup>
  import Content from './partials/Content';
  import FeaturedImage from './partials/FeaturedImage';

  defineProps({
    content: {},
    featured_image: {},
    title: {},
  });
</script>

<template>
  <div class="post-content">
    <Content :content=content />
    <FeaturedImage :featured_image=featured_image :title=title />
  </div>
</template>