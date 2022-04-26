const group_id = document.getElementById('group_posts').dataset.groupId;
const base_rest_url = window.ys_group_config.rest_url;
const groupPostsEndpoint = base_rest_url + 'ys-group/v1/posts?_ys_group_id_meta_key=' + group_id;

/**
 * Récuperation des publications
 * @returns {Promise<*[]|any>}
 * @since 1.2.5
 */
export async function getPosts () {
  try {
    const response = await fetch(groupPostsEndpoint);
    return await response.json();
  } catch (error) {
    return [];
  }
}

/**
 * création d'une publication
 * @param data
 * @returns {Promise<void>}
 */
export async function createPost (data) {

}