<?php
require_once './Models/CarnetModelo.php'; // Asegúrate de que la ruta al archivo del modelo sea correcta

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
    
            $rutasImagenes = $this->generarImagenesPNG($datosAprendices);
    
            if (count($rutasImagenes) > 0) {
                $zip = new ZipArchive();
                $nombreArchivoZip = "carnets.zip";
    
                if ($zip->open($nombreArchivoZip, ZipArchive::CREATE) === TRUE) {
                    foreach ($rutasImagenes as $ruta) {
                        if (file_exists($ruta)) {
                            $zip->addFile($ruta, basename($ruta));
                        }
                    }
                    $zip->close();
    
                    if (file_exists($nombreArchivoZip)) {
                        // Enviar el archivo ZIP para descarga
                        header('Content-Type: application/zip');
                        header('Content-Disposition: attachment; filename="'.basename($nombreArchivoZip).'"');
                        header('Content-Length: ' . filesize($nombreArchivoZip));
                        flush();
                        readfile($nombreArchivoZip);
    
                        // Eliminar el archivo ZIP después de la descarga
                        unlink($nombreArchivoZip);
    
                        // Eliminar las imágenes temporales generadas
                        foreach ($rutasImagenes as $ruta) {
                            unlink($ruta);
                        }
                        exit;
                    } else {
                        echo "No se pudo crear el archivo ZIP.";
                    }
                } else {
                    echo "No se pudo abrir el archivo ZIP.";
                }
            } else {
                echo "No se generaron imágenes para los aprendices seleccionados.";
            }
        } else {
            echo "Por favor, seleccione al menos un aprendiz.";
        }
    }
    

    private function generarImagenesPNG($datosAprendices) {
        $rutasImagenes = [];
        $directorioImagenes = 'ruta/a/imagenes/'; // Define el directorio donde se guardarán las imágenes
    
        // Verifica si el directorio existe, si no, intenta crearlo
        if (!is_dir($directorioImagenes)) {
            mkdir($directorioImagenes, 0777, true);
        }
    
        // Itera sobre cada aprendiz para generar su carnet
        foreach ($datosAprendices as $aprendiz) {
            $nombreAprendiz = htmlspecialchars($aprendiz['aprendiz']);
            $documentoAprendiz = htmlspecialchars($aprendiz['documento']);
            $rutaImagen = $directorioImagenes . "{$documentoAprendiz}.png";
    
            // Carga el boseto HTML del carnet
            ob_start();
            include('../views/MostrarCarnets.php'); // Ajusta la ruta según tu estructura de archivos
            $html = ob_get_clean();
    
            // Crea una nueva imagen
            $imagen = imagecreatetruecolor(800, 600); // Ajusta el tamaño según tus necesidades
    
            // Crea una imagen desde el HTML renderizado
            $this->htmlToImage($html, $imagen);
    
            // Guarda la imagen en formato PNG en la ruta especificada
            if (imagepng($imagen, $rutaImagen)) {
                $rutasImagenes[] = $rutaImagen; // Añade la ruta de la imagen generada al array de rutas
            } else {
                echo "Error al guardar la imagen para el documento: {$documentoAprendiz}<br>";
            }
    
            imagedestroy($imagen); // Libera la memoria asociada con la imagen
        }
    
        return $rutasImagenes;
    }
    
    // Método para convertir HTML a imagen
    private function htmlToImage($html, &$imagen) {
        // Crea una nueva instancia de DOMDocument
        $dom = new DOMDocument();
        $dom->loadHTML($html);
    
        // Inicializa la clase Imagick
        $image = new Imagick();
        $image->setBackgroundColor(new ImagickPixel('transparent'));
    
        // Renderiza el HTML a una imagen
        $image->readImageBlob($dom->saveHTML());
    }
    
    
    
}
?>
