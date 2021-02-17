<?php

require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idDepto		= (isset($_REQUEST['idDepto']) && !empty($_REQUEST['idDepto']))?$_REQUEST['idDepto']:'';
$idCarrera	= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$obliga 		= (isset($_REQUEST['obligatorio']) && !empty($_REQUEST['obligatorio']))?$_REQUEST['obligatorio']:'';
$fechaMalla	= (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';

$sWhere	=	"";
if ( $idDepto!='' && $obliga=='' ){ 
	$sWhere = "AND dm.idCarrera='$idCarrera' AND c.idDepartamento='$idDepto'";

}elseif( $idDepto=='' && $obliga!='' ){
	$sWhere = "AND dm.idCarrera='$idCarrera' AND dm.obligatoriedad='$obliga'";

}else if( $idDepto!='' && $obliga!=''){
	$sWhere = "AND dm.idCarrera='$idCarrera' AND c.idDepartamento='$idDepto' AND dm.obligatoriedad='$obliga'";
}else {
	$sWhere = "AND dm.idCarrera='$idCarrera'";
}

$q_admin = $conn->query("SELECT dm.idCurso, c.nombreCurso, dm.ciclo, d.descripcion, c.tipoCurso, dm.aol FROM detalle_malla dm
												LEFT JOIN malla m ON (m.idMalla=dm.idMalla)
        							 	LEFT JOIN curso c ON (c.idCurso = dm.idCurso) LEFT JOIN departamento d ON (d.idDepartamento=c.idDepartamento) WHERE dm.eliminado=0 AND m.fAprobacion='$fechaMalla' $sWhere") or die(mysqli_error($conn));

?>

<div id="admin_table">
	<table id="table2" class="table table-bordered table-hover" style="width:100%;">
		<thead class="alert-info">
			<tr>
				<th class="text-center" style="width:30%;">Curso</th>
				<th class="text-center" style="width:10%;">Ciclo</th>
				<th class="text-center" style="width:25%;">Departamento <br> Académico</th>
				<th class="text-center" style="width:15%;">Tipo <br> Curso</th>
				<th class="text-center" style="width:10%;">AoL</th>
				<th class="text-center" style="width:10%;"></th>
			</tr>
		</thead>

		<tbody>
			<?php
			while($f_admin = $q_admin->fetch_array())
			{
				// $result = $conn->query("SELECT descripcion FROM departamento where idDepartamento='".$f_admin['idDepartamento']."'");
				// $fila = $result->fetch_assoc();


			?>

			<tr class = "target">
				<td class="text-left"><?php echo $f_admin['nombreCurso']?></td>
				<td class="text-center"><?php echo $f_admin['ciclo'] ?>
					<input type="hidden" name="ciclo" id="ciclo_<?php echo $f_admin['idCurso']; ?>" value="<?php echo $f_admin['ciclo'];?>">
				</td>
				<td class="text-center"><?php echo $f_admin['descripcion']?></td>
				<td class="text-center"><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-Académico" ?></td>
				<td class="text-center"><?php echo ($f_admin['aol']==1) ? "Si" : "No" ?>
					<input type="hidden" name="aol" id="aol_<?php echo $f_admin['idCurso']; ?>" value="<?php echo $f_admin['aol']; ?>">
				</td>
				<td class="text-center">
					<button type="button" name="button" id="agregaCurso" class="btn btn-success btn-sm glyphicon glyphicon-plus" value="<?php echo $f_admin['idCurso'];?>"></button>
        </td>
			</tr>
			<?php
				}
			?>
		</tbody>
	</table>
</div>

<script src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type = "text/javascript">
	$(document).ready(function() {
		$('#table2').DataTable( {
      	"pageLength": 5,
				"language": {
        	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Lfrtip',
				lengthMenu: [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Mostrar todos' ]],
        columnDefs: [
			      { width: "40%", targets: 0 },
			      { width: "20%", targets: 1 },
			      { width: "20%", targets: 2 },
			      { width: "10%", targets: 3 },
			      { width: "10%", targets: 4 },
    		],
    } );




		$("#table2").on("click", "#agregaCurso", function(){

      var id 					= $(this).attr('value');
      var ciclo 			= $('#ciclo_'+id).val();
      var aol 				= $('#aol_'+id).val();

			$(this).addClass("btn btn-danger glyphicon glyphicon-ok");

			$.ajax({
      	type: "POST",
        url: "nivelAporteGrabar.php",
        data: "idCurso="+id+"&ciclo="+ciclo+"&aol="+aol,

				beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
		  	},

				success: function(datos){
					$("#resultados").html(datos);
				}

			});

		});

	});
</script>
