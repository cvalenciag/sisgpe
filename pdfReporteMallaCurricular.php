<?php
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
// require_once ('connect.php');
require_once ('lib/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

// Introducimos HTML de prueba
ob_start();
include("pdfReporteMallaCurricular2.php");
$html = ob_get_clean();

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("letter", "landscape");
//$pdf->set_paper(array(0,0,104,250));

// Cargamos el contenido HTML.
$pdf->load_html($html);

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream("ReporteMallaCurricular.pdf");
