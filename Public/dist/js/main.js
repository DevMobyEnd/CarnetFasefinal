$(document).ready(function() {
    $('#btn-generarPNG').click(function() {
      html2canvas(document.querySelector('#carnet'), {
        scale: 3 // Incrementar la escala para mejorar la resolución
      }).then(canvas => {
        // Crear un enlace para descargar la imagen
        var link = document.createElement('a');
        link.download = 'carnet.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
      });
    });
  });
