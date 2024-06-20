<?php
require_once './Models/CarnetModelo.php'; // Asumiendo que tienes un archivo Modelo.php que maneja las operaciones de la base de datos

class CarnetController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CarnetModelo();
    }

    public function mostrarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            $datosPersonales = $this->modelo->obtenerDatosPersonales();
            require_once './views/MostrarFormulario.php'; // Archivo de vista que muestra el formulario y la tabla de datos
        } else {
            $this->procesarFormulario();
        }
    }

    public function procesarFormulario() {
        if (!empty($_POST['aprendices'])) {
            $aprendicesSeleccionados = array_unique($_POST['aprendices']);
            $datosAprendices = $this->modelo->obtenerDatosAprendices($aprendicesSeleccionados);

            // Suponiendo que tienes un método generarImagenesPNG() que toma los datos de los aprendices,
            // genera una imagen PNG para cada uno, y devuelve un array de rutas de imágenes.
            $rutasImagenes = $this->generarImagenesPNG($datosAprendices);

            // Pasas $rutasImagenes a tu vista para que pueda generar enlaces de descarga.
            require_once './views/MostrarCarnets.php';
        } else {
            echo "Por favor, seleccione al menos un aprendiz.";
        }
    }
    private function generarImagenesPNG($datosAprendices) {
        $rutasImagenes = [];
        foreach ($datosAprendices as $aprendiz) {
            // Genera el código QR
            $datosQR = $aprendiz['documento']; // Aquí puedes ajustar los datos que quieras codificar
            $rutaQR = $this->generarCodigoQR($datosQR);
    
            // Define la ruta donde se guardará la imagen del carnet
            $rutaImagenCarnet = "ruta/a/imagenes/{$aprendiz['documento']}.png";
    
            // Aquí iría el código para generar la imagen del carnet, incluyendo el código QR
            // Esto dependerá de la biblioteca que estés usando (GD, Imagick, etc.)
            // Por ejemplo, podrías cargar una plantilla de carnet, dibujar los datos del aprendiz y el código QR, y guardar el resultado
    
            // Añade la ruta de la imagen del carnet generada al array de rutas
            $rutasImagenes[] = $rutaImagenCarnet;
        }
        return $rutasImagenes;
    }
    
    private function generarCodigoQR($datos) {
        // Importa las clases necesarias de la biblioteca
        $qrCode = new \Endroid\QrCode\QrCode($datos);
    
        // Puedes ajustar varios parámetros del código QR aquí, como el tamaño
        $qrCode->setSize(300);
    
        // Crea una instancia del escritor deseado, por ejemplo, para guardar como PNG
        $writer = new \Endroid\QrCode\Writer\PngWriter();
    
        // Define la ruta donde se guardará el código QR generado
        $rutaArchivoQR = "ruta/a/codigosQR/{$datos}.png";
    
        // Guarda el código QR en la ruta especificada usando el escritor
        $result = $writer->write($qrCode);
        file_put_contents($rutaArchivoQR, $result->getString());
    
        // Devuelve la ruta del archivo QR generado
        return $rutaArchivoQR;
    }
}
?>