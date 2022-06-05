export const YS_GROUP_ID = document.getElementById('group_posts').dataset.groupId;
export const BASE_REST_URL = window.ys_group_config.rest_url;
export const YS_GROUP_TEXT_DOMAIN = window.ys_group_config.text_domain;
export const YS_GROUP_GET_POSTS_ENDPOINT = BASE_REST_URL + 'ys-group/v1/posts?_ys_group_id_meta_key=' + YS_GROUP_ID;
export const YS_GROUP_CREATE_POST_ENDPONT = BASE_REST_URL + 'ys-group/v1/posts/create';
export const YOOSTART_USER = window.ys_group_config.yoostart_user;
export const WP_USER = window.ys_group_config.wp_user;
export const YS_GROUP_JWT = window.ys_group_config._ys_group_jwt;