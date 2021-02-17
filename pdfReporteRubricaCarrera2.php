<?php

header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
header('Content-type: application/x-msexcel'); // This should work for the rest
header('Content-Disposition: attachment; filename=Formato_Rubrica.xls');

require_once 'connect.php';


// Modalidad
// 1 = Oral
// 2 = Escrito

$idCurso  	  = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$modalidad 	  = (isset($_REQUEST['modalidad']) && !empty($_REQUEST['modalidad']))?$_REQUEST['modalidad']:'';
$fechaRubrica = (isset($_REQUEST['fechaRubC']) && !empty($_REQUEST['fechaRubC']))?$_REQUEST['fechaRubC']:'';


$qryCursos    = $conn->query("SELECT nombreCurso FROM curso WHERE idCurso='$idCurso'") or die(mysqli_error($conn));
$resQryCursos = $qryCursos->fetch_array();
$nameCurso    = $resQryCursos['nombreCurso'];

?>
<head>
	<!--<meta charset = "utf-8" />-->
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name = "viewport" content = "width=device-width, initial-scale=1" />
	<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/chosen.min.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/main.css" />
  <link rel = "stylesheet" type = "text/css" href = "css/mis_estilos.css" />
</head>
<!-- <div class="container-fluid">
  <div class="col-lg-12" style="margin-top:125px;"> -->
    <table style="width:100%;">
      <tr>
        <td class="text-center" style="width:30%;"><img src="images/UP LOGO.png"  /></td>
        <td class="text-center bg-primary" style="width:70%"><b>RUBRICA PARA EVALUACION DEL CURSO:</b>
          <!-- <font color="#337ab7"> -->
            <?php echo $nameCurso ?> &nbsp;&nbsp; ( MODALIDAD: <?php echo $modalidad==1 ? 'Oral' : 'Escrito'  ?> )
          <!-- </font> -->
        </td>
      </tr>
    </table>
  <!-- </div> -->
  <br>
  <!-- <div class="col-lg-12" style="margin-top:15px;"> -->
    <table style="width:100%;" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th style="width:25%;" class="text-left border-pdf"><b>NOMBRE DEL PROYECTO:</b></th>
          <th style="width:50%;" class="text-left border-pdf"></th>
          <th style="width:10%;" class="text-center border-pdf"><b>SEMESTRE:</b></th>
          <th style="width:15%;" class="text-center border-pdf"></th>
        </tr>
      </thead>
    </table>
  <!-- </div> -->

  <!-- <div class="col-lg-12" style="margin-top:15px;"> -->
    <table style="width:100%;">
      <tr>
        <td>
          <table style="width:100%;" class="table table-bordered table-hover">
            <tr>
              <th style="width:40%;" class="border-pdf"><b>INTEGRANTES DEL GRUPO:</b></th>
              <?php
                for ($i=1; $i<=5; $i++)
                {
              ?>
                <th class="text-left border-pdf" style="width:15%"><b><?php echo 'A'.$i.':' ?></b></th>
              <?php
                }
              ?>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  <!-- </div> -->

  <!-- <div class="" style="margin-top:15px;"> -->
    <table id="tablaRubCarrera" class="table table-bordered" style="width:100%;">
    <thead>
      <tr class="bg-primary">
        <th class="text-center">Criterios</th>
        <?php
          $qryNiveles = $conn->query("SELECT dr.idNivel, n.descripcion FROM rubrica r LEFT JOIN
          detalle_rubrica dr USING (idRubrica) LEFT JOIN nivel n USING (idNivel)
          WHERE idCurso='$idCurso' GROUP BY dr.idNivel") or die(mysqli_error($conn));

          foreach ($qryNiveles as $niveles)
          {
        ?>
            <th class="text-center"><?php echo $niveles['descripcion'] ?></th>

        <?php
          }

          if($modalidad==2)
          {
        ?>
          <th class="text-center">Puntaje</th>
        <?php
          }else {
            for ($i=1; $i<=5 ; $i++)
            {
            ?>
              <td class="text-left"><b><?php echo 'A'.$i.':' ?></b></td>
            <?php
            }
        ?>

        <?php
          }
        ?>


      </tr>
    </thead>
    <tbody>
      <?php
        $qryCriterios = $conn->query("SELECT
      dr.idRubrica,
      r.idCurso,
      r.fechaAprobacion,
      r.idCriterio,
      c.descripcion AS desCriterio
  FROM
      detalle_rubrica dr
          LEFT JOIN
      rubrica r ON (r.idRubrica = dr.idRubrica)
          LEFT JOIN
      criterio c ON (c.idCriterio = r.idCriterio)
  WHERE
      idCurso = '$idCurso'
          AND fechaAprobacion = '$fechaRubrica'
  GROUP BY dr.idRubrica") or die(mysqli_error($conn));

        foreach ($qryCriterios as $criterio)
        {
          $idCriterio = $criterio['idCriterio'];
          $idRubrica  = $criterio['idRubrica'];
      ?>
        <tr class="alert-info">
          <th class="text-center">Puntaje</th>

          <?php
            $qryX = $conn->query("SELECT dr.idRubrica, dr.idNivel, dr.ordNivel, dr.idSubcri, s.descripcion AS desSubcri, dr.puntajeRango, r.idCriterio FROM detalle_rubrica dr
            LEFT JOIN rubrica r USING (idRubrica) LEFT JOIN subcriterio s ON (s.idSubcriterio = dr.idSubcri) WHERE r.idCriterio='$idCriterio' ORDER BY r.idCriterio , idNivel") or die(mysqli_error($conn));

            foreach ($qryX as $x)
            {
            ?>
              <th class="text-center"><?php echo $x['puntajeRango']  ?></th>
            <?php
            }

            if($modalidad==1)
            {
          ?>
            <th class="alert-info" colspan="5"></th>
          <?php
        }else {
          ?>
            <th class="alert-info"></th>
          <?php
        }
          ?>

        </tr>

        <tr>
          <td><?php echo $criterio['desCriterio'] ?></td>

          <?php
            $qrySubCri = $conn->query("SELECT dr.idRubrica, dr.idNivel, dr.ordNivel, dr.idSubcri,
            s.descripcion AS desSubcri, dr.puntajeRango, r.idCriterio FROM detalle_rubrica dr
            LEFT JOIN rubrica r USING (idRubrica)  LEFT JOIN subcriterio s ON (s.idSubcriterio = dr.idSubcri)
            WHERE r.idCriterio='$idCriterio' ORDER BY idNivel") or die(mysqli_error($conn));

            foreach ($qrySubCri as $subcri)
            {
          ?>
              <td><?php echo $subcri['desSubcri'] ?></td>
          <?php
            }

            if ($modalidad==1)
            {
          ?>
              <td colspan="5"><b>Observación:</b></td>
          <?php
        }else {
          ?>
            <td><b>Observación: </b></td>
          <?php
        }
          ?>

        </tr>
      <?php
        } //LLAVE CRITERIOS
      ?>
    </tbody>
  </table>
 
  <br>
  <table>
    <tr>
      <td class="text-left">COMENTARIOS:</td>
    </tr>
    <tr>
      <td class="border-pdf" style="height:40px; width:950px;"></td>
    </tr>
  </table>
  <br>

  <table>
    <tr>
      <td class="border-pdf" style="height:40px; width:450px;"></td>
    </tr>
    <tr>
      <td class="text-center">&nbsp;&nbsp;&nbsp; NOMBRE Y FIRMA DEL PROFESOR-EVALUADOR:</td>
    </tr>
  </table>
  <!-- </div>
</div> -->
