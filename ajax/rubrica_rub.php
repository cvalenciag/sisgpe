<?php
	require_once '../valid.php';
     $session_id= $_SESSION['session_id'];
	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){*/

$idRubrica   		= (isset($_REQUEST['idRubrica']) && !empty($_REQUEST['idRubrica']))?$_REQUEST['idRubrica']:'';
$idObjgeneral   = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$idCompetencia  = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$idCriterio     = (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';
$idCurso        = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';

$qfila = $conn->query("SELECT descripcion FROM subcriterio where estado=1 and idCriterio='$idCriterio' ORDER BY descripcion") or die(mysqli_error($conn));

$qfila1 = $conn->query("SELECT definicion, descripcion FROM competencia where estado=1 and idCompetencia='$idCompetencia'") or die(mysqli_error($conn));

$qfila2 = $conn->query("SELECT definicion FROM objgeneral where estado=1 and idObjgeneral='$idObjgeneral'") or die(mysqli_error($conn));

$qfila3 = $conn->query("SELECT definicion FROM criterio where estado=1 and idCriterio='$idCriterio'") or die(mysqli_error($conn));

$fcarre = $qfila->fetch_assoc();
$fcarre1 = $qfila1->fetch_assoc();
$fcarre2 = $qfila2->fetch_assoc();
$fcarre3 = $qfila3->fetch_assoc();

// $sWhere = "";
// if ( $q != "" )
// {
//   $sWhere = "WHERE descripcion LIKE '%$q%' and estado = '1'";
// }else{
//   $sWhere = " where estado='1' order by descripcion asc";
// }

?>

<div class="" style="margin-top:-40px;">
  <table>
    <tr>
      <td style="width:50%;"><label>Competencia:</label>  <?php echo $idCompetencia!='' ? $fcarre1['descripcion'] : 'No aplica' ?> </td>
    </tr>
    <br>
    <tr>
      <td style="width:50%;"><label>Objetivo de aprendizaje general:</label>  <?php echo $idObjgeneral!='' ? $fcarre2['definicion'] : 'No aplica' ?> </td>
    </tr>
    <br>
    <tr>
      <td style="width:50%;"><label>Criterio:</label> <?php echo $fcarre3['definicion']; ?> </td>
    </tr>
  </table>
</div>


<!-- <div class = "alert alert-success msj" style="text-align:center;">Objetivo específico agregado correctamente!!</div> -->
<br>
<div id = "admin_table">
  <table id="table25" class = "table table-bordered table-hover" style="width: 100%;">
    <thead class = "alert-info">
      <tr>
        <th class="text-center">Descripción de Nivel</th>
        <th class="text-center">Orden de Nivel</th>
        <th class="text-center">Rotulo de Nivel</th>
        <th class="text-center">Puntaje</th>
        <th></th>
			</tr>
		</thead>
    <tbody>
      <?php
				$q_admin = $conn->query("SELECT * FROM subcriterio WHERE idCriterio='$idCriterio'") or die(mysqli_error($conn));

					while($row = $q_admin->fetch_array())
          {
					  $idSubcriterio   = $row['idSubcriterio'];
            $descripcion     = $row['descripcion'];

					$sql=$conn->query("SELECT * FROM tmp WHERE fAprobacion= '" .$fAprobacion . "' AND idSubcri='".$idSubcriterio."' AND idSession='".$session_id."'");
					$fila2 = $sql->fetch_assoc();
					// $sql=$conn->query("SELECT * FROM tmp WHERE idCurso= '" .$idCurso . "' and idObjgeneral= '" .$idObjgeneral . "' and fAprobacion= '" .$fAprobacion . "' and idSubcri='".$idSubcriterio."' and idSession='".$session_id."'");
					// $fila2 = $sql->fetch_assoc();

					if ($sql->num_rows>0){
						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

						$ordNivel = $fila2["ordNivel"];
						$idNivel = $fila2["idNivel"];
						$puntaje = $fila2["puntajeRango"];
					} else {
						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";

            $ordNivel = "";
						$idNivel = "";
						$puntaje = "";
					}

					/*$fila = $result->fetch_assoc();*/
					?>
				<tr class = "target">

						<td><?php echo $descripcion ?></td>
						<td class='col-xs-1'>
              <div class="pull-right">
                <input type="text" onkeypress="return justNumbers(event);" class="form-control" style="width:55px;" id="ordenNivel_<?php echo $idSubcriterio; ?>"  value="<?php echo $ordNivel;?>" >
              </div>
            </td>

					  <td class="text-center">
					    <select name="idNivel" id="idNivel_<?php echo $idSubcriterio; ?>" required="required" style="width:165px;">
					    		<?php

									$qryNiveles = $conn->query("SELECT * FROM nivel WHERE estado=1") or die(mysqli_error($conn));

									?>

									<option value="" selected='selected'>Seleccione una opción</option>

									<?php
									foreach ($qryNiveles as $niveles)
									{
										$selected = '';
										if($idNivel == $niveles['idNivel']){
											$selected = "selected=selected";
										}
									?>
										<option value="<?php echo $niveles['idNivel'] ?>" <?php echo $selected ?>><?php echo $niveles['descripcion'] ?></option>
									<?php
									}

									// if($idNivel==1){
									// 	echo "<option value = '1' selected = 'selected'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }if ($idNivel==2) {
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2' selected = 'selected'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }if($idNivel==3){
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3' selected = 'selected'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }if($idNivel==4){
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4' selected = 'selected'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }if($idNivel==5){
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5' selected = 'selected'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }if($idNivel==6){
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6' selected = 'selected'>Suficiente</option>";
									// }if($idNivel==''){
									// 	echo "<option value = '' selected = 'selected'>Seleccione una opción</option>";
									// 	echo "<option value = '1'>Desaprobado</option>";
									// 	echo "<option value = '2'>Regular</option>";
									// 	echo "<option value = '3'>Bueno</option>";
									// 	echo "<option value = '4'>Sobresaliente</option>";
									// 	echo "<option value = '5'>Insuficiente</option>";
									// 	echo "<option value = '6'>Suficiente</option>";
									// }
		            ?>
					    </select>
					  </td>


      		<td class='col-xs-1'>
						<div class="pull-right">
							<input type="number" onkeypress="return justNumbers(event);" class="form-control" style="width:65px;" id="puntaje_<?php echo $idSubcriterio; ?>" min="1" max="10"  value="<?php echo $puntaje; ?>" >
						</div>
					</td>


            <td class="text-center">
              <input type="hidden" id="idRubricaMod" value="<?php echo $idRubrica;?>"/>
              <input type="hidden" id="idCursoMod" value="<?php echo $idCurso;?>"/>
              <input type="hidden" id="idCompetenciaMod" value="<?php echo $idCompetencia;?>"/>
              <input type="hidden" id="idObjgeneralMod" value="<?php echo $idObjgeneral;?>"/>
              <input type="hidden" id="idCriterioMod" value="<?php echo $idCriterio;?>"/>
              <input type="hidden" id="fAprobacionMod" value="<?php echo $fAprobacion;?>"/>

              <a id="agregaDetRubricaNew_<?php echo $idSubcriterio ?>" class="<?php echo $var ?>" href="#" value="" onclick="saveDetalleRNew(this.id);"></a>

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
    $('#table25').DataTable( {
        "pageLength": 5,
				"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Lfrtip',
		lengthMenu: [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Mostrar todos' ]],
        columnDefs: [
      { width: "75%", targets: 0 },
      { width: "5%",  targets: 1 },
      { width: "10%", targets: 2 },
      { width: "5%",  targets: 3 },
      { width: "5%",  targets: 4 },
    	],
  	});

	});

    // $('.msj').hide();

     // $("#table2").on("click", "#agregaDetRubrica", function(){
     function saveDetalleRNew(idNew){
     	// var id = $(this).attr('value');
      // var xIdSubCriterio  = id;
			arr = idNew.split('_');
			xName = arr[0];
			id = arr[1];

      var xIdRubrica      = $("#idRubricaMod").val();
      var xIdCurso        = $("#idCursoMod").val();
      var xIdCompetencia  = $("#idCompetenciaMod").val();
      var xIdObjgeneral   = $("#idObjgeneralMod").val();
      var xIdCriterio     = $("#idCriterioMod").val();
      var xfAprobacion    = $("#fAprobacionMod").val();

      var xOrdenNivel     = $("#ordenNivel_"+id).val();
      var xRotuloNivel    = $("#idNivel_"+id).val();
      var xPuntaje        = $("#puntaje_"+id).val();

			if(xRotuloNivel=='' || xRotuloNivel==0){
				alert('Debe seleccionar una opción.');
				$('#idNivel_'+id).css("border", "3px solid red");
				return false;
			}else {
				$('#idNivel_'+id).css("border", "");
			}


			if (isNaN(xOrdenNivel))
			{
			alert('El dato no es válido');
			// document.getElementById('ordenamiento_'+id).focus();
      document.getElementById('ordenNivel_'+id).focus();
      document.getElementById('puntaje_'+id).focus();
			$('#ordenNivel_'+id).css("border", "3px solid red");
			return false;
		}	else {
			$('#ordenNivel_'+id).css("border", "");
		}


			if (xOrdenNivel=='' || xPuntaje=='')
			{
			alert('El dato no debe estar vacío');
			// document.getElementById('ordenamiento_'+id).focus();
      document.getElementById('ordenNivel_'+id).focus();
    document.getElementById('puntaje_'+id).focus();
    $("#ordenNivel_"+id).css("border", "3px solid red");
  $("#puntaje_"+id).css("border", "3px solid red");
			return false;
		}else {
      $("#ordenNivel_"+id).css("border", "");
    $("#puntaje_"+id).css("border", "");
		}

		// $(this).addClass("btn btn-sm btn-danger glyphicon glyphicon-ok");
		// if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus"){
			$('#agregaDetRubricaNew_'+id).addClass("btn btn-sm btn-danger glyphicon glyphicon-ok");
			// $(this).addClass("btn btn-sm btn-danger glyphicon glyphicon-ok");
		// }



    $.ajax({
				type: "POST",
        url: "./ajax/agregar_rubrica1.php",
        data: "idCurso="+xIdCurso+"&idCompetencia="+xIdCompetencia+"&idObjgeneral="+xIdObjgeneral+"&fAprobacion="+xfAprobacion+"&idNivel="+xRotuloNivel+"&idSubcriterio="+id+"&ordenNivel="+xOrdenNivel+"&puntaje="+xPuntaje+'&idRubrica='+xIdRubrica,

				beforeSend: function(objeto){
					$("#resultados").html("Mensaje: Cargando...");
					// $("#resultados").show();
		  	},

				success: function(datos){
					$("#resultados").html(datos);
					/* $('.msj').show();*/
					idError = $("#idWarning").val();
					if(idError==1){
						$('#ordenNivel_'+id).val("");
						$('#agregaDetRubricaNew_'+id).removeClass("btn btn-sm btn-danger glyphicon glyphicon-ok");
						$('#agregaDetRubricaNew_'+id).addClass("btn btn-sm btn-success glyphicon glyphicon-plus");
					}
				}
      });
// 	});
//
// });
}


function justNumbers(e)
{
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
  return true;

  return /\d/.test(String.fromCharCode(keynum));
}
</script>
