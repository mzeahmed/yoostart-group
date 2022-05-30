import { __ } from '@wordpress/i18n';
import { useState } from 'react';
import { Button, Modal } from 'react-bootstrap';
import {
  YOOSTART_USER,
  YS_GROUP_CREATE_POST_ENDPONT,
  YS_GROUP_ID,
  YS_GROUP_JWT,
  YS_GROUP_TEXT_DOMAIN
} from '../../constants/constants';
import PostFeaturedMedias from '../FeaturedMedias/PostFeaturedMedias';

export default function NewPostModal () {

  // console.log(YS_GROUP_ID);

  const [formData, setFormData] = useState({});
  const [show, setShow] = useState(false);

  const [submitting, setSubmitting] = useState(false);

  async function handleSubmit (event) {
    event.preventDefault();
    setSubmitting(true);

    fetch(YS_GROUP_CREATE_POST_ENDPONT, {
      method: 'post',
      headers: {
        'Content-Type': 'application/json',
        'accept': 'application/json',
        'Authorization': `Bearer ${YS_GROUP_JWT}`,
      },

      body: JSON.stringify({
        post_content: formData.post_content,
        post_author: YOOSTART_USER['id'],
        group_id: YS_GROUP_ID
      })
    })
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        console.log(data);
      });

    setTimeout(() => {
      setSubmitting(false);
    }, 2000);
  }

  /** Enlevement du modal*/
  const handleClose = () => setShow(false);

  /** Affichage du modal */
  const handleShow = () => setShow(true);

  const handleChange = (event) => {
    const post_content = event.target.name;
    const value = event.target.value;

    setFormData((values) => ({
      ...values,
      [post_content]: value
    }));
  };

  return (
    <>
      <Button className="post-input-button" variant="light" onClick={handleShow}>
        {__(
          YOOSTART_USER['firstname'] + ' share your service offers or submit an issue to the community',
          'yoostartwp-groups')
        }
      </Button>

      <Modal className="ys-group-post-modal" show={show} onHide={handleClose}>
        <Modal.Header>
          <Modal.Title>{__('Publish post', YS_GROUP_TEXT_DOMAIN)}</Modal.Title>
          <button type="button" className="close" onClick={handleClose}>&times;</button>
        </Modal.Header>

        {submitting && <span className="ys-group-submitting-loader"></span>}

        <Modal.Body>
          <form onSubmit={handleSubmit}>
            <div className="modal-post-head"></div>
            <div className="modal-post-content">
              <div className="form-group">
                  <textarea
                    className="form-control"
                    name="post_content"
                    placeholder={YOOSTART_USER['firstname'] + ' ' + __('publish something', YS_GROUP_TEXT_DOMAIN)}
                    onChange={handleChange}
                    is="textarea-autogrow"
                  ></textarea>
              </div>
            </div>

            <PostFeaturedMedias handleChange={handleChange} formDatas={formData}/>

            <hr/>

            <Button type="submit" variant="primary" onClick={() => setTimeout(handleClose, 2000)}>
              {__('Publish', YS_GROUP_TEXT_DOMAIN)}
            </Button>
          </form>
        </Modal.Body>
      </Modal>
    </>
  );
}