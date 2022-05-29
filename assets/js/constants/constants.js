export const YS_GROUP_ID = document.getElementById('group_posts').dataset.groupId;
const base_rest_url = window.ys_group_config.rest_url;

export const YS_GROUP_TEXT_DOMAIN = window.ys_group_config.text_domain;
export const YS_GROUP_POSTS_ENDPOINT = base_rest_url + 'ys-group/v1/posts?_ys_group_id_meta_key=' + YS_GROUP_ID;
export const YS_GROUP_CREATE_POST_ENDPONT = base_rest_url + 'ys-group/v1/posts/create';
export const CURRENT_USER = window.ys_group_config.current_user;