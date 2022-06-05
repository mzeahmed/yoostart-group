<script setup>
  import { ref } from 'vue';
  import { createPost } from '../../../js/services/PostService';
  import { YOOSTART_USER, YS_GROUP_TEXT_DOMAIN } from '../../config';
  import { __ } from '@wordpress/i18n';

  const show = ref(false);
  const submitting = ref(false);
  const post_content = ref('');

  const modal = document.querySelector('.modal');

  const openModal = (el) => {
    document.getElementById(el).classList.add('is-active');
  };

  const closeModal = (el) => {
    document.getElementById(el).classList.remove('is-active');
  };

  const esc = () => {
    let elems = document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button');
    elems.forEach((e) => {
      const target = e.closest('.modal');
      console.log(target);
      e.addEventListener('click', () => {
        target.classList.remove('is-active');
      });
    });
  };
  // esc();

  console.log(modal);

  async function handleSubmit (e) {
    e.preventDefault();
    // show.value = true;

    let post = post_content.value;
    await createPost(post);

    submitting.value = true;

    setTimeout(() => {
      submitting.value = false;
      closeModal('postModal');
    }, 500);
  }
</script>

<template>
  <button class="button is-large modal-button" @click="openModal('postModal')">
    {{
      __(YOOSTART_USER.firstname + ', share your service offers or submit an issue to the community', YS_GROUP_TEXT_DOMAIN)
    }}
  </button>

  <div id="postModal" class="modal">
    <div class="modal-background"></div>
    <span v-if="submitting" class="ys-group-submitting-loader"></span>
    <div class="modal-card">
      <header class="modal-card-head">
        <div class="container">
          <div class="columns">
            <div class="column is-four-fifths">
              <h3 class="modal-card-title">{{ __('Publish a message', YS_GROUP_TEXT_DOMAIN) }}</h3>
            </div>

            <div class="column close-modal-column">
              <button class="delete" @click="closeModal('postModal')"></button>
            </div>
          </div>
        </div>
      </header>

      <section class="modal-card-body">
        <form action="" @submit="handleSubmit">
          <textarea
              v-model="post_content"
              :placeholder="YOOSTART_USER.firstname + ' ' + __('publish something', YS_GROUP_TEXT_DOMAIN)"
              is="textarea-autogrow"
          >
          </textarea>

          <button type="submit" class="button">Save changes</button>
        </form>
      </section>
    </div>
  </div>
</template>

<style lang="scss" scoped>
  .modal-button {
    padding: 5px 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: #f7f7f7;
    border-radius: 25px !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    letter-spacing: 1px !important;
    color: #6d6d6d;

    &:hover {
      color: #fff !important;
      background-color: #4ab8a6 !important;
    }
  }

  #postModal {
    .ys-group-submitting-loader {
      margin: 15px auto;
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid #4ab8a6;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite; /* Safari */
      animation: spin 2s linear infinite;
    }

    .modal-card {
      border-radius: 5px !important;

      header {
        height: 80px;
        position: relative;
        border: none;
        padding: 5px 20px;
        background: linear-gradient(90deg, #4ab6a4, #14a3d0);

        .modal-card-title {
          margin: 0 auto;
          text-align: center;
          font-size: 28px;
          font-weight: 500;
          position: relative;
          color: #fff;
        }

        .close-modal-column {
          text-align: center;

          .delete {
            position: absolute;
            right: 0;
            min-height: 20px !important;
            min-width: 20px !important;
            max-height: unset !important;
            max-width: unset !important;
            height: 32px !important;
            width: 32px !important;

            &:before, &:after {
              background-color: #000;
            }

            &:hover {
              background-color: rgba(10, 10, 10, 0.1) !important;
            }
          }
        }
      }
    }

    form {
      button {
        width: 100%;
        display: block;
        margin: 10px auto;
        height: 40px;
        border-radius: 5px !important;
        background-color: #4ab6a4;
        border: 1px solid #4ab6a4 !important;

        &:hover {
          background-color: #fff !important;
          color: #4ab6a4;
        }
      }
    }
  }
</style>