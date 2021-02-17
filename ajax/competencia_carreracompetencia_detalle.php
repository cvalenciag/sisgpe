<?php
	require_once '../valid.php';
     $session_id= $_SESSION['session_id'];
	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){*/

 $idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
		 $idCarreraCompetencia = (isset($_REQUEST['idCarreraCompetencia']) && !empty($_REQUEST['idCarreraCompetencia']))?$_REQUEST['idCarreraCompetencia']:'';

		 $q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';

		 	 $idTipo = (isset($_REQUEST['idTipo']) && !empty($_REQUEST['idTipo']))?$_REQUEST['idTipo']:'';

                $qfila = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera' ORDER BY descripcion") or die(mysqli_error($conn));

                  $fcarre = $qfila->fetch_assoc();

		 $sWhere = "";


		/*if ( $q != "" && is_null($idTipo) )*/
		if ( $q != ""  && $idTipo == "" )
		{
			$sWhere = "WHERE descripcion LIKE '%$q%' and estado = '1' order by descripcion asc";

		}

		elseif ( $q == "" && $idTipo > 0)
		{
			$sWhere = "WHERE idTipo = '$idTipo' and estado = '1' order by descripcion asc";
		}
		elseif ( $idTipo != "" && $q != "")

		{
			$sWhere = "WHERE (descripcion LIKE '%$q%') AND idTipo = '$idTipo' and estado = '1' order by descripcion asc";
		}
		else
		{
			$sWhere = " where estado = '1' order by descripcion asc";
		}

		      ?>

                <label style="font-size:20px !important;color:#286090;font-family:Century Gothic;"><?php echo "Carrera: " . $fcarre['descripcion']; ?></label><br/>

		<!--  <div class = "alert alert-success msj" style="text-align:center;">Competencia agregada correctamente!!</div> -->

<div id = "admin_table">

				<table id = "table2" class = "table table-bordered table-hover" style="width: 100%;">

					<thead class = "alert-info">
						<tr>
							<th class="text-center">Competencia</th>
              <th class="text-center">Tipo de competencia</th>
							<th class="text-center">Ordenamiento</th>
							<th class="text-center">Agregar</th>
				</tr>
			</thead>
							<tbody>
				<?php

				$q_admin = $conn->query("select * from competencia $sWhere") or die(mysqli_error($conn));
					while($row = $q_admin->fetch_array()){
					$idCompetencia=$row['idCompetencia'];
					$descripcion=$row['descripcion'];
					$idTipo=$row['idTipo'];
				   /* $result = $conn->query("SELECT descripcion as tdescripcion FROM tipocompetencia where idTipo = '" . $idTipo . "'");
					$fila = $result->fetch_assoc();*/

$sql=$conn->query("select * from detalle_carrera_competencia where idCompetencia= '" .$idCompetencia . "' and idCarrera= '" .$idCarrera . "' and idCarreraCompetencia='".$idCarreraCompetencia."'");

					$fila2 = $sql->fetch_assoc();

$ordenamiento = $fila2["ordenamiento"];

					if ($sql->num_rows>0){
						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

					} else {
						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";

					}
$result = $conn->query("SELECT descripcion as tdescripcion FROM tipocompetencia where idTipo = '" . $idTipo . "'");
					$fila = $result->fetch_assoc();
					/*$fila = $result->fetch_assoc();*/
					?>




				<tr class = "target">

						<td><?php echo $descripcion; ?></td>
                        <td><?php echo $fila["tdescripcion"]; ?></td>
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="ordenamiento_<?php echo $idCompetencia; ?>"  value="<?php echo $ordenamiento;?>" >
						</div></td>


						<td class="text-center">

                                                            <input type="hidden" id="idCarreraf" value="<?php echo $idCarrera;?>"/>
                                                            <input type="hidden" id="idCarreraCompetenciaf"value="<?php echo $idCarreraCompetencia;?>"/>
                                                               <a id="agregaCC" class="<?php echo $var;?>" href="#" value="<?php echo $idCompetencia;?>"></a>

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
      { width: "20%", targets: 3 },
    ],

    } );

 /*   $('.msj').hide();*/

     $("#table2").on("click", "#agregaCC", function(){

     var id = $(this).attr('value');
                        var idCarreraCompetencia = $("#idCarreraCompetenciaf").attr('value');
                        var idCarrera = $("#idCarreraf").attr('value');
                        var ordenamiento = $('#ordenamiento_'+id).val();

     if (isNaN(ordenamiento))
			{
			alert('El dato no es válido');
			document.getElementById('ordenamiento_'+id).focus();
			$('#ordenamiento_'+id).css("border", "3px solid red");
			return false;
		}else {
			$('#ordenamiento_'+id).css("border", "");
		}


			if (ordenamiento == '')
			{
			alert('El dato no debe estar vacío');
			document.getElementById('ordenamiento_'+id).focus();
			$('#ordenamiento_'+id).css("border", "3px solid red");
			return false;
		}else {
			$('#ordenamiento_'+id).css("border", "");
		}
		/*	else if (empty(ordenamiento))
			{
			alert('El dato no debe estar vacío');
			document.getElementById('ordenamiento_'+id).focus();
			return false;
			}*/
			//Fin validacion
			  if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus")
                        	/*$(this).removeClass("btn btn-success glyphicon glyphicon-plus");*/
                        $(this).addClass("btn btn-danger glyphicon glyphicon-ok");

                        $.ajax({

                         type: "POST",
        url: "./ajax/agregar_carreracompetencia2.php",
        data: "idCo="+id+"&ordenamiento="+ordenamiento+"&idCa="+idCarrera+"&idCarreraCompetencia="+idCarreraCompetencia+"&op=I",
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		 /* $('.msj').show();*/
		}
                });
		});




} );
</script>
