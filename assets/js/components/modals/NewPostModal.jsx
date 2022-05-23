import { __ } from '@wordpress/i18n';
import { useState } from 'react';
import { Button, Modal } from 'react-bootstrap';
import { CURRENT_USER, YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

const currentUser = window.ys_group_config.current_user;

export default function NewPostModal () {
  const [inputs, setInputs] = useState({});
  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  const handleChange = (event) => {
    const content = event.target.name;
    const value = event.target.value;

    setInputs((values) => ({
      ...values,
      [content]: value
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    console.log(JSON.stringify(inputs.content));
  };

  return (
    <>
      <Button className="post-input-button" variant="light" onClick={handleShow}>
        {__(
          currentUser.firstname + ' share your service offers or submit an issue to the community',
          'yoostartwp-groups')
        }
      </Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>Modal heading</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          <form onSubmit={handleSubmit}>
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

            <hr/>

            <Button type="submit" variant="primary" onClick={() => setTimeout(handleClose, 3000)}>
              {__('Publish', YS_GROUP_TEXT_DOMAIN)}
            </Button>
          </form>
        </Modal.Body>
      </Modal>
    </>
  );
}