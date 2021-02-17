<?php
require_once 'connect.php';
 
$deleteCabecera = (isset($_REQUEST['deleteEval']) && !empty($_REQUEST['deleteEval']))?$_REQUEST['deleteEval']:'';
$estado	= (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';

$conn->query("UPDATE evaluacion SET estado='$estado' WHERE idEvaluacion='$_REQUEST[idEvaluacion]'") or die(mysqli_error($conn));

if ($conn->affected_rows==1){
	$conn->query("UPDATE detalle_evaluacion SET eliminado='$estado' WHERE idEvaluacion='$_REQUEST[idEvaluacion]'") or die(mysqli_error($conn));
}

echo '<script type = "text/javascript">
				window.location = "gEvaluacion.php";
			</script>';



// ELIMINA EVALUADORES DE TABLA DETALLE_EVALUACION =================================================================
$deleteEvaluador = (isset($_REQUEST['deleteEvalEdit']) && !empty($_REQUEST['deleteEvalEdit']))?$_REQUEST['deleteEvalEdit']:'';
if($deleteEvaluador == 'de')
{
	$idEvaluacionD  = $_POST['idEvaluacionD'];
	$idEvaluadorD		= $_POST['idEvaluadorD'];

	$deleteRegistro = mysqli_query($conn, "DELETE FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacionD' AND idEvaluador='$idEvaluadorD'");

	echo '<script type = "text/javascript">
					alert("El registro se eliminó correctamente.");
				</script>';

?>
<table class="table table-bordered" style="width:100%;">
	<thead>
		<tr class="alert-info">
			<th class="text-center">Nombre</th>
			<th class="text-center">Apellido</th>
			<th class="text-center"></th>
		</tr>
	</thead>
	<tbody>
		<?php
			$qryEval = $conn->query("SELECT de.idEvaluador, nomEvaluador, apeEvaluador FROM detalle_evaluacion de
			LEFT JOIN evaluador e ON (e.idEvaluador=de.idEvaluador) WHERE idEvaluacion=$idEvaluacionD
			GROUP BY de.idEvaluador") or die(mysqli_error($conn));

			foreach ($qryEval as $evals)
			{
		?>
	<tr>
		<td><?php echo $evals['nomEvaluador'] ?></td>
		<td><?php echo $evals['apeEvaluador'] ?></td>
		<td class="text-center">
			<button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Evaluador" onclick="deleteEvaluador2(<?php echo $evals['idEvaluador'] ?>,<?php echo $idEvaluacionD ?> );">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
		</td>
	</tr>
		<?php
			}
		?>
	</tbody>
</table>
<?php
}


// ELIMINA EVALUADORES DE TABLA TMP ================================================================================
$deleteEvaluador = (isset($_REQUEST['deleteEval']) && !empty($_REQUEST['deleteEval']))?$_REQUEST['deleteEval']:'';
if($deleteEvaluador == 'd')
{
	$idTempo				= $_POST['idTemporal'];
	$delEvaluador	 	= $_POST['idEvaluadorD'];

	$qryDelTemp = $conn->query("SELECT * FROM tmp WHERE idTmp='$idTempo' AND idEvaluador='$delEvaluador' GROUP BY idEvaluador");

	if($qryDelTemp->num_rows==1){
		$deleteRegistro = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTempo' AND idEvaluador='$delEvaluador'");

		echo '<script type = "text/javascript">
						alert("El registro se eliminó correctamente.");
					</script>';
	}


?>
<table class="table table-bordered" style="width:100%;">
  <thead>
    <tr class="alert-info">
      <th class="text-center">Nombre</th>
      <th class="text-center">Apellido</th>
      <th class="text-center"></th>
    </tr>
  </thead>
  <tbody>
    <?php
      // $qryEval = $conn->query("SELECT de.idEvaluador, nomEvaluador, apeEvaluador FROM detalle_evaluacion de
      //   LEFT JOIN evaluador e ON (e.idEvaluador = de.idEvaluador) WHERE idEvaluacion=$delEvaluacion
      //   GROUP BY de.idEvaluador") or die(mysqli_error($conn));

			$qryEval = $conn->query("SELECT t.idTmp, t.idEvaluador, nomEvaluador, apeEvaluador FROM tmp t
		    LEFT JOIN evaluador e ON (e.idEvaluador = t.idEvaluador) WHERE idSession='$session_id'
		    GROUP BY t.idEvaluador") or die (mysqli_error($conn));

      foreach ($qryEval as $evals)
      {
    ?>
	<tr>
    <td><?php echo $evals['nomEvaluador'] ?></td>
    <td><?php echo $evals['apeEvaluador'] ?></td>
    <td class="text-center">
      <button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Evaluador" onclick="deleteEvaluador(<?php echo $evals['idEvaluador'] ?>,<?php echo $evals['idTmp'] ?> );">
        <span class="glyphicon glyphicon-trash"></span>
      </button>
    </td>
	</tr>
    <?php
      }
    ?>
  </tbody>
</table>
<?php
}
?>


<script type="text/javascript">
	function deleteEvaluador(idEvaluador, idTmp){
		$.ajax({
			type: 'POST',
			url: 'gEvaluacionEliminar.php',
			data: '&idTemporal='+idTmp+'&idEvaluadorD='+idEvaluador+'&deleteEval=d',

			beforeSend: function(objeto){
				$("#resultEvaluadores").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultEvaluadores").html(datos);
			}

		}); //LLAVE AJAX
	}



	function deleteEvaluador2(idEvaluador, idEvaluacion){
		$.ajax({
			type: 'POST',
			url: 'gEvaluacionEliminar.php',
			data: '&idEvaluacionD='+idEvaluacion+'&idEvaluadorD='+idEvaluador+'&deleteEvalEdit=de',

			beforeSend: function(objeto){
				$("#resultEvaluadores").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultEvaluadores").html(datos);
			}

		}); //LLAVE AJAX
	}
</script>
