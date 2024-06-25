<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carnets Generados</title>
    <link rel="stylesheet" href="./Public/dist/css/estilo.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Carnets Generados</h2>
        <?php
        if (!empty($datosAprendicesConRutas)) {
            foreach ($datosAprendicesConRutas as $aprendiz) {
                $nombreAprendiz = htmlspecialchars($aprendiz["aprendiz"]);
                $documentoAprendiz = htmlspecialchars($aprendiz["documento"]);
                $correoElectronico = htmlspecialchars($aprendiz["correo_electronico"]);
                $carnetId = "carnet-" . $documentoAprendiz;
                $rutaCodigoQR = isset($aprendiz['rutaCodigoQR']) ? $aprendiz['rutaCodigoQR'] : 'ruta/a/imagen/por/defecto.png';
                echo "<div class='carnet d-flex justify-content-center align-items-center' style='height: 100vh;'>
                        <div class='card' id='$carnetId' style='width: 28rem; height: 36rem; position: relative; margin: 20px; border: 0.5px solid #000; border-radius: 11px;'>
                            <img src='./Public/dist/img/3.jpg' class='card-img-top img-fluid' alt='Imagen' style='object-fit: cover; width: 100%; height: 100%; min-height: 100%; overflow: hidden;border-radius: 11px;'>
                            <div class='card-body d-flex flex-column justify-content-center align-items-center' style='position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%);'>
                            <img class='img-fluid' src='./Public/dist/img/usuario.png' alt='' style='width: 140px;  position: relative; top: 15px;'>
                            <h5 style=' position: relative; top: 15px; text-align: center;'><span>$nombreAprendiz</span></h5>
                            <p style=' position: relative; top: 15px; text-align: center;'><span>$documentoAprendiz</span></p>
                        </div>
                           <img class='img-fluid' src='./Public/dist/img/12.png' alt='' style='position: absolute; top: 5px; left: 10px; width: 100px;'>
                           <p style='position: absolute; top: 110px; left: 12px; font-size: 12px; color: #ff6719; font-weight: bold;'>Regional Guaviare</p>
                            <div style='position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: rgba(255, 159, 64, 0.4);'>
                                <img class='img-fluid' src='$rutaCodigoQR' alt='' style='width: 140px; height: 140px;'>
                            </div>
                        </div>
                        <button class='btn btn-primary btnGenerarPNG' data-carnet-id='$carnetId'>Generar PNG del Carnet</button>
                        <button class='btn btn-success btnEnviarCorreo' data-correo='$correoElectronico' data-carnet-id='$carnetId'>Enviar por Correo</button>
                    </div>";
            }
        } else {
            echo "<p>No se han seleccionado aprendices para generar carnets.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="./Public/dist/js/main.js"></script>
    <script>
        document.querySelectorAll('.btnEnviarCorreo').forEach(button => {
            button.addEventListener('click', function() {
                let correo = this.getAttribute('data-correo');
                let carnetId = this.getAttribute('data-carnet-id');
                html2canvas(document.getElementById(carnetId)).then(canvas => {
                    let imgData = canvas.toDataURL('image/png');
                    fetch('PrubitasendEmail.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                correo: correo,
                                imagen: imgData
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la solicitud: ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            alert('Correo enviado exitosamente: ' + data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al enviar el correo: ' + error.message);
                        });
                }).catch(error => {
                    console.error('Error en html2canvas:', error);
                    alert('Error al capturar el carnet como imagen: ' + error.message);
                });
            });
        });
    </script>

</body>

</html>