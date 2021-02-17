<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];

$idCurso        = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$idRubrica      = (isset($_REQUEST['idRubrica']) && !empty($_REQUEST['idRubrica']))?$_REQUEST['idRubrica']:'';
$idNivel        = (isset($_REQUEST['idNivel']) && !empty($_REQUEST['idNivel']))?$_REQUEST['idNivel']:'';
$ordenNivel     = (isset($_REQUEST['ordenNivel']) && !empty($_REQUEST['ordenNivel']))?$_REQUEST['ordenNivel']:'';
$idSubcriterio  = (isset($_REQUEST['idSubcriterio']) && !empty($_REQUEST['idSubcriterio']))?$_REQUEST['idSubcriterio']:'';
$puntaje        = (isset($_REQUEST['puntaje']) && !empty($_REQUEST['puntaje']))?$_REQUEST['puntaje']:'';

 
$editar        = (isset($_REQUEST['op']) && !empty($_REQUEST['op']))?$_REQUEST['op']:'';

if ($editar=='D')
// if ($idRubrica!='' && $idNivel!='' && $ordenNivel!='' && $idSubcriterio!='' && $_REQUEST['op']=='D')//codigo elimina un curso del array tabla temp
{
  $resultMalla  = $conn->query("SELECT COUNT(*) total FROM detalle_rubrica WHERE idRubrica='".$idRubrica."'");
  $numRegMalla  = $resultMalla->fetch_assoc();

  if($numRegMalla['total']==1){
    echo '<script type = "text/javascript">
     alert("No es posible eliminar el registro. Favor de eliminar el registro principal.");
     </script>';

  }else {
    $sql = "DELETE FROM detalle_rubrica WHERE idRubrica='$idRubrica' AND idNivel='$idNivel' AND idSubcri='$idSubcriterio' AND ordNivel='$ordenNivel'";
    $query = mysqli_query($conn,$sql);

    echo '<script type = "text/javascript">
      alert("El registro se eliminó correctamente.");
    </script>';
  }
}


$editaCargar = (isset($_REQUEST['ops']) && !empty($_REQUEST['ops']))?$_REQUEST['ops']:'';
if ($editaCargar == 'EditReg')  //
{

  // $yIdRubrica     = $_REQUEST['yIdRubrica'];
  // $yIdNivel       = $_REQUEST['yIdNivel'];
  // $yIdSubcriterio = $_REQUEST['yIdSubcriterio'];
  // $yOrdenNivel    = $_REQUEST['yOrdenNivel'];
  // $yPuntaje       = $_REQUEST['yPuntaje'];

  $sql3=$conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica = '$idRubrica' AND ordNivel='$ordenNivel'") or die(mysqli_error($conn));

            if ($sql3->num_rows==0)
            {
              $conn->query("UPDATE detalle_rubrica SET ordNivel='$ordenNivel', puntajeRango='$puntaje' WHERE idSubcri = '$idSubcriterio' AND idRubrica='$idRubrica' AND idNivel='$idNivel'") or die(mysqli_error($conn));

              echo '<script type = "text/javascript">
                      alert("El subcriterio fue actualizado correctamente.");
                    </script>';
            } else {

              echo '<script type = "text/javascript">
                      alert("El valor ya existe. Favor de verificar.");
                      $("#ordenNivel_' . $idSubcriterio . '").val("");
                    </script>';
          }

}



// if ($idSubcriterio!='' && $idRubrica!='' && $_REQUEST['op']=='I')  //
$varEditar = (isset($_REQUEST['op']) && !empty($_REQUEST['op']))?$_REQUEST['op']:'';
if ($varEditar == 'i')  //
{
  $xIdRubrica = $_POST['IdRubrica'];
  $xIdNivel   = $_POST['IdNivel'];
  $xOrdNivel   = $_POST['OrdenNivel'];
  $xSubCri    = $_POST['IdSubcriterio'];
  $xPuntaje   = $_POST['Puntaje'];

        $sql2=$conn->query("SELECT * FROM detalle_rubrica WHERE idNivel='$idNivel' AND idSubcri='$idSubcriterio' AND idRubrica='$idRubrica'") or die (mysqli_error($conn));
            if ($sql2->num_rows==0)
            {
              // echo 'inserta nuevo valor';
            // $sql3=$conn->query("select * from detalle_og_oe where idOgOe = '$idOgOe' and idObjgeneral='$idOg' and ordenamiento='$ordenamiento'");
            // if ($sql3->num_rows==0)
            // { // inicio if num_rows

            $insert_tmp = mysqli_query($conn,"INSERT INTO detalle_rubrica (idRubrica, idNivel, ordNivel, idSubcri, puntajeRango, eliminado) VALUES ('$xIdRubrica', '$xIdNivel', '$xOrdNivel', '$xSubCri', '$xPuntaje', '1')");

           echo '<script type = "text/javascript">
                  alert("El subcriterio fue agregado satisfactoriamente.");
                </script>';

            }else {

            echo '<script type = "text/javascript">
                    alert("El valor ya existe. Favor de verificar.");
                    $("#ordenNivel_' . $xSubCri . '").val("");
                  </script>';
            }

          }


        // else {
        //         echo '
        //             <script type = "text/javascript">
        //                 alert("El objetivo específico ya se encuentra registrado en la base de datos.");
        //             </script>';
        //      }

// }


//MUESTRA LOS RESULTADOS INSERTADOS ANTERIORMENTE ==================
?>
<div class="form-group">
	<table class="table table-bordered" style="width:100%;">
		<thead>
			<tr class="alert-info">
				<th class="text-center">Descripción del <br> Criterio</th>
				<th class="text-center">Orden de <br> Criterio</th>
				<th class="text-center">Tipo de <br> Competencia</th>
				<th class="text-center">Competencia</th>
				<th class="text-center">Objetivo General</th>
				<th class="text-center"></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$qryDetRubrica = $conn->query("SELECT
    dr.idCriterio,
    c.descripcion AS desCriterio,
    dr.idTipoCompetencia,
    tc.descripcion AS desTipo,
    dr.idCompetencia,
    cc.descripcion AS desCompetencia,
    dr.idObjetivoGeneral,
    obg.definicion AS desObjetivo,
    dr.ordenamiento,
    dr.eliminado
FROM
    detalle_rubrica dr
        LEFT JOIN
    criterio c ON (c.idCriterio = dr.idCriterio)
        LEFT JOIN
    tipocompetencia tc ON (tc.idTipo = dr.idTipoCompetencia)
        LEFT JOIN
    competencia cc ON (cc.idCompetencia = dr.idCompetencia)
        LEFT JOIN
    objgeneral obg ON (obg.idObjgeneral = dr.idObjetivoGeneral)
WHERE
    idCurso='$idCurso' AND dr.eliminado=1") or die(mysqli_error($conn));

			foreach ($qryDetRubrica as $detRubrica)
			{
			?>
			<tr>
				<td class="text-justify"><?php echo $detRubrica['desCriterio'] ?></td>
				<td class="text-center"><?php echo $detRubrica['ordenamiento'] ?></td>
        <td class="text-center">
          <?php if ($detRubrica['idTipoCompetencia'] != '-1'){
						echo $detRubrica['desTipo'];
					}else{
					?>
						No aplica
					<?php
          }
          ?>
        </td>
				<td class="text-center">
					<?php if ($detRubrica['idCompetencia'] != '-1'){
						echo $detRubrica['desCompetencia'];
					}else{
					?>
						No aplica
					<?php
          }
          ?>
				</td>
				<td class="text-center">
					<?php if ($detRubrica['idObjetivoGeneral'] != '-1'){
						echo $detRubrica['desObjetivo'];
					}else{
					?>
						No aplica
					<?php
					}
					?>
				</td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $idCurso.'_'.$idCriterio ?>" title="Elimina Criterio" onclick="deleteCriterio(this.id);">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
