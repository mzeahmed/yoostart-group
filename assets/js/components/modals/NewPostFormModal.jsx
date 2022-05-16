import { __ } from '@wordpress/i18n';
import { YS_GROUP_CREATE_POST_ENDPONT, YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

const { useState, useRef } = wp.element;

export default function NewPostFormModal () {
  const [textarea, setTextarea] = useState(__('Post something', YS_GROUP_TEXT_DOMAIN));
  const [content, setContent] = useState('');
  const form = useRef(null);

  let handleChange = (event) => {
    setTextarea(event.target.value);
  };

  let handleSubmit = async (e) => {
    e.preventDefault();

    // fetch
    const data = new FormData(form.current);
    fetch(YS_GROUP_CREATE_POST_ENDPONT, {
      method: 'POST',
      body: data
    })
      .then((res) => {
        res.json();
      })
      .then((result) => {
        setContent(result.content);
      });
  };

  return (
    <div className="modal fade" id="newPostFormModal" tabIndex="-1" role="dialog"
         aria-labelledby="newPostFormModalLabel" aria-hidden="true">
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title" id="exampleModalLabel">{__('Publish post', YS_GROUP_TEXT_DOMAIN)}</h5>
            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form ref={form} onSubmit={handleSubmit}>
            <div className="modal-body">
              <div className="modal-post-head"></div>
              <div className="modal-post-content">
                <div className="form-group">
                  <textarea
                    className="form-control"
                    placeholder={textarea}
                    onChange={handleChange}
                    is="textarea-autogrow"
                  ></textarea>
                </div>
              </div>

              <PostFeaturedMedias/>
            </div>

            <div className="modal-footer">
              <button type="submit" className="btn btn-primary">
                {__('Publish', YS_GROUP_TEXT_DOMAIN)}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}