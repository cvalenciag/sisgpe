<?php
  require_once '../valid.php';
  $idPerfilEgresado = $_REQUEST['idPerfilEgresado'];
?>

<table id="table" class="table table-bordered table-hover" style="width:100%">
  <thead class="alert-info">
    <tr>
      <th class="text-center">Tipo de Competencia</th>
      <th class="text-center">Competencia</th>
      <th class="text-center">Tipo de Objetivo de Aprendizaje</th>
      <th class="text-center">Objetivo de Aprendizaje</th>
      <th class="text-center">Tipo de Aporte</th>
    </tr>
  </thead>
  <tbody> 
    <?php
      $q_admin = $conn->query("SELECT tc.descripcion as descTipo, c.descripcion as descCompetencia, og.definicion as descObjGral, pe.tipoAporte FROM detalle_curso_nivelaporte pe, tipocompetencia tc, competencia c, objgeneral og WHERE pe.idTipo=tc.idTipo AND pe.idCompetencia=c.idCompetencia AND pe.idObjgeneral=og.idObjgeneral AND eliminado='0'") or die(mysqli_error($conn));

      while ($f_admin = $q_admin->fetch_array()) {
    ?>

    <tr class="target">
      <td class="text-center"><?php echo $f_admin['descTipo']?></td>
      <td class="text-center"><?php echo $f_admin['descCompetencia']?></td>
      <td class="text-center"></td>
      <td class="text-justify"><?php echo $f_admin['descObjGral']?></td>
      <td class="text-center">
        <?php
          if($f_admin['tipoAporte'] == 1){
            echo 'Contribuye';
          }else if($f_admin['tipoAporte'] == 2) {
            echo 'Logra';
          }else if($f_admin['tipoAporte'] == 3){
            echo 'Sostiene';
          }else{
            echo 'No Aplica';
          }
        ?>
      </td>
    </tr>

    <?php
      }
    ?>


  </tbody>
</table>
