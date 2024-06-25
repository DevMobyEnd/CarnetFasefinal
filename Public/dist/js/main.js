document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btnGenerarPNG').forEach(function(btn) {
        btn.addEventListener('click', function() {
            let carnetId = this.getAttribute('data-carnet-id');
            let carnetElement = document.querySelector('#' + carnetId);

            // Crea un contenedor alrededor del carnetElement para aplicar el margen
            let contenedor = document.createElement('div');
            contenedor.style.padding = '-5px'; // Esto actúa como un margen para carnetElement
            contenedor.style.backgroundColor = 'white'; // Fondo blanco para el contenedor
            carnetElement.parentNode.insertBefore(contenedor, carnetElement);
            contenedor.appendChild(carnetElement);

            html2canvas(contenedor, { scale: 3 }).then(canvas => {
                let enlace = document.createElement('a');
                enlace.download = carnetId + '.png';
                enlace.href = canvas.toDataURL();
                enlace.click();

                // Mueve el carnetElement fuera del contenedor para revertir la estructura del DOM
                contenedor.parentNode.insertBefore(carnetElement, contenedor);
                contenedor.parentNode.removeChild(contenedor);
            });
        });
    });
});