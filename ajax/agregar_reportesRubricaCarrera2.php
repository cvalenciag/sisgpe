<?php

require_once '../valid.php';

// Modalidad
// 2 = Escrito

$idCurso  	  = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
// $modalidad 	  = (isset($_REQUEST['modalidad']) && !empty($_REQUEST['modalidad']))?$_REQUEST['modalidad']:'';
$fechaRubrica = (isset($_REQUEST['fechaRubC']) && !empty($_REQUEST['fechaRubC']))?$_REQUEST['fechaRubC']:'';


$sql = $conn->query("SELECT * FROM rubrica WHERE idCurso='$idCurso' AND fechaAprobacion='$fechaRubrica'") or die(mysqli_error($conn));
 
if ($sql->num_rows>0)
{
?>
<div class="" style="margin-top:15px;">
  <table id="tablaRubCarrera" class="table table-bordered" style="width:100%;">
  <thead>
    <tr class="bg-primary">
      <th class="text-center" style="width:20%;">Criterios</th>
      <?php
        $qryNiveles = $conn->query("SELECT dr.idNivel, n.descripcion FROM rubrica r LEFT JOIN
        detalle_rubrica dr USING (idRubrica) LEFT JOIN nivel n USING (idNivel)
        WHERE idCurso='$idCurso' GROUP BY dr.idNivel") or die(mysqli_error($conn));

        foreach ($qryNiveles as $niveles)
        {
      ?>
          <th class="text-center" style="width:20%;"><?php echo $niveles['descripcion'] ?></th>

      <?php
        }
      ?>
          <th class="text-center">Puntaje</th>
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
        ?>
            <th class="alert-info"></th>
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
        ?>
        <td colspan="5"><b>Observación: </b><br>
          <textarea name="name" rows="3" cols="15"></textarea>
        </td>
      </tr>
    <?php
      } //LLAVE CRITERIOS
    ?>
  </tbody>
</table>
</div>
<?php
}else{
?>

<br>
<table style="width:100%;">
  <tr>
    <td class="text-center">
      <b>No existen datos para mostrar...</b>
      <!-- <input type="hidden" name="" id="idResultadoNivel" value="1"> -->
    </td>
  </tr>
</table>

<?php
}
?>
