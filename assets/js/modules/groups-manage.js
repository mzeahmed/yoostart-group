export default function fileUploadHandler () {
  let button = document.querySelector('button.ys-group-update-cover');
  let form = document.getElementById('ys-group-cover-form');

  const data = new FormData();

  data.append('_cover_nonce', ys_group_ajaxurl._cover_nonce);
  data.append('action', 'ajaxFileUploadHandler');

  button.addEventListener('click', async function (e) {
    e.preventDefault();

    await fetch(ys_group_ajaxurl.ajax_url, {
      method: 'POST',
      credentials: 'same-origin',
      // headers: {
      //   'Content-type': 'application/x-www-form-urlencoded'
      // },
      body: data
    })
      .then((response) => response.json())
      .then((data) => {
        let parsed = JSON.parse(data);
        console.log(parsed);
        // resetFormData(form);
      })
      .catch((error) => console.log(error));
  });
}

function resetFormData (form) {
  document.querySelector(form).reset();
}