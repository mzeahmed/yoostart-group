import { __ } from '@wordpress/i18n';
import {
  YOOSTART_USER,
  YS_GROUP_CREATE_POST_ENDPONT,
  YS_GROUP_GET_POSTS_ENDPOINT,
  YS_GROUP_ID,
  YS_GROUP_JWT,
  YS_GROUP_TEXT_DOMAIN,
} from '../constants/constants';

/**
 * Récuperation des publications
 *
 * @returns {Promise<*[]|any>}
 * @since 1.2.5
 */
export async function getPosts () {
  return fetch(YS_GROUP_GET_POSTS_ENDPOINT, {
    headers: {
      'Authorization': ` Bearer ${YS_GROUP_JWT}`,
    },
  })
  // .then((res) => {
  //   if (! res.ok) {
  //     throw Error(__('Could not fetch the data for that resource', YS_GROUP_TEXT_DOMAIN));
  //   }
  //   return res.json();
  // });
}

/**
 * Création d'une publication
 *
 * @returns {Promise<any>}
 * @param post
 */
export async function createPost (post) {
  return fetch(YS_GROUP_CREATE_POST_ENDPONT, {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
      'accept': 'application/json',
      'Authorization': `Bearer ${YS_GROUP_JWT}`,
    },

    body: JSON.stringify({
      post_content: post,
      post_author: YOOSTART_USER['id'],
      group_id: YS_GROUP_ID,
    }),
  }).then((response) => {
    return response.json();
  });
}

/**
 * @param post
 * @returns {Promise<*>}
 */
export function savePost (post) {
  return post.id ?? createPost(post);
}