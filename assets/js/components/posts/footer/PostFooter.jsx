import { __ } from '@wordpress/i18n';
import { YS_GROUP_TEXT_DOMAIN } from '../../../constants/constants';
import Comment from './parts/Comment';
// import { useState } from 'react';

const { useState } = wp.element;

export default function PostFooter ({ postId }) {
  const [isShowed, setIsSohwed] = useState(false);

  const handleClick = () => {
    setIsSohwed((currentIsShowed) => !currentIsShowed);
  };

  let form;

  if (isShowed) {
    form = Comment({ postId });
  }

  return (
    <div className="ys-group-post-footer">
      <div className="post-activities">
        <div className="likes">
          <i className="fas fa-heart"></i>
        </div>
      </div>

      <div className="post-reacts d-flex">
        <div className="like">
          <i className="far fa-heart"></i>
          <span className="like-text">{__('Like', YS_GROUP_TEXT_DOMAIN)}</span>
        </div>
        <div className="comment">
          <i className="far fa-comment-alt"></i>
          <span className="comment-text" onClick={handleClick}>{__('Comment', YS_GROUP_TEXT_DOMAIN)}</span>
        </div>
      </div>

      {form}
    </div>
  );
}