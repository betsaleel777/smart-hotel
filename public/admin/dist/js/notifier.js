$(function() {
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000
  });

  $(function() {
    const elt = document.getElementById('message');
    if (elt) {
        const message = elt.getElementsByTagName('span')[0].textContent
        const type = elt.getElementsByTagName('em')[0].textContent

        if (message) {
          Toast.fire({
            type: type,
            title: message
          })
     }
   }
  });
});
