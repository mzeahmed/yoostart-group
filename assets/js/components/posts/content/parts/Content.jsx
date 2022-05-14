import { __ } from '@wordpress/i18n'
import { YS_GROUP_TEXT_DOMAIN } from '../../../../constants/constatnts'

const { useState } = wp.element

export default function Content ({ content }) {
  const [showMore, setShowMore] = useState(false)

  if (content.length < 150) {
    return (
      <div className="content">{content}</div>
    )
  } else {
    return (
      <>
        <div className="content">{showMore ? content : `${content.substring(0, 150)}` + ` ...`}</div>

        <button
          className="read-more"
          onClick={() => setShowMore(!showMore)}>
          {showMore ? __('Read less', YS_GROUP_TEXT_DOMAIN) : __('Read more', YS_GROUP_TEXT_DOMAIN)}
        </button>
      </>
    )
  }
}