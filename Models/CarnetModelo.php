<?php
require_once './Config/conexion.php'; // Asegúrate de que la ruta al archivo sea correcta

class CarnetModelo extends Conexion {
    
    public function obtenerDatosPersonales() {
        $sql = "SELECT documento, aprendiz, celular, correo_electronico, estado, soy_sena FROM datos_personales";
        $resultado = $this->obtenerConexion()->query($sql);
        $datosPersonales = [];
        
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                $datosPersonales[] = $row;
            }
        }
        
        return $datosPersonales;
    }

    public function obtenerDatosAprendices($aprendicesSeleccionados) {
        $datosAprendices = [];
        $conexion = $this->obtenerConexion();
        foreach ($aprendicesSeleccionados as $documento) {
            $sql = "SELECT documento, aprendiz, celular, correo_electronico, estado, soy_sena FROM datos_personales WHERE documento = ?";
            $stmt = $conexion->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $documento); // "s" indica que $documento es una cadena (string)
                $stmt->execute();
                $resultado = $stmt->get_result();
                if ($resultado && $resultado->num_rows > 0) {
                    $datosAprendices[] = $resultado->fetch_assoc();
                }
                $stmt->close();
            }
        }
        return $datosAprendices;
    }
}
?>