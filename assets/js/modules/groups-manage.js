import Swal from 'sweetalert2'

function deleteGroupe (e) {
  e.preventDefault()

  const row = document.querySelector('.ys-group-list-row')
  const url = this.href

  Swal.fire({
    title: 'Êtes-vous sûre de vouloir supprimer ce groupe ?',
    text: '',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {

      Swal.fire(
        'Supprimé',
        'Le groupe à bien été supprimé',
        'success'
      )
    } else {
      fetch(url, {
        method: 'post'
      })
        .then((response) => response.json())
        .then((data) => console.log(data))
        .catch((error) => console.log(error))
    }
  })
}

export function handleClickDelete () {
  document.querySelectorAll('a.js-ys-group-delete').forEach((link) => {
    link.addEventListener('click', deleteGroupe)
  })
}
