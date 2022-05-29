import { CURRENT_USER } from '../../constants/constants';
import NewPostModal from '../modals/NewPostModal';

export default function NewPostForm () {
  return (
    <div className="ys-group-new-post-form" id="ys_group_post_form">
      <div className="row">
        <div className="col-md-2 user-avatar">
          <div className="avatar">
            <a href={CURRENT_USER['profile_url']}><img src={CURRENT_USER['avatar_image']} alt=""/></a>
          </div>
        </div>
        <div className="col-md-10 ys-group-post-input">
          <NewPostModal/>
        </div>
      </div>
    </div>
  );
}