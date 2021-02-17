<?php
set_time_limit(500);
// Cargamos la librería dompdf que hemos instalado en la carpeta dompdf
require_once 'lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;


// Introducimos HTML de prueba
// $html=file_get_contents_curl("../xlsReporteMallaCurricular.php");
ob_start();
include 'pdfReporteEvaluacion2_1.php';
$html = ob_get_clean();


// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("Legal", "landscape");
//$pdf->set_paper(array(0,0,104,250));

// Cargamos el contenido HTML.
$pdf->load_html($html);

// Renderizamos el documento PDF.
$pdf->render();

// Enviamos el fichero PDF al navegador.
$pdf->stream('ReporteEvaluacion.pdf');
