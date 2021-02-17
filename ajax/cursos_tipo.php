<?php

require_once '../valid.php';
$session_id = $_SESSION['session_id'];

$idCarrera		= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla		= (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$fechaPerfil	= (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';

$qryValidacion = $conn->query("SELECT * FROM perfilegresado WHERE idCarrera='$idCarrera' AND fAprobacionMalla='$fechaMalla' AND fAprobacionPerfil='$fechaPerfil'") or die(mysqli_error($conn));

if($qryValidacion->num_rows==1){
  echo '<script type = "text/javascript">
   alert("La fecha de malla y perfil ya estan registradas, favor de verificar.");
   </script>';
   
}else {

  $qryRegistros = $conn->query("SELECT * FROM tmp WHERE idCarrera='$idCarrera' AND fAprobacion='$fechaMalla'
                                AND idSession='$session_id'") or die(mysqli_error($conn));

  if($qryRegistros->num_rows==0)
  {
  	$qryObjetivosGenerales = $conn->query("INSERT INTO tmp (idCurso, ciclo, obligatorio, aol, idSession, idCarrera, fAprobacion)
  													SELECT dm.idCurso, dm.ciclo, dm.obligatoriedad, dm.aol, '$session_id', $idCarrera, '$fechaMalla' FROM detalle_malla dm
  													LEFT JOIN malla m ON (m.idMalla=dm.idMalla)
  	        							 	LEFT JOIN curso c ON (c.idCurso = dm.idCurso) LEFT JOIN departamento d ON (d.idDepartamento=c.idDepartamento) WHERE m.idCarrera='$idCarrera' AND fAprobacion='$fechaMalla'") or die(mysqli_error($conn));
  }
// }

// $qryRegistros = $conn->query("SELECT * FROM tmp WHERE idCarrera='$idCarrera' AND fAprobacion='$fechaMalla'
//                               AND idSession='$session_id'") or die(mysqli_error($conn));
//
// if($qryRegistros->num_rows==0)
// {
// 	$qryObjetivosGenerales = $conn->query("INSERT INTO tmp (idCurso, ciclo, obligatorio, aol, idSession, idCarrera, fAprobacion)
// 													SELECT dm.idCurso, dm.ciclo, dm.obligatoriedad, dm.aol, '$session_id', $idCarrera, '$fechaMalla' FROM detalle_malla dm
// 													LEFT JOIN malla m ON (m.idMalla=dm.idMalla)
// 	        							 	LEFT JOIN curso c ON (c.idCurso = dm.idCurso) LEFT JOIN departamento d ON (d.idDepartamento=c.idDepartamento) WHERE m.idCarrera='$idCarrera' AND fAprobacion='$fechaMalla'") or die(mysqli_error($conn));
// }

$q_admin = $conn->query("SELECT dm.idCurso, c.nombreCurso, dm.ciclo, d.descripcion, c.tipoCurso, dm.aol
                        FROM tmp dm LEFT JOIN curso c ON (c.idCurso = dm.idCurso) LEFT JOIN departamento d ON (d.idDepartamento=c.idDepartamento) WHERE idCarrera='$idCarrera' AND fAprobacion='$fechaMalla' AND idSession='$session_id'") or die(mysqli_error($conn));

?>

<div id="admin_table">
	<table id="tableCursosNew" class="table table-bordered table-hover" style="width:100%;">
		<thead class="alert-info">
			<tr>
				<th class="text-center" style="width:30%;">Curso</th>
				<th class="text-center" style="width:10%;">Ciclo</th>
				<th class="text-center" style="width:25%;">Departamento <br> Académico</th>
				<th class="text-center" style="width:15%;">Tipo <br> curso</th>
				<th class="text-center" style="width:10%;">AoL</th>
				<th class="text-center" style="width:10%;"></th>
			</tr>
		</thead>

		<tbody>
			<?php
			while($f_admin = $q_admin->fetch_array())
			{
				$idCurso 	= $f_admin['idCurso'];
				$ciclo		= $f_admin['ciclo'];
			?>

			<tr class="target">
				<td class="text-center"><?php echo $f_admin['nombreCurso']?></td>
				<td class="text-center"><?php echo $f_admin['ciclo'] ?>
					<input type="hidden" name="ciclo" id="ciclo_<?php echo $f_admin['idCurso']; ?>" value="<?php echo $f_admin['ciclo'];?>">
				</td>
				<td class="text-center"><?php echo $f_admin['descripcion']?></td>
				<td class="text-center"><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-Académico" ?></td>
				<td class="text-center"><?php echo ($f_admin['aol']==1) ? "Si" : "No" ?>
					<input type="hidden" name="aol" id="aol_<?php echo $f_admin['idCurso']; ?>" value="<?php echo $f_admin['aol']; ?>">
				</td>
				<td class='text-center'>
	        <button type="button" name="button" class="btn btn-editar" data-toggle="modal" data-target="#miModal" id="<?php echo $idCurso.'_'.$idCarrera.'_'.$fechaPerfil.'_'.$ciclo ?>" onclick="enviaModalNew(this.id);">
	          <span class="glyphicon glyphicon-edit" title="Agregar Objetivos"></span>
	            Objetivos de Aprendizaje
	        </button>
	      </td>
			</tr>
			<?php
				}
			?>

		</tbody>
	</table>
</div>

<?php } ?>

<script type="text/javascript">
function enviaModalNew(id)
{
	var arr 							= id.split('_');
	var idCurso 					= arr[0];
	var idCarrera 				= arr[1];
	var fAprobacionPerfil = arr[2];
	var ciclo 						= arr[3];

  $("#loader").fadeIn('slow');

  $.ajax({
		type: "POST",
		url: 	"tipoAporte2.php",
		data: 'idCurso='+idCurso+'&carrera='+idCarrera+'&fechaPerfil='+fAprobacionPerfil+'&ciclo='+ciclo,

    beforeSend: function(objeto){      },

    success:function(data){
      $(".resul_div2").html(data).fadeIn('slow');
      $('#loader').html('');
    }
  });

}

</script>
