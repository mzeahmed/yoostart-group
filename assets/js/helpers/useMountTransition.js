const { useState, useEffect } = wp.element;

export default function useMountTransition (isMounted, unmountDelay) {
  const [hasTransionedIn, setHasTransionedtIn] = useState(false);

  useEffect(() => {
    let timeoutId;

    if (isMounted && !hasTransionedIn) {
      setHasTransionedtIn(true);
    } else if (!isMounted && hasTransionedIn) {
      timeoutId = setTimeout(() => {
        setHasTransionedtIn(false);
      }, unmountDelay);
    }

    return () => {
      clearTimeout(timeoutId);
    };
  }, [unmountDelay, isMounted, hasTransionedIn]);

  return hasTransionedIn;
}