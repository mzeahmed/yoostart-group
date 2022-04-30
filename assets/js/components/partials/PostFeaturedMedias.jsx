import { __ } from '@wordpress/i18n'
import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constatnts'

export default function PostFeaturedMedias () {
  return (
    <div className="post-featured-medias">
      <div className="ys-group-featured-image">
        <span><i className="fas fa-image"></i></span>
        <input type="file" className="ys-group-post-featured-img-file"/>
      </div>
      <div className="ys-group-featured-video">
        <span><i className="fas fa-video"></i></span>
        <input type="text" className="ys-group-post-featured-video-file" placeholder={
          __('Youtube video URL', YS_GROUP_TEXT_DOMAIN)
        }/>
      </div>
    </div>
  )
}