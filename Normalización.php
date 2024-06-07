<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

// Ruta del archivo XLSX de entrada
$inputFileName = './L1_APRENDICES_2699192 3.xlsx';

// Cargar el archivo XLSX
$spreadsheet = IOFactory::load($inputFileName);

// Crear un escritor de CSV
$writer = new Csv($spreadsheet);

// Configurar el delimitador a punto y coma (;)
$writer->setDelimiter(';');

// Configurar el uso de UTF-8
$writer->setEnclosure('"');
$writer->setUseBOM(true);

// Ruta del archivo CSV de salida
$outputFileName = './L1_APRENDICES_2699192_1.csv';

// Guardar el archivo CSV
$writer->save($outputFileName);

echo "Archivo CSV generado con éxito.";