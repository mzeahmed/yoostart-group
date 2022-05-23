const { useState } = wp.element;

const useModal = () => {
  const [isShowing, setIsShowing] = useState(false);

  function toggle () {
    setIsShowing(!isShowing);
  }

  return {
    isShowing,
    toggle
  };
};

export default useModal;