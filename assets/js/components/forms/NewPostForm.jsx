import NewPostModal from '../modals/NewPostModal';

const currentUser = window.ys_group_config.current_user;

export default function NewPostForm () {
  return (
    <div className="ys-group-new-post-form" id="ys_group_post_form">
      <div className="row">
        <div className="col-md-2 user-avatar">
          <div className="avatar">
            <a href={currentUser.profile_url}><img src={currentUser.avatar_image} alt=""/></a>
          </div>
        </div>
        <div className="col-md-10 post-input">
          <NewPostModal/>
        </div>
      </div>
    </div>
  );
}