<?php
require_once 'vendor/autoload.php';
require_once './Models/CarnetModelo.php';

class CarnetController {
    private $modelo;

    public function __construct() {
        $this->modelo = new CarnetModelo();
    }

    public function mostrarFormulario() {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            // Obtiene los datos personales y muestra el formulario
            $datosPersonales = $this->modelo->obtenerDatosPersonales();
            require_once './views/MostrarFormulario.php';
        } else {
            // Procesa el formulario cuando se envía
            $this->procesarFormulario();
        }
    }

    public function procesarFormulario() {
        if (!empty($_POST['aprendices'])) {
            // Obtiene los documentos de los aprendices seleccionados
            $aprendicesSeleccionados = array_unique($_POST['aprendices']);
            // Obtiene los datos de los aprendices desde la base de datos
            $datosAprendices = $this->modelo->obtenerDatosAprendices($aprendicesSeleccionados);

            // Genera las imágenes PNG y códigos QR para cada aprendiz
            $datosAprendicesConRutas = $this->generarImagenesPNG($datosAprendices);

            // Pasa los datos a la vista para mostrar los carnets
            require_once './views/MostrarCarnets.php';
        } else {
            echo "Por favor, seleccione al menos un aprendiz.";
        }
    }

    private function generarImagenesPNG($datosAprendices) {
        foreach ($datosAprendices as &$aprendiz) {
            // Genera el código QR y obtiene la ruta
            $aprendiz['rutaCodigoQR'] = $this->generarCodigoQR($aprendiz['documento']);
        }
        unset($aprendiz); // Rompe la referencia con el último elemento

        return $datosAprendices;
    }

    private function generarCodigoQR($datos) {
        $qrCode = new \Endroid\QrCode\QrCode($datos);
        $qrCode->setSize(300);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $rutaDirectorioQR = "ruta/a/codigosQR/";
        $rutaArchivoQR = $rutaDirectorioQR . "{$datos}.png";

        if (!file_exists($rutaDirectorioQR)) {
            mkdir($rutaDirectorioQR, 0755, true);
        }

        $result = $writer->write($qrCode);
        file_put_contents($rutaArchivoQR, $result->getString());

        return $rutaArchivoQR;
    }
}
?>
