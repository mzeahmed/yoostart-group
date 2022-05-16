import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import { __ } from '@wordpress/i18n';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

export default function CommentFom ({ postId }) {
  return (
    <form action="" encType="multipart/form-data" id={`post_${postId}_comment_form`}>
      <textarea
        name={`text_post_${postId}`}
        id={`text_post_${postId}`}
        is="textarea-autogrow"
        placeholder={__('Your comment', YS_GROUP_TEXT_DOMAIN)}></textarea>

      <PostFeaturedMedias/>
    </form>
  );
}