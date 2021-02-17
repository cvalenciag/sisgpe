<?php
require_once 'connect.php';
session_start();
$session_id   = $_SESSION['session_id'];
// echo $_SESSION['session_id'];


// ELIMINA EL REGISTRO ==============================================================================================
$delCriterioTmp = (isset($_REQUEST['deleteTmp']) && !empty($_REQUEST['deleteTmp']))?$_REQUEST['deleteTmp']:'';
if ($delCriterioTmp == 'dt')
{
		$idTempo		= (isset($_REQUEST['idTempo']) && !empty($_REQUEST['idTempo']))?$_REQUEST['idTempo']:'';
		$idCurso		= (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
		// $idCriterio	= (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';

		$sqlDelete = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTempo'");
		if($sqlDelete->num_rows==1)
		{
			// echo 'PASA';
			$delete = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTempo'");
		}

		echo '<script type = "text/javascript">
						alert("El registro se eliminó correctamente.");
					</script>';

?>

<!-- <div class="form-group"> -->
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
			$qryDetRubrica = $conn->query("SELECT t.idTmp, t.idCriterio, c.descripcion AS desCriterio, t.obligatorio, tc.descripcion AS desTipo, t.idCompetencia, cc.descripcion AS desCompetencia, t.idObjgeneral, obg.definicion AS desObjetivo, t.ordenamiento FROM tmp t
      LEFT JOIN criterio c ON (c.idCriterio = t.idCriterio)
    	LEFT JOIN tipocompetencia tc ON (tc.idTipo = t.obligatorio)
      LEFT JOIN competencia cc ON (cc.idCompetencia = t.idCompetencia)
    	LEFT JOIN objgeneral obg ON (obg.idObjgeneral = t.idObjgeneral)
			WHERE idCurso='$idCurso'") or die(mysqli_error($conn));

			foreach ($qryDetRubrica as $detRubrica)
			{
			?>
			<tr>
				<td class="text-justify"><?php echo $detRubrica['desCriterio'] ?></td>
				<td class="text-center"><?php echo $detRubrica['ordenamiento'] ?></td>
        <td class="text-center">
          <?php if ($detRubrica['obligatorio'] != '-1'){
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
					<?php if ($detRubrica['idObjgeneral'] != '-1'){
						echo $detRubrica['desObjetivo'];
					}else{
					?>
						No aplica
					<?php
					}
					?>
				</td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $detRubrica['idTmp'] ?>" title="Elimina Criterio" onclick="deleteCriterio(this.id);">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<!-- </div> -->

<?php
} //LLAVE DELETE TEMPO
?>


<?php
//INICIO DELETE DETALLE RUBRICA
$delCriterioDet = (isset($_REQUEST['deleteDet']) && !empty($_REQUEST['deleteDet']))?$_REQUEST['deleteDet']:'';
if ($delCriterioDet == 'dd')
{
		$idRubrica	= $_POST['idRubrica'];
		$idCurso		= $_POST['idCurso'];
		$idCriterio	= $_POST['idCriterio'];

		$sqlDelete = $conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica='$idRubrica' AND idCurso='$idCurso' AND idCriterio='$idCriterio'");

		if($sqlDelete->num_rows==1)
		{
			$deleteRegistro = mysqli_query($conn, "DELETE FROM detalle_rubrica WHERE idRubrica='$idRubrica' AND idCurso='$idCurso' AND idCriterio='$idCriterio'");
		}

		echo '<script type = "text/javascript">
						alert("El registro se eliminó correctamente.");
					</script>';

?>

<!-- <div class="form-group"> -->
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
			$qryDetRubrica = $conn->query("SELECT t.idRubrica, t.idCriterio, c.descripcion AS desCriterio, t.idTipoCompetencia, tc.descripcion AS desTipo, t.idCompetencia, cc.descripcion AS desCompetencia, t.idObjetivoGeneral, obg.definicion AS desObjetivo, t.ordenamiento FROM detalle_rubrica t
      LEFT JOIN criterio c ON (c.idCriterio = t.idCriterio)
    	LEFT JOIN tipocompetencia tc ON (tc.idTipo = t.idTipoCompetencia)
      LEFT JOIN competencia cc ON (cc.idCompetencia = t.idCompetencia)
    	LEFT JOIN objgeneral obg ON (obg.idObjgeneral = t.idObjetivoGeneral)
			WHERE idCurso='$idCurso' AND idRubrica='$idRubrica' AND eliminado=1") or die(mysqli_error($conn));

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
					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $detRubrica['idRubrica'].'_'.$idCurso.'_'.$detRubrica['idCriterio'] ?>" title="Elimina Criterio" onclick="deleteCriterio2(this.id);">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<!-- </div> -->

<?php
} // FIN DELETE DETALLE RUBRICA
?>


<script type="text/javascript">
function deleteCriterio(id){

  arr 				= id.split('_');
  xIdTempo		= arr[0];
  xIdCurso		= arr[1];
  // xIdCriterio	= arr[2];

  $.ajax({
    type: 'POST',
    url: 'rubricasEliminar.php',
    data: 'idTempo='+xIdTempo+'&idCurso='+xIdCurso+'&deleteTmp=dt',

    beforeSend: function(objeto){
      $("#resultados").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultados").html(datos);
    }

  }); //LLAVE AJAX
}


function deleteCriterio2(id){
  arr 				= id.split('_');
	xIdRubrica  = arr[0];
	xIdCurso		= arr[1];
	xIdCriterio	= arr[2];

  $.ajax({
    type: 'POST',
  	url: 'rubricasEliminar.php',
    data: 'idRubrica='+xIdRubrica+'&idCriterio='+xIdCriterio+'&idCurso='+xIdCurso+'&deleteDet=dd',

    beforeSend: function(objeto){
      $("#resultados").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultados").html(datos);
    }

  }); //LLAVE AJAX
}
</script>
