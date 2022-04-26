import { __ } from '@wordpress/i18n';

const { useState } = wp.element;

export default function Content ({ content }) {
  const [showMore, setShowMore] = useState(false);

  if (content.length < 150) {
    return (
      <div className="content" key={content}>{content}</div>
    );
  } else {
    return (
      <>
        <div className="content" key={content}>{showMore ? content : `${content.substring(0, 150)}` + ` ...`}</div>

        <button
          className="read-more"
          onClick={() => setShowMore(!showMore)}>
          {showMore ? __('Read less', 'yoostartwp-groups') : __('Read more', 'yoostartwp-groups')}
        </button>
      </>
    );
  }
}