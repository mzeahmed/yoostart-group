import { __ } from '@wordpress/i18n';
import NewPostFormModal from '../modals/NewPostFormModal';
// import { useState } from 'react';

const currentUser = window.ys_group_config.current_user;

const { useState } = wp.element;

export default function NewPostForm ({ currentUserAvatarUrl, currentUserProfilUrl, currentUserFirstname }) {
  return (
    <div className="ys-group-new-post-form" id="ys_group_post_form">
      <div className="row">
        <div className="col-md-2 user-avatar">
          <div className="avatar">
            <a href={currentUser.profile_url}><img src={currentUser.avatar_image} alt=""/></a>
          </div>
        </div>
        <div className="col-md-10 post-input">
          <div className="post-input-button" data-toggle="modal" data-target="#newPostFormModal">
            {__(
              currentUser.firstname + ' share your service offers or submit an issue to the community',
              'yoostartwp-groups')
            }
          </div>

          <NewPostFormModal/>
        </div>
      </div>
    </div>
  );
}