import { __ } from '@wordpress/i18n';
import { YS_GROUP_TEXT_DOMAIN } from '../../../constants/constants';

export default function TextInput ({ handleChange, inputs }) {
  return (
    <input
      type="text"
      name="youtube_url"
      className="ys-group-post-featured-video-file"
      placeholder={__('Youtube video URL', YS_GROUP_TEXT_DOMAIN)}
      value={inputs.youtube_url}
      onChange={handleChange}
    />
  );
}