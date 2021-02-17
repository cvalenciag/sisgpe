<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];
$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idMalla = (isset($_REQUEST['idMalla']) && !empty($_REQUEST['idMalla']))?$_REQUEST['idMalla']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
$q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';
$idDpto = (isset($_REQUEST['idDpto']) && !empty($_REQUEST['idDpto']))?$_REQUEST['idDpto']:'';

// $delete = mysqli_query($conn, "DELETE FROM tmp");

$qfila = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera' ORDER BY descripcion") or die(mysqli_error($conn));
$fcarre = $qfila->fetch_assoc();

$sWhere = "";


		if ( $q != ""  && $idDpto == "" )
		{
			$sWhere = "WHERE nombreCurso LIKE '%$q%' OR codUpCurso LIKE '%$q%' and";

		}

		elseif ( $q == "" && $idDpto > 0)
		{
			$sWhere = "WHERE idDepartamento = '$idDpto' and";
		}
		elseif ( $idDpto != "" && $q != "")
		{
			$sWhere = "WHERE (nombreCurso LIKE '%$q%' OR codUpCurso LIKE '%$q%') AND idDepartamento = '$idDpto' and";
		}
		else
		{
			$sWhere = " where ";
		}

                $sWhere = $sWhere . " estado ='1' order by nombreCurso asc";
 ?>

		             <label style="font-size:20px !important;color:#286090;font-family:Century Gothic;"><?php echo "Carrera: " . $fcarre['descripcion']; ?></label><br/>


					<div id = "admin_table">


						<table id="table2" class = "table table-bordered table-hover" style="width:100%;">

							<thead class="alert-info">
								<tr>
									<th class="text-center">Curso</th>
									<th class="text-center">Código <br> UP</th>
									<th class="text-center">Tipo <br> curso</th>
									<th class="text-center">Departamento <br> académico</th>
									<th class="text-center">Ciclo</th>
									<th class="text-center">Obligatoriedad</th>
									<th class="text-center">AoL</th>
									<th class="text-center"></th>
								</tr>
							</thead>


							<tbody>
							<?php

								$q_admin = $conn->query("SELECT * FROM curso $sWhere") or die(mysqli_error($conn));
								while($row = $q_admin->fetch_array())
								{
                    $idCurso				=	$row['idCurso'];
                    $codUpCurso			=	$row['codUpCurso'];
                    $nombreCurso		=	$row['nombreCurso'];
                    $tipoCurso			=	$row["tipoCurso"];
                    $idDepartamento	= $row["idDepartamento"];

                    $sql=$conn->query("SELECT * FROM tmp WHERE idCurso='".$idCurso."' AND idCarrera='".$idCarrera."'
																			 AND fAprobacion='".$fAprobacion."' AND idSession='".$session_id."'");

					$fila2 = $sql->fetch_assoc();

					if ($sql->num_rows>0){
						$var = "btn btn-danger btn-sm glyphicon glyphicon-ok";

						$ciclo 				= $fila2["ciclo"];
						$aol 					= $fila2["aol"];
						$obligatorio	= $fila2["obligatorio"];
					} else {
						$var =	"btn btn-success btn-sm glyphicon glyphicon-plus";

						$ciclo				="";
						$aol					="";
						$obligatorio	="";
					}
              $result = $conn->query("SELECT descripcion FROM departamento where idDepartamento = '" . $idDepartamento . "'");
              $fila 	= $result->fetch_assoc();
							?>
								<tr class = "target">
									<td><?php echo $nombreCurso?></td>
									<td><?php echo $codUpCurso?></td>
									<td><?php echo ($tipoCurso==1) ? "Académico" : "Para-académico"?></td>
									<td><?php echo $fila['descripcion']?></td>
									<td class='col-xs-1'>
										<div class="pull-right">
											<input type="number" name="quantity" placeholder="0-12" min="0" max="12" step="1" id="ciclo_<?php echo $idCurso; ?>" value="<?php echo $ciclo;?>" style="width:55px;">
										</div>
									</td>
									<td class='col-xs-2'>
										<div class="pull-right">
											<select name = "obligatorio_<?php echo $idCurso; ?>" id = "obligatorio_<?php echo $idCurso; ?>" required = "required">
												<?php
                            if($obligatorio =='1'){
															echo "<option value = '1' selected = 'selected'>Obligatorio</option>";
															echo "<option value = '2'>Electivo</option>";
														}	if($obligatorio =='2'){
																echo "<option value = '1'>Obligatorio</option>";
																echo "<option value = '2' selected = 'selected'>Electivo</option>";
														}	if($obligatorio ==''){
																echo "<option value = '' selected = 'selected'>Seleccione</option>";
																echo "<option value = '1'>Obligatorio</option>";
																echo "<option value = '2'>Electivo</option>";
														}
												?>
											</select>
										</div>
									</td>


									<td class='col-xs-1'>
										<div class="pull-right">
											<select name = "aol_<?php echo $idCurso; ?>" id = "aol_<?php echo $idCurso; ?>" required = "required">
												<?php
													if($aol =='1'){
								 						echo "<option value = '1' selected = 'selected'>Si</option>";
														echo "<option value = '0'>No</option>";
													}	elseif($aol =='0'){
								 						echo "<option value = '1'>Si</option>";
														echo "<option value = '0' selected = 'selected'>No</option>";
													}	else{
														echo "<option value = '' selected = 'selected'>Seleccione</option>";
                            echo "<option value = '1'>Si</option>";
                            echo "<option value = '0'>No</option>";
													}

												?>
											</select>
										</div>
									</td>

									<td class="text-center">
										<button type="button" name="button" id="agregaCurso" class="<?php echo $var;?>" value="<?php echo $idCurso;?>">

										</button>
                    <!-- <input type="hidden" id="idCarreraf" value="<php echo $idCarrera;?>"/>
                    <input type="hidden" id="idMallaf"value="<php echo $idMalla;?>"/> -->
                    <!-- <input type="hidden" id="fAprobacionf"value="?php echo $fAprobacion;?>"/> -->
										<!-- <a  href="#" ></a> -->
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
      { width: "20%", targets: 0 },
      { width: "13%", targets: 1 },
      { width: "13%", targets: 2 },
      { width: "10%", targets: 3 },
      { width: "22%", targets: 4 },
      { width: "8%", targets: 5 },
      { width: "8%", targets: 6 },
      { width: "7%", targets: 7 },
    ],

    } );

    $('.msj').hide();

     $("#table2").on("click", "#agregaCurso", function(){

      var id = $(this).attr('value');
      // var idMalla = $("#idMallaf").attr('value');
      var idCarrera 	= $("#carrera").val();
      var fAprobacion = $("#fAprobacion").val();
      var fActualizacion	= $("#fActualizacion").val();
      var estado					= $("#estado").val();
      var ciclo 			= $('#ciclo_'+id).val();
      var obligatorio = $('#obligatorio_'+id).val();
      var aol 				= $('#aol_'+id).val();

			//Inicia validacion
			if (isNaN(ciclo))
			{
				alert('El dato no es válido.');
				$('#ciclo_'+id).focus();
				$('#ciclo_'+id).css("border", "3px solid red");
				return false;
			}else {
				$('#ciclo_'+id).css("border", "");
			}
			//Fin validacion

			if ($('#ciclo_'+id).val() == '')
			{
				alert('El dato no debe estar vacío');
				$('#ciclo_'+id).focus();
				$('#ciclo_'+id).css("border", "3px solid red");
				return false;
			}else {
				$('#ciclo_'+id).css("border", "");
			}
			
			if($('#ciclo_'+id).val() % 1 !=0){
				alert("Se permite ingresar sólo numeros enteros entre 0 y 12");
				return false;
			}
			
			if($('#ciclo_'+id).val() >12 ){
				alert("Se permite ingresar sólo numeros enteros entre 0 y 12");
				return false;
			}
			
			if($('#ciclo_'+id).val() < 0 ){
				alert("Se permite ingresar sólo numeros enteros entre 0 y 12");
				return false;
			}
			
			if ( $('#obligatorio_'+id).val() == '')
			{
				alert('El dato no debe estar vacío');
				$('#obligatorio_'+id).focus();
				$('#obligatorio_'+id).css("border", "3px solid red");
				return false;
			}else {
				$('#obligatorio_'+id).css("border", "");
			}

			if ( $('#aol_'+id).val() == '')
			{
				alert('El dato no debe estar vacío');
				$('#aol_'+id).focus();
				$('#aol_'+id).css("border", "3px solid red");
				return false;
			}else {
				$('#aol_'+id).css("border", "");
			}

			// if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus");
			$(this).addClass("btn btn-danger glyphicon glyphicon-ok");

			/*if ($("#agregaCurso_"+id).attr("class") == "btn btn-danger")
				$("#agregaCurso_"+id).addClass("btn btn-success");*/


			$.ajax({
      	type: "POST",
        url: "mallaGrabar1.php",
        data: "idCurso="+id+"&ciclo="+ciclo+"&obligatorio="+obligatorio+"&aol="+aol+"&fAprobacion="+fAprobacion+"&idCarrera="+idCarrera+'&fActualizacion='+fActualizacion+'&estado='+estado,
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
