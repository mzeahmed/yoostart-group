import TextInput from './inputs/TextInput';
import FileInput from './inputs/FileInput';

const { useState } = wp.element;

export default function PostFeaturedMedias () {
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
    fileInput = FileInput();
  } else if (isText) {
    textInput = TextInput();
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