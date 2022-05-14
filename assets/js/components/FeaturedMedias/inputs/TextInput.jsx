import { __ } from '@wordpress/i18n'
import { YS_GROUP_TEXT_DOMAIN } from '../../../constants/constatnts'

export default function TextInput () {
  return (
    <input type="text" className="ys-group-post-featured-video-file" placeholder={
      __('Youtube video URL', YS_GROUP_TEXT_DOMAIN)
    }/>
  )
}