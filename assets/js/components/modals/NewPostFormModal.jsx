import { __ } from '@wordpress/i18n';
import { CURRENT_USER, YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

const { useState } = wp.element;

export default function NewPostFormModal () {
  const [inputs, setInputs] = useState({});

  let handleChange = (event) => {
    const content = event.target.name;
    const value = event.target.value;

    setInputs((values) => ({
      ...values,
      [content]: value
    }));
  };

  let handleSubmit = async (e) => {
    e.preventDefault();

    console.log(inputs);

    // fetch(YS_GROUP_CREATE_POST_ENDPONT, {
    //   method: 'POST',
    //   body: JSON.stringify({
    //     content: content
    //   })
    // })
    //   .then((res) => {
    //     res.json();
    //   })
    //   .then((result) => {
    //     console.log(result);
    //     setContent('');
    //   });
  };

  return (
    <div className="modal fade" id="newPostFormModal" tabIndex="-1" role="dialog"
         aria-labelledby="newPostFormModalLabel" aria-hidden="true">
      <div className="modal-dialog" role="document">
        <div className="modal-content">
          <div className="modal-header">
            <h5 className="modal-title" id="newPostFormModaLabel">{__('Publish post', YS_GROUP_TEXT_DOMAIN)}</h5>
            <button type="button" className="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form onSubmit={handleSubmit}>
            <div className="modal-body">
              <div className="modal-post-head"></div>
              <div className="modal-post-content">
                <div className="form-group">
                  <textarea
                    className="form-control"
                    name="content"
                    value={inputs.content}
                    placeholder={CURRENT_USER['firstname'] + ' ' + __('publish something', YS_GROUP_TEXT_DOMAIN)}
                    onChange={handleChange}
                    is="textarea-autogrow"
                  ></textarea>
                </div>
              </div>

              <PostFeaturedMedias handleChange={handleChange} inputs={inputs}/>
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