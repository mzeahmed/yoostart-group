import { YS_GROUP_TEXT_DOMAIN } from '../../../../constants/constatnts'
import { __ } from '@wordpress/i18n'

export default function Reacts () {
  return (
    <div className="post-reacts d-flex">
      <div className="like">
        <i className="far fa-heart"></i>
        <span className="like-text">{__('Like', YS_GROUP_TEXT_DOMAIN)}</span>
      </div>
      <div className="comment">
        <i className="far fa-comment-alt"></i>
        <span className="comment-text">{__('Comment', YS_GROUP_TEXT_DOMAIN)}</span>
      </div>
    </div>
  )
}