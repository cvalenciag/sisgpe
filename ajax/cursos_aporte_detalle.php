<?php

require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idDepto			= (isset($_REQUEST['idDepto']) && !empty($_REQUEST['idDepto']))?$_REQUEST['idDepto']:'';
$idCarrera		= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$obliga 			= (isset($_REQUEST['obligatorio']) && !empty($_REQUEST['obligatorio']))?$_REQUEST['obligatorio']:'';
$fechaMalla		= (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$fechaPerfil	= (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';
$idPerfil			= (isset($_REQUEST['idPerfilEgresado']) && !empty($_REQUEST['idPerfilEgresado']))?$_REQUEST['idPerfilEgresado']:'';

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
	<table id="table2Edit" class="table table-bordered table-hover" style="width:100%;">
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

				<?php
					$idCursoEdit = $f_admin['idCurso'];

					$sql=$conn->query("SELECT * FROM detalle_perfilegresado_curso WHERE idPerfilEgresado='".$idPerfil."' AND idCurso='".$idCursoEdit."' AND eliminado=0");

					// $fila2 = $sql->fetch_assoc();

					if ($sql->num_rows>0){
						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

					} else {
						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";
					}
				?>

				<td class="text-center">
					<button type="button" name="button" id="agregaCursoEdit" class="<?php echo $var ?>" value="<?php echo $f_admin['idCurso'];?>"></button>

					<input type="hidden" name="" value="<?php echo $idCarrera ?>" 	id="idCarrera2">
					<input type="hidden" name="" value="<?php echo $fechaMalla ?>"  id="fAprobacionMalla2">
					<input type="hidden" name="" value="<?php echo $fechaPerfil ?>" id="fAprobacionPerfil2">
					<input type="hidden" name="" value="<?php echo $idPerfil ?>" 		id="idPerfil2">

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
		$('#table2Edit').DataTable( {
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

  


		$("#table2Edit").on("click", "#agregaCursoEdit", function(){

      var id 					= $(this).attr('value');
      var xIdCarrera	= $('#idCarrera2').val();
      var xDateMalla	= $('#fAprobacionMalla2').val();
      var xDatePerfil	= $('#fAprobacionPerfil2').val();
      var xIdPerfil		= $('#idPerfil2').val();

			$(this).addClass("btn btn-danger glyphicon glyphicon-ok");

			$.ajax({
      	type: "POST",
        url: "./ajax/agregar_nivelAporte3.php",
        data: "xIdPerfil="+xIdPerfil+"&xIdCurso="+id+"&xCarrera="+xIdCarrera+"&xFechaMalla="+xDateMalla+'&xFechaPerfil='+xDatePerfil+'&op=E',

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
