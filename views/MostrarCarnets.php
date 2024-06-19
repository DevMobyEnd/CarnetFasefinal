<!-- Contenido de carnet_template.php -->
<div class='carnet d-flex justify-content-center align-items-center' style='height: 100vh;'>
    <div class='card' id='carnet-template' style='width: 28rem; height: 36rem; position: relative;'>
        <img src='../Public/dist/img/2.jpg' class='card-img-top img-fluid' alt='Imagen'
            style='object-fit: cover; width: 100%; height: 100%; min-height: 100%;'>
        <div class='card-body d-flex flex-column justify-content-center align-items-center'
            style='position: absolute; top: 36%; left: 50%; transform: translate(-50%, -50%);'>
            <img class='img-fluid' id='imagen-aprendiz' src='../Public/dist/img/usuario.png' alt='' style='width: 180px;'>
            <h5 style='margin-top: 20px; text-align: center;'><span id='nombre-aprendiz'></span></h5>
            <p style='text-align: center;'><span id='documento-aprendiz'></span></p>
        </div>
        <img class='img-fluid' src='../Public/dist/img/L.svg' alt=''
            style='position: absolute; top: -50px; left: -40px; width: 190px;'>
        <div
            style='position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); padding: 10px; background-color: rgba(0, 0, 255, 0.1);'>
            <img class='img-fluid' src='../Public/dist/img/codigo-qr.png' alt=''
                style='width: 120px; height: 120px;'>
        </div>
    </div>
</div>
