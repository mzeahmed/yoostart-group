<script setup>
  import { __ } from '@wordpress/i18n';
  import { ref } from 'vue';
  import { YS_GROUP_TEXT_DOMAIN } from '../../../../config';

  defineProps({
    content: {},
  });

  const showMore = ref(false);
</script>

<template>
  <div v-if="content.length < 150">
    <div class="content">{{ content }}</div>
  </div>
  <div v-else>
    <div class="content" v-if="! showMore">{{ `${content.substring(0, 150)}` + ` ...` }}</div>
    <div class="content" v-else>{{ content }}</div>
    <button class="read-more" @click="showMore =! showMore">
      <span v-if="showMore">{{ __('Read less', YS_GROUP_TEXT_DOMAIN) }}</span>
      <span v-else>{{ __('Read more', YS_GROUP_TEXT_DOMAIN) }}</span>
    </button>
  </div>
</template>

<style scoped>
  .content {
    position: relative;
    line-height: 2.75rem;
    padding: 5px 8px;
    font-size: 18px;
    font-weight: 400;
    overflow: hidden;
  }

  .read-more {
    border: none !important;
    color: #4ab8a6;
    background: transparent;
    font-size: 18px;
    font-weight: 500;
    margin: 15px 0 10px;
    transition: 0.3s all ease-in-out;
  }
</style>