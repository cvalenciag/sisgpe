<?php
	require_once '../valid.php';
     $session_id= $_SESSION['session_id'];
	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){*/

		$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
		 $idCarreraOg = (isset($_REQUEST['idCarreraOg']) && !empty($_REQUEST['idCarreraOg']))?$_REQUEST['idCarreraOg']:'';

		 $q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';

		 $idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';

		  $idTipo = (isset($_REQUEST['idTipo']) && !empty($_REQUEST['idTipo']))?$_REQUEST['idTipo']:'';
		  $fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';

                $qfila = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera' ORDER BY descripcion") or die(mysqli_error($conn));

                $fcarre = $qfila->fetch_assoc();

               /* $fila = $qfila->fetch_assoc();
                ?>
             <label><?php echo "Carrera: " . $fila['descripcion']; ?></label><br/>

<?php





		 $idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';

		 $sTable = "objgeneral";*/
		 $sWhere = "";
		if ( $q != ""  && $idCompetencia == "" && $idTipo == "")
		{
			$sWhere = "WHERE definicion LIKE '%$q%' and estado = '1' order by definicion asc";

		}

		elseif ( $q == "" && $idCompetencia > 0)
		{
			$sWhere = "WHERE idCompetencia = '$idCompetencia' and estado = '1' order by definicion asc";
		}
		elseif ( $q == "" && $idTipo > 0)
		{
			$sWhere = ", competencia WHERE objgeneral.idCompetencia=competencia.idCompetencia and competencia.idTipo = '$idTipo' and objgeneral.estado = '1' order by objgeneral.definicion asc";
		}
		elseif ( $idCompetencia > 0 && $q != "")
		{
			$sWhere = "WHERE (definicion LIKE '%$q%') AND idCompetencia = '$idCompetencia' and estado = '1' order by definicion asc";
		}
		elseif ( $idTipo > 0 && $q != "")
		{
			$sWhere = ", competencia WHERE objgeneral.idCompetencia=competencia.idCompetencia and (objgeneral.definicion LIKE '%$q%') AND competencia.idTipo = '$idTipo' and objgeneral.estado = '1' order by objgeneral.definicion asc";
		}
		else
		{
			$sWhere = " where estado = '1' order by definicion asc";
		}

		 ?>

		<label style="font-size:20px !important;color:#286090;font-family:Century Gothic;"><?php echo "Carrera: " . $fcarre['descripcion']; ?></label><br/>


			<div class = "alert alert-success msj" style="text-align:center;">Objetivo general agregado correctamente!!</div>

			<div id = "admin_table">

				<table id = "table2" class = "table table-bordered table-hover" style="width: 100%;">

					<thead class = "alert-info">

			  <!-- <table class="table"> -->
				<tr>
					<th class="text-center">Objetivo general</th>
          <th class="text-center">Competencia</th>
          <th class="text-center">Tipo de competencia</th>
          <th class="text-center">Ordenamiento</th>
          <th class="text-center">Agregar</th>
					<!-- <th class='text-center' style="width: 36px;">Agregar</th> -->
				</tr>
				</thead>
							<tbody>
				<?php

$q_admin = $conn->query("select objgeneral.idObjgeneral,objgeneral.definicion,objgeneral.idCompetencia from objgeneral $sWhere") or die(mysqli_error($conn));

				/*if ($numrows>0){*/
			/*	while ($row=mysqli_fetch_array($query)){*/
					while($row = $q_admin->fetch_array()){
					$idObjgeneral=$row['idObjgeneral'];
					$definicion=$row['definicion'];
					$idCompetencia=$row['idCompetencia'];
					/*$result = $conn->query("SELECT c.descripcion as cdescripcion,t.descripcion as tdescripcion FROM competencia c,tipocompetencia t where c.idTipo = t.idTipo and c.idCompetencia = '" . $idCompetencia . "'");
					$fila = $result->fetch_assoc();*/
					$sql=$conn->query("select * from tmp where idObjgeneral= '" .$idObjgeneral . "' and idCarrera= '" .$idCarrera . "' and fAprobacion= '" .$fAprobacion . "' and idSession='".$session_id."'");
					$fila2 = $sql->fetch_assoc();




					if ($sql->num_rows>0){
						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

						$ordenamiento = $fila2["ordenamiento"];
					} else {
						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";

						$ordenamiento = $fila2["ordenamiento"];
					}

					$result = $conn->query("SELECT c.descripcion as cdescripcion,t.descripcion as tdescripcion FROM competencia c,tipocompetencia t where c.idTipo = t.idTipo and c.idCompetencia = '" . $idCompetencia . "'");
					$fila = $result->fetch_assoc();

					/*$fila = $result->fetch_assoc();*/
					?>


					<tr class = "target">

						<td><?php echo $definicion; ?></td>
                       <td><?php echo $fila["cdescripcion"]; ?></td>
                        <td><?php echo $fila["tdescripcion"]; ?></td>
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="ordenamiento_<?php echo $idObjgeneral; ?>"  value="<?php echo $ordenamiento;?>" >
						</div></td>

						<td class="text-center">

                                                            <input type="hidden" id="idCarreraf" value="<?php echo $idCarrera;?>"/>
															<input type="hidden" id="idCompetenciaf" value="<?php echo $idCompetencia;?>"/>
                                                            <input type="hidden" id="idCarreraOgf"value="<?php echo $idCarreraOg;?>"/>
															<input type="hidden" id="fAprobacionf"value="<?php echo $fAprobacion;?>"/>

      <a id="agregaCO" class="<?php echo $var;?>" href="#" value="<?php echo $idObjgeneral;?>"></i></a>

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

    $('.msj').hide();

     $("#table2").on("click", "#agregaCO", function(){

       					var id = $(this).attr('value');
                        var idCarreraOg = $("#idCarreraOgf").attr('value');
                        var idCarrera = $("#idCarreraf").attr('value');
						var idCompetencia = $("#idCompetenciaf").attr('value');
                        var fAprobacion = $("#fAprobacionf").attr('value');
                        var ordenamiento = $('#ordenamiento_'+id).val();

                        if (isNaN(ordenamiento))
			{
			alert('Esto no es un numero');
			document.getElementById('ordenamiento_'+id).focus();
                        $('#ordenamiento_'+id).css("border", "3px solid red");
			return false;
		} else {
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
			 // if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus")

                        $(this).addClass("btn btn-danger glyphicon glyphicon-ok");

                        $.ajax({

			//Fin validacion

        type: "POST",
        url: "./ajax/agregar_carreraog.php",
        data: "idObjgeneral="+id+"&ordenamiento="+ordenamiento+"&idCarrera="+idCarrera+"&idCarreraOg="+idCarreraOg+"&fAprobacion="+fAprobacion+"&idCompetencia="+idCompetencia,
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
