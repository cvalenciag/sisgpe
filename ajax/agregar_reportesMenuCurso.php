<?php
require_once '../valid.php';

// MUESTRA LAS FECHAS DE MALLA ===================================================================================
if (isset($_POST['elegido']))
{
  $elegido = $_POST['elegido'];

  $qborrow = $conn->query("SELECT * FROM malla WHERE eliminado=0 AND idCarrera='$elegido'") or die(mysqli_error($conn));

  while($fborrow = $qborrow->fetch_array()){
    echo "<option value='".$fborrow['fAprobacion']."'>". $fborrow['fAprobacion'] . "</option>";
  }
}

// MUESTRA LAS COMPETENCIAS ===================================================================================
// if (isset($_POST['elegido2']))
// {
//   $elegido2  = $_POST['elegido2'];
//
//   $sWhere = "";
//   if ($_POST['elegido2'] != 3) {
//     $sWhere = "AND idCarrera=$elegido2";
//   }else {
//     $sWhere = "";
//   }
//
//   $qborrow2 = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE eliminado=0
//                             $sWhere") or die(mysqli_error($conn));
//
//   while($fborrow2 = $qborrow2->fetch_array())
//   {
//     echo "<option value='".$fborrow2['idCompetencia']."'>". $fborrow2['descripcion'] . "</option>";
//     // echo '<input type="checkbox" id="'.$fborrow2['idCompetencia'].'" name="" value="">
//     // <label for="'.$fborrow2['idCompetencia'].'">'.$fborrow2['descripcion'].'</label><br>';
//   }
//
// }


// MUESTRA LAS COMPETENCIAS POR TIPO =====================================
if (isset($_POST['elegido3']))
{
  $elegido3  = $_POST['elegido3'];
  $elegido4  = $_POST['elegido4'];

  $sWhere = "";
  if ($_POST['elegido3'] != 3) {
    $sWhere = "AND idTipo=$elegido3 AND idCarrera='$elegido4'";
  }else {
    $sWhere = "AND idCarrera='$elegido4'";
  }

  $qborrow3 = $conn->query("SELECT * FROM detalle_carrera_competencia LEFT JOIN competencia USING (idCompetencia) WHERE eliminado=0
                            $sWhere") or die(mysqli_error($conn));

  echo "<option value='0'>Todas las competencias</option>";
 
  while($fborrow3 = $qborrow3->fetch_array())
  {
    echo "<option value='".$fborrow3['idCompetencia']."'>". $fborrow3['descripcion'] . "</option>";
  }

}
