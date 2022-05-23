import { useState } from 'react';
import FileInput from './inputs/FileInput';
import TextInput from './inputs/TextInput';

export default function PostFeaturedMedias ({ handleChange, inputs }) {
  const [isFile, setIsFile] = useState(false);
  const [isText, setIsText] = useState(false);

  const [isFileInputActive, setIsFileIputActive] = useState(false);
  const [isTextInputActive, setIsTextIputActive] = useState(false);

  const fileHandleClick = () => {
    setIsFile((input) => !input);
    setIsText(false);

    setIsFileIputActive((active) => !active);
    setIsTextIputActive(false);
  };

  const textHandleClick = () => {
    setIsText((input) => !input);
    setIsFile(false);

    setIsTextIputActive((active) => !active);
    setIsFileIputActive(false);
  };

  let fileInput;
  let textInput;

  if (isFile) {
    fileInput = FileInput({ handleChange, inputs });
  } else if (isText) {
    textInput = TextInput({ handleChange, inputs });
  }

  return (
    <div className={`post-featured-medias 
      ${isFileInputActive ? 'file-input-active' : ''} 
      ${isTextInputActive ? 'text-input-active' : ''}`}
    >
      <div className="ys-group-featured-image">
        <span><i className="fas fa-image" onClick={fileHandleClick}></i></span>
        {fileInput}
      </div>
      <div className="ys-group-featured-video">
        <span><i className="fas fa-video" onClick={textHandleClick}></i></span>
        {textInput}
      </div>
    </div>
  );
}