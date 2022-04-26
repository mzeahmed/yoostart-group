import { __ } from '@wordpress/i18n';
import { YS_GROUP_TEXT_DOMAIN } from '../../constants/constatnts';

export default function NewPostFormModal () {
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
          <div className="modal-body">
            <form action="">
              <div className="modal-post-head"></div>
              <div className="modal-post-content">
                <div className="form-group">
                  <textarea className="form-control" name="" id="" rows="10" is="textarea-autogrow"></textarea>
                </div>
              </div>
              <div className="modal-post-featured-medias">
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
            </form>
          </div>
          <div className="modal-footer">
            <button type="button" className="btn btn-primary">
              {__('Publish', YS_GROUP_TEXT_DOMAIN)}
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}