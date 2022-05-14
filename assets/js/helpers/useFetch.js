const { useState, useEffect } = wp.element;

export default function useFetch (url) {
  const [data, setData] = useState(null);

  useEffect(() => {
    async function loadData () {
      const response = await fetch(url);

      if (!response.ok) {
        return;
      }

      const posts = await response.json();
      setData(posts);
    }

    loadData();
  }, [url]);

  return data;
}

export default function postData (url) {

}