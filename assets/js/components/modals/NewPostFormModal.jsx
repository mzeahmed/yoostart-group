import { __ } from '@wordpress/i18n';
import { useState } from 'react';
import { Button, Modal } from 'react-bootstrap';
import { CURRENT_USER, YS_GROUP_TEXT_DOMAIN } from '../../constants/constants';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

export default function NewPostFormModal ({ handleClose, show }) {
  const [inputs, setInputs] = useState({});
  // const [show, setShow] = useState(false);
  //
  // const handleClose = () => setShow(false);
  // const handleShow = () => setShow(true);

  // const handleCloseModal = () => {
  //   // let formModal = new bootstrap.Modal(document.getElementById('newPostFormModal'));
  //   let formModal = new BSN.Modal(
  //     '#newPostFormModal',
  //     {
  //       backdrop: 'static',
  //       keyboard: false
  //     }
  //   );
  //
  //   formModal.hide();
  //
  //   // let formModal = document.getElementById('newPostFormModal');
  //   // let modalBackDrop = document.querySelector('.modal-backdrop.fade');
  //
  //   // formModal.style.display = 'none';
  //   // modalBackDrop.style.display = 'none';
  // };

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

    /** attendre 7ms avant de fermer la popup */
    // setTimeout(handleCloseModal, 700);
  };

  return (
    <Modal show={show} onHide={handleClose}>
      <Modal.Dialog>
        <div className="modal-content">
          <Modal.Header closeButton>
            <Modal.Title>{__('Publish post', YS_GROUP_TEXT_DOMAIN)}</Modal.Title>
          </Modal.Header>
            <Modal.Body className="modal-body">
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
          </form>
            </Modal.Body>

            <Modal.Footer>
              <Button type="submit" variant="primary" onClick={handleClose}>
                {__('Publish', YS_GROUP_TEXT_DOMAIN)}
              </Button>
            </Modal.Footer>
        </div>
      </Modal.Dialog>
    </Modal>
  );
}