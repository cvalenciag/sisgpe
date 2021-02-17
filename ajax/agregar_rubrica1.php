<?php
require_once '../valid.php';
$session_id = $_SESSION['session_id'];

$idRubrica      = (isset($_REQUEST['idRubrica']) && !empty($_REQUEST['idRubrica']))?$_REQUEST['idRubrica']:'';
$idCurso        = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$idCompetencia  = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$idObjgeneral   = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$idCriterio     = (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';
$fAprobacion    = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';

$idSubCriterio  = (isset($_REQUEST['idSubcriterio']) && !empty($_REQUEST['idSubcriterio']))?$_REQUEST['idSubcriterio']:'';
$puntajeNivel   = (isset($_REQUEST['puntaje']) && !empty($_REQUEST['puntaje']))?$_REQUEST['puntaje']:'';
$idNivel        = (isset($_REQUEST['idNivel']) && !empty($_REQUEST['idNivel']))?$_REQUEST['idNivel']:'';
$ordenNivel     = (isset($_REQUEST['ordenNivel']) && !empty($_REQUEST['ordenNivel']))?$_REQUEST['ordenNivel']:'';


// $sql1 = $conn->query("SELECT * FROM tmp WHERE idCurso='$idCurso' AND idCompetencia='$idCompetencia' AND idObjgeneral='$idObjgeneral' AND idNivel='$idNivel' AND ordNivel='$ordenNivel' AND idSubcri='$idSubCriterio' AND puntajeRango='$puntajeNivel' AND fAprobacion='$fAprobacion' AND idSession='$session_id'");
//
// if ($sql1->num_rows==0)
// {
//   $sql2=$conn->query("SELECT * FROM detalle_rubrica WHERE idNivel='$idNivel' AND ordNivel='$ordenNivel' AND idSubcri='$idSubCriterio' AND puntajeRango='$puntajeNivel'");
//   if ($sql2->num_rows==0)
//   {

    $sql3=$conn->query("SELECT * FROM tmp WHERE fAprobacion='$fAprobacion' AND ordNivel='$ordenNivel' AND idSession='$session_id'");
    // $sql3=$conn->query("SELECT * FROM tmp WHERE idCurso='$idCurso' AND idCompetencia='$idCompetencia' AND idObjgeneral='$idObjgeneral' AND idNivel='$idNivel' AND ordNivel='$ordenNivel' AND idSubcri='$idSubCriterio' AND puntajeRango='$puntajeNivel' AND fAprobacion='$fAprobacion' AND idSession='$session_id'");
 
    if ($sql3->num_rows==0)
    {
      $insert_tmp = mysqli_query($conn, "INSERT INTO tmp (idCurso,idCompetencia,idObjgeneral,idNivel,ordNivel,idSubcri, puntajeRango,fAprobacion,idSession) VALUES ('$idCurso','$idCompetencia','$idObjgeneral','$idNivel','$ordenNivel','$idSubCriterio','$puntajeNivel',
       '$fAprobacion','$session_id')");

      echo '<script type = "text/javascript">
              alert("El subcriterio se almacenó correctamente.");
            </script>';
    }else {
      echo '<script type = "text/javascript">
              alert("El valor ya existe. Favor de verificar.");
            </script>';

      echo '<input type="hidden" name="" value="1" id="idWarning">';
      // echo '<script type = "text/javascript">
      //         $("#ordenNivel_'.$idSubcriterio.'").val("");
      //      </script>';
    }

//   }else {
//
//     echo '<script type = "text/javascript">
//             alert("El nivel ya se encuentra registrado en la base de datos.");
//           </script>';
//   }
//
// }


//MUESTRA LOS VALORES AGREAGDOS
// $sql = $conn->query("SELECT t.idTmp, t.idSubcri, s.descripcion as descSubcri, t.idNivel, n.descripcion as desLevel, t.ordNivel, t.puntajeRango FROM subcriterio s, tmp t, nivel n WHERE s.idSubcriterio=t.idSubcri AND t.fAprobacion='$fAprobacion' AND n.idNivel=t.idNivel AND t.idSession='$session_id'");

$sql = $conn->query("SELECT
    t.idTmp,
    t.idSubcri,
    s.descripcion AS descSubcri,
    t.idNivel,
    n.descripcion AS desLevel,
    t.ordNivel,
    t.puntajeRango
FROM
    tmp t
        LEFT JOIN
    nivel n ON (n.idNivel = t.idNivel)
        LEFT JOIN
    subcriterio s ON (s.idSubcriterio = t.idSubcri) WHERE t.fAprobacion='$fAprobacion' AND t.idSession='$session_id'");

if ($sql->num_rows>0)
{
?>

<table class="table table-bordered" style="width:100%;">
  <tr class="alert-info">
    <th class='text-center'>Descripción del Nivel</th>
    <th class='text-center'>Orden de Nivel</th>
    <th class='text-center'>Rotulo de Nivel</th>
    <th class='text-center'>Puntaje</th>
    <th></th>
  </tr>

<?php
  while ($row=mysqli_fetch_array($sql))
  {
    $id_tmp         = $row["idTmp"];
    $idSubCriterio  = $row['idSubcri'];
    $descSubCriterio  = $row['descSubcri'];
    $ordenLevel     = $row['ordNivel'];
    $idLevel        = $row['idNivel'];
    $level          = $row['desLevel'];
    $puntajeLevel   = $row['puntajeRango'];
?>
  <tr>
    <td class='text-justify'><?php echo $descSubCriterio;?></td>
    <td class='text-center'><?php echo $ordenLevel;?></td>
    <td class='text-center'><?php echo $level;?></td>
    <td class='text-center'><?php echo $puntajeLevel;?></td>

    <td class='text-center'>
      <button type="button" name="button" onclick="eliminar('<?php echo $id_tmp ?>')" class="btn btn-sm btn-danger glyphicon glyphicon-trash">
      </button>
    </td>
  </tr>
<?php
  }
?>

</table>

<?php
}
?>
