<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];
$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idMalla = (isset($_REQUEST['idMalla']) && !empty($_REQUEST['idMalla']))?$_REQUEST['idMalla']:'';
$q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';
$idDpto = (isset($_REQUEST['idDepartamento']) && !empty($_REQUEST['idDepartamento']))?$_REQUEST['idDepartamento']:'';
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

				<!--  <div class = "alert alert-success msj" style="text-align:center;">Curso agregado correctamente!!</div> -->

					<div id = "admin_table">


						<table id = "table2" class = "table table-bordered table-hover" style="100%">

							<thead class = "alert-info">
								<tr>
									<th >Curso</th>
                                                                        <th>Código UP</th>
                                                                        <th>Tipo curso</th>
									<th>Departamento académico</th>
									<th>Ciclo</th>
                                <th>Obligatoriedad</th>
                                <th>AoL</th>

                                                                        <th>Agregar</th>
								</tr>
							</thead>
							<tbody>
							<?php

								$q_admin = $conn->query("select * from curso $sWhere") or die(mysqli_error($conn));
								while($row = $q_admin->fetch_array()){ //abre while
                                                                    $idCurso=$row['idCurso'];
                                                                    $codUpCurso=$row['codUpCurso'];
                                                                    $nombreCurso=$row['nombreCurso'];
                                                                    $tipoCurso=$row["tipoCurso"];
                                                                    $idDepartamento = $row["idDepartamento"];

                                                                    $sql=$conn->query("select * from detalle_malla where idCurso= '" .$idCurso . "' and idCarrera= '" .$idCarrera . "' and idMalla='".$idMalla."'");
                                                                    $fila2 = $sql->fetch_assoc();



					if ($sql->num_rows>0){
						$var = "btn btn-danger glyphicon glyphicon-ok";
						$ciclo = $fila2["ciclo"];
						$aol = $fila2["aol"];
						$obligatorio = $fila2["obligatoriedad"];

					} else {
						$var ="btn btn-success glyphicon glyphicon-plus";
						$ciclo="";
						$aol="";
						$obligatorio="";
					}
                                                                $result = $conn->query("SELECT descripcion FROM departamento where idDepartamento = '" . $idDepartamento . "'");
                                                                $fila = $result->fetch_assoc();
							?>
								<tr class = "target">
                                                                          <td><?php echo $nombreCurso?></td>
									<td><?php echo $codUpCurso?></td>
									<td><?php echo ($tipoCurso==1) ? "Académico" : "Para-académico"?></td>
									<td><?php echo $fila['descripcion']?></td>
									<td class='col-xs-1'>
						<div class="pull-right">
						
						<!--<input type="text" class="form-control" style="text-align:right" id="ciclo_<?php echo $idCurso; ?>"  value="<?php echo $ciclo;?>" >-->
						
						<input type="number" name="quantity" placeholder="0-12" min="0" max="12" step="1" id="ciclo_<?php echo $idCurso; ?>" value="<?php echo $ciclo;?>" style="width:45px;">
						
						</div>
                                                </td>


						<td class='col-xs-2'>
						<div class="pull-right">
						<select name = "obligatorio_<?php echo $idCurso; ?>" id = "obligatorio_<?php echo $idCurso; ?>" required = "required">

							<?php
                                                                    if($obligatorio =='1'){
                                                                        echo "<option value = '1' selected = 'selected'>Obligatorio</option>";
                                                                        echo "<option value = '2'>Electivo</option>";
                                                                        }
                                                                    if($obligatorio =='2'){
                                                                        echo "<option value = '1'>Obligatorio</option>";
                                                                        echo "<option value = '2' selected = 'selected'>Electivo</option>";
                                                                        }
                                                                if($obligatorio ==''){
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
						<!-- <option value = "" selected = "selected">Seleccione</option> -->
							<?php
                                                                if($aol =='1'){
								 echo "<option value = '1' selected = 'selected'>Si</option>";
                                                                    echo "<option value = '0'>No</option>";
                                                                 }
                                                                 elseif($aol =='0'){
								 echo "<option value = '1'>Si</option>";
                                                                    echo "<option value = '0' selected = 'selected'>No</option>";
                                                                 }
								else{
                                                                    echo "<option value = '' selected = 'selected'>Seleccione</option>";
                                                                    echo "<option value = '1'>Si</option>";
                                                                    echo "<option value = '0'>No</option>";
                                                                 }

							?>


						</select>
						</div>
						</td>

									<td>

                                                            <input type="hidden" id="idCarreraf" value="<?php echo $idCarrera;?>"/>
                                                            <input type="hidden" id="idMallaf"value="<?php echo $idMalla;?>"/>
                                                               <a id="agregaCurso" class="<?php echo $var;?>" href="#" value="<?php echo $idCurso;?>"></a>

									</td>




								</tr>
							<?php
								} //cierra while
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
      { width: "15%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "10%", targets: 3 },
      { width: "10%", targets: 4 },
      { width: "10%", targets: 5 },
      { width: "10%", targets: 6 },
      { width: "10%", targets: 7 },
    ],

    } );

   /* $('.msj').hide();*/

     $("#table2").on("click", "#agregaCurso", function(){



                        var id = $(this).attr('value');
                        var idMalla = $("#idMallaf").attr('value');
                        var idCarrera = $("#idCarreraf").attr('value');
                        var ciclo = $('#ciclo_'+id).val();
                        var obligatorio = $('#obligatorio_'+id).val();
                        var aol = $('#aol_'+id).val();

			//Inicia validacion
			if (isNaN(ciclo))
			{
			alert('El dato no es válido.');
			$('#ciclo_'+id).focus();
           $('#ciclo_'+id).css("border", "3px solid red");
			return false;
		} else {
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

                         if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus")

                        $(this).addClass("btn btn-danger glyphicon glyphicon-ok");

                        /*if ($("#agregaCurso_"+id).attr("class") == "btn btn-danger")
                        $("#agregaCurso_"+id).addClass("btn btn-success");*/


			$.ajax({
        type: "POST",
        url: "./ajax/agregar_facturacion2.php",
        data: "idCu="+id+"&ciclo="+ciclo+"&obligatorio="+obligatorio+"&aol="+aol+"&idCa="+idCarrera+"&idMalla="+idMalla+"&op=I",
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
