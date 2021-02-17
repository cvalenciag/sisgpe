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
<!-- <div class="container-fluid">
  <div class="col-lg-12" style="margin-top:125px;"> -->
    <table>
      <tr>
        <!-- <td align="center" ><img src="images/UP LOGO.png"/></td> -->
        <td align="center" colspan="<?php echo $modalidad==1 ? 10 : 6 ?>" bgcolor="#337ab7"><font color="#ffffff"><b>RUBRICA PARA EVALUACION DEL CURSO:</b>
          <!-- <font color="#ffffff"> -->
            <?php echo $nameCurso ?> &nbsp;&nbsp; ( MODALIDAD: <?php echo $modalidad==1 ? 'Oral' : 'Escrito'  ?> )
          </font>
        </td>
      </tr>
    </table>
  <!-- </div> -->
  <br>
  <!-- <div class="col-lg-12" style="margin-top:15px;"> -->
    <table border="1">
      <thead>
        <tr>
          <th align="left"><b>NOMBRE DEL PROYECTO:</b></th>
          <th align="left" colspan="<?php echo $modalidad==1 ? 4 : 2 ?>"></th>
          <th align="left"><b>SEMESTRE:</b></th>
          <th align="left" colspan="<?php echo $modalidad==1 ? 4 : 2 ?>"></th>
        </tr>
      </thead>
    </table>
  <!-- </div> --> 
  <br>
  <!-- <div class="col-lg-12" style="margin-top:15px;"> -->
    <table>
      <tr>
        <td>
          <table border="1">
            <tr>
              <th align="left"><b>INTEGRANTES DEL GRUPO:</b></th>
              <?php
                for ($i=1; $i<=4; $i++)
                {
              ?>
                <th align="left"><b><?php echo 'A'.$i.':' ?></b></th>
              <?php
                }
              ?>
              <th align="left" colspan="<?php echo $modalidad==1 ? 5 : '' ?>"><b>A5:</b></th>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  <!-- </div> -->
  <br>
  <!-- <div class="" style="margin-top:15px;"> -->
    <table id="tablaRubCarrera" border="1">
    <thead>
      <tr bgcolor="#337ab7">
        <th align="center"><font color="#ffffff">Criterios</font></th>
        <?php
          $qryNiveles = $conn->query("SELECT dr.idNivel, n.descripcion FROM rubrica r LEFT JOIN
          detalle_rubrica dr USING (idRubrica) LEFT JOIN nivel n USING (idNivel)
          WHERE idCurso='$idCurso' GROUP BY dr.idNivel") or die(mysqli_error($conn));

          foreach ($qryNiveles as $niveles)
          {
        ?>
            <th align="center"><font color="#ffffff"><?php echo $niveles['descripcion'] ?></font></th>

        <?php
          }

          if($modalidad==2)
          {
        ?>
          <th align="center"><font color="#ffffff">Puntaje<font></th>
        <?php
          }else {
            for ($i=1; $i<=5 ; $i++)
            {
            ?>
              <td align="left"><font color="#ffffff"><b><?php echo 'A'.$i.':' ?></b></font></td>
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
        <tr bgcolor="#d9edf7">
          <th align="center">Puntaje</th>

          <?php
            $qryX = $conn->query("SELECT dr.idRubrica, dr.idNivel, dr.ordNivel, dr.idSubcri, s.descripcion AS desSubcri, dr.puntajeRango, r.idCriterio FROM detalle_rubrica dr
            LEFT JOIN rubrica r USING (idRubrica) LEFT JOIN subcriterio s ON (s.idSubcriterio = dr.idSubcri) WHERE r.idCriterio='$idCriterio' ORDER BY r.idCriterio , idNivel") or die(mysqli_error($conn));

            foreach ($qryX as $x)
            {
            ?>
              <th align="center"><?php echo $x['puntajeRango']  ?></th>
            <?php
            }

            if($modalidad==1)
            {
          ?>
            <th bgcolor="#d9edf7" colspan="5"></th>
          <?php
        }else {
          ?>
            <th bgcolor="#d9edf7"></th>
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
      <td align="left">COMENTARIOS:</td>
    </tr>
  </table>
  <table border="1">
    <tr>
      <td style="height:35px;" colspan="5"></td>
    </tr>
  </table>
  <br>
  <br>

  <table border="1">
    <tr>
      <td style="height:35px;" colspan="2"></td>
    </tr>
  </table>
  <table>
    <tr>
      <td align="center" colspan="2">NOMBRE Y FIRMA DEL PROFESOR-EVALUADOR:</td>
    </tr>
  </table>
  <!-- </div>
</div> -->
