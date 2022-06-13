import {
  YOOSTART_USER,
  YS_GROUP_CREATE_POST_ENDPONT,
  YS_GROUP_GET_POSTS_ENDPOINT,
  YS_GROUP_ID,
  YS_GROUP_JWT,
} from '../constants/constants';

/**
 * Récuperation des publications
 *
 * @returns {Promise<*[]|any>}
 * @since 1.2.5
 */
export async function getPosts () {
  return fetch(YS_GROUP_GET_POSTS_ENDPOINT + `&per_page=5`, {
    headers: {
      'Authorization': ` Bearer ${YS_GROUP_JWT}`,
    },
  });
}

export async function getNextPosts () {
  return fetch(YS_GROUP_GET_POSTS_ENDPOINT + `&per_page=1`, {
    headers: {
      'Authorization': ` Bearer ${YS_GROUP_JWT}`,
    },
  });
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