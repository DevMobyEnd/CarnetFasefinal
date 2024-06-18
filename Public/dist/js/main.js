document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.btnGenerarPNG').forEach(function(btn) {
      btn.addEventListener('click', function() {
          let carnetId = this.getAttribute('data-carnet-id');
          html2canvas(document.querySelector('#' + carnetId), { scale: 3 }).then(canvas => {
              let enlace = document.createElement('a');
              enlace.download = carnetId + '.png';
              enlace.href = canvas.toDataURL();
              enlace.click();
          });
      });
  });
});