<?php
	require_once 'valid.php';
?>
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Diseño curricular / Mallas curriculares</div>
					<button id="add_admin" type="button" class="btn btn-primary"><span class = "glyphicon glyphicon-plus">
						</span> Agregar nuevo</button>
					<button id="show_admin" type="button" style="display:none;" class="btn btn-primary">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>

					<br><br>
					<?php
						$sqlTempo = $conn->query("SELECT * FROM tmp") or die(mysqli_error($conn));
						if ($sqlTempo->num_rows>0){
							$delete=mysqli_query($conn, "DELETE FROM tmp");
						}
					?>

					<div id="admin_table">
					<label>Descargar</label>
                        <?php include("modal/ver_cursos2.php"); ?>
						<table id="table" class="table table-bordered table-hover" style="width: 100%;">
							<thead class="alert-info">
								<tr>
									<th class="text-center" style="vertical-align:middle;">Carrera</th>
                  <th class="text-center" style="vertical-align:middle;">Fecha de aprobación</th>
									<th class="text-center" style="vertical-align:middle;">Fecha de actualización</th>
                	<th class="text-center" style="vertical-align:middle;">Cantidad de cursos</th>
									<th class="text-center" style="vertical-align:middle;">Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php
								if($_SESSION['rol_id']==1)
                  $rol="";
                else
                  $rol=" and m.estado=1";

								// $q_admin = $conn->query("SELECT m.idMalla, c.descripcion as carrera,m.fAprobacion,m.fActualizacion,m.estado FROM malla m, carrera c where m.idCarrera=c.idCarrera and m.eliminado='0'". $rol) or die(mysqli_error($conn));
								$q_admin = $conn->query("SELECT m.idMalla, m.IdCarrera, m.estado, c.descripcion as carrera, m.fAprobacion, m.fActualizacion FROM malla m, carrera c WHERE m.idCarrera=c.idCarrera AND m.eliminado='0' order by c.descripcion, m.fAprobacion desc") or die(mysqli_error($conn));


								while($f_admin = $q_admin->fetch_array()){
									$idMalla = $f_admin['idMalla'];
									$result = $conn->query("SELECT COUNT(*) total FROM detalle_malla where idMalla = '" . $idMalla . "' and eliminado='0'");
									$numReg = $result->fetch_assoc();
							?>
								<tr class="target">
									<td><?php echo $f_admin['carrera']?></td>
									<td><?php echo $f_admin['fAprobacion']?></td>
									<td><?php echo $f_admin['fActualizacion']?></td>
                  <td><?php echo $numReg['total'];?></td>

									<div style = "float:left;">
										<td>
										<?php if ($f_admin['estado']==1){
											echo "Activo";
											$btnclas="btn-danger btn-sm";
                      $title="Desactivar Registro";
											$estado=0;
										}else {
											echo "Inactivo";
											$btnclas="btn-success btn-sm";
											$title="Activar registro";
											$estado=1;
										}
										?>
									</div>

									<div style = "float:right;">

										<button type="button" name="button" class="btn btn-success btn-sm vadmin_id" data-toggle="modal" data-target="#vercursos2" value="<?php echo $f_admin['idMalla']?>">
											<span class="glyphicon glyphicon-search" title="Ver Registro"></span>
										</button>

										<button type="button" name="button" class="btn btn-editar btn-sm eadmin_id" value="<?php echo $f_admin['idMalla']?>">
											<span class = "glyphicon glyphicon-edit" title="Editar Registro"></span>
										</button>

										<button type="button" name="button" class="btn <?php echo $btnclas?> deladmin_id" value="<?php echo $f_admin['idMalla']?>">
											<span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
										</button>

										<!-- <a href = "#"   >
											<span class="glyphicon glyphicon-search" title="Ver registro"></span> </a> -->
										<!-- <a href = "#" >
											 </a> -->
										<!-- <a href = "#" >
										</a> -->
									</div>
										</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>

				<div id="edit_form"></div>
					<div id="admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
              <?php
                include("modal/buscar_cursos.php");
							?>

							<!-- <form id="formcarrera" method="POST" action="mallaGrabar2.php" enctype="multipart/form-data"> -->
							<div class = "form-group">
                <label>Facultad:</label><br/>
								<select name="idFacultad" id="facultad" required = "required">
									<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qborrow = $conn->query("SELECT idFacultad,descripcion FROM facultad where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
											while($fborrow = $qborrow->fetch_array()){
										?>
									<option value = "<?php echo $fborrow['idFacultad']?>"><?php echo $fborrow['descripcion']?></option>
										<?php
											}
										?>
								</select>
							</div>

            	<div class = "form-group">
              	<label>Carrera:</label><br/>
									<select class="" name="carrera" id="carrera">
										<option value="">Seleccione una opción</option>
									</select>
							</div>

							<div class = "form-group">
								<label>Fecha de aprobación:</label><br/>
								<!--	<input type="date" name="fAprobacion"  id="fAprobacion" value="<?php echo date("Y-m-d");?>" />-->
                <input type="text" name = "fAprobacion" id = "fAprobacion" readonly value="<?php echo date("Y-m-d");?>"/>
              </div>

							<div class = "form-group">
								<label>Fecha de actualización:</label><br/>
						<!--<input type="date" name="fActualizacion"  id="fActualizacion" value="<?php echo date("Y-m-d");?>" />-->
               <input type="text" name = "fActualizacion" id = "fActualizacion" readonly value="<?php echo date("Y-m-d");?>"/>
							</div>

							<div class="form-group">
								<label>Estado:</label><br/>
								<select name="estado" id="estado">
									<option value="1" selected="selected">Activo</option>
									<option value="0">Inactivo</option>
								</select>
							</div>

							<!-- <input type="hidden" id="idTmp" name="idTmp" value=""/> -->
							<button type="button" id="btnAddCurso" class="btn btn-default addcurso" data-toggle="modal"
							data-target="#myModal" onclick="validarDatos();">
							<span class="glyphicon glyphicon-search"></span> Agregar Cursos
							</button>

							<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

							<div class="form-group">
								<button id="btnRegistrar" class="btn btn-primary" name="" onclick="saveMalla();">
									<span class="glyphicon glyphicon-save"></span> Registrar
								</button>
							</div>


							<!-- <div class="form-group">
								<table>
									<tr>
										<td>

										</td>
										<td>&nbsp&nbsp&nbsp&nbsp&nbsp</td>
										<td>

										</td>
									</tr>
								</table>
							</div> -->


							<!-- </form> -->
						</div>
					</div>
			</div>
		</div>
		<br />
		<br />
		<br />

		<?php require("footer.php"); ?>

<script type="text/javascript" src="js/nueva_factura.js"></script>
<script type="text/javascript">
	$(function() {
  	$("#fAprobacion").datepicker({
    	showOn: "button",
      buttonImage: "images/calendario.png",
      buttonImageOnly: true,
      dateFormat: 'yy-mm-dd',
      buttonText: "Select date"
    });

    $("#fActualizacion").datepicker({
      showOn: "button",
      buttonImage: "images/calendario.png",
      buttonImageOnly: true,
      dateFormat: 'yy-mm-dd',
      buttonText: "Select date"
    });

  });
</script>


<!-- GRABA DATOS ERE -->
<script type="text/javascript">

$(document).ready(function(){
	$('#fActualizacion').on('change', function(){
		xFAprobacion 		= $('#fAprobacion').val();
		xFActualizacion	= $('#fActualizacion').val();

		if(xFAprobacion > xFActualizacion)
		{
		 	alert('La fecha de actualización debe ser igual o posterior a la fecha de aprobación.');
			$('#fActualizacion').css("border", "3px solid red");
			$("#btnAddCurso").attr("disabled", true);
			$("#btnRegistrar").attr("disabled", true);
		  return false;
	  }else {
			$('#fActualizacion').css("border", "");
			$("#btnAddCurso").attr("disabled", false);
			$("#btnRegistrar").attr("disabled", false);
		}

	});

});

function validarDatos(){
	var xFacultad 			= $('#facultad').val();
	var xCarrera				=	$('#carrera').val();
	var xFAprobacion		= $("#fAprobacion").val();
	var xFActualizacion	= $("#fActualizacion").val();
	var xEstado					= $('#estado').val();

	$.ajax({
  	type:'POST', //aqui puede ser igual get
    url: './ajax/validacionDetalles.php',//aqui va tu direccion donde esta tu funcion php
    data: "&idCarrera="+xCarrera+"&fAprobacion="+xFAprobacion+"&estado="+xEstado+"&fActualizacion="+xFActualizacion,//aqui tus datos

		beforeSend: function(objeto){
      $("#resultados").html("Mensaje: Cargando...");
		},

		success: function(datos){
			$("#resultados").html(datos);
			if (($("#idResult").val()) == 1){
				$('#myModal').modal('hide');
				alert("La carrera seleccionada ya se encuentra registrada en el sistema. Modifique la fecha de actualización.");
				// $('#btnRegistrar').attr("disabled", true);

			}else{
				$('#btnRegistrar').attr("disabled", false);
			}

    }
	});
}


function saveMalla(){

	var xFacultad 			= $('#facultad').val();
	var xCarrera				=	$('#carrera').val();
	var xFAprobacion		= document.getElementById("fAprobacion").value;
	var xFActualizacion	= document.getElementById("fActualizacion").value;
	var xEstado					= $('#estado').val();


	$.ajax({
		type: 'POST',
		url: 'mallaGrabar2.php',
		// data: "&facultad="+xFacultad+"&carrera="+xCarrera+"&fActualizacion="+xFActualizacion+"&estado="+xEstado,
		data:"&facultad="+xFacultad+"&idCarrera="+xCarrera+"&fAprobacion="+xFAprobacion+"&estado="+xEstado+"&fActualizacion="+xFActualizacion,

		beforeSend: function(objeto){
	      $("#resultados").html("Mensaje: Cargando...");
			},

		success: function(datos){
			$("#resultados").html(datos);

				if ( ($("#idResult").val()) == 2){
					alert("Debe registrar el detalle de cursos antes de grabar la malla.");
					$('#btnRegistrar').attr("disabled", true);

				}else{
					$('#btnRegistrar').attr("disabled", false);
				}

		  }

	});



}
</script>



<script type = "text/javascript">
  $(document).ready(function() {
  $('#table').DataTable( {
		"language": {
    	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },

		dom: 'Bfrtip',
			buttons: [
			{
				extend: 'pdf',
				text: '<img src="images/pdf.png" width=20 height=20/>',
				titleAttr: 'Exportar a pdf'
			},
			{
				extend: 'excel',
				text: '<img src="images/xls.png" width=20 height=20/>',
				titleAttr: 'Exportar a excel'
			},
			{
				extend: 'csv',
				text: '<img src="images/csv.png" width=20 height=20/>',
				titleAttr: 'Exportar a csv'
			},
			{
				extend: 'print',
				text: '<img src="images/print.png" width=20 height=20/>',
				titleAttr: 'Imprimir'
			}],
			columnDefs: [
    		{ width: "35%", targets: 0 },
    		{ width: "15%", targets: 1 },
    		{ width: "15%", targets: 2 },
    		{ width: "10%", targets: 3 },
    		{ width: "25%", targets: 4 },
  		],
  	});
	});
</script>


<script type = "text/javascript">

	$(document).ready(function (){
		$('#btnRegistrar').attr("disabled", true);
		// $('#btnAddCurso').attr("disabled", true);
		$('#add_admin').click(function(){
			$(this).hide();
			$('#admin_table').slideUp(); //OCULTA TABLA DE RESULTADOS
			$('#show_admin').show(); // MUESTRA BOTON VOVLER
			$('#admin_form').slideDown(); //MUESTRA DATOS A AGREGAR
			// $('#btnRegistrar').attr("disabled", true);
			// $('#btnAddCurso').attr("disabled", true);
		});


		$('#show_admin').click(function(){
			$(this).hide();
			$('#admin_table').slideDown();
			// $('#formcarrera')[0].reset();
			$('#add_admin').show();
			$('#admin_form').slideUp();
			window.location = 'malla.php';
		});
	});
</script>


<script>
	$(document).ready(function(){
	function load(page){
		var q= $("#q").val();
		var carrera= $("#carrera").val();
		var idMalla= $("#idMalla").val();
		var fAprobacion= $("#fAprobacion").val();

			$("#loader").fadeIn('slow');

			$.ajax({
				url:'./ajax/cursos_malla.php?action=ajax&page='+page+'&q='+q+'&idCarrera=' + carrera +'&idMalla=' + idMalla+'&fAprobacion=' + fAprobacion,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
				}
			})
		}


		$('.addcurso').click(function(){
            load(1);
			})

		});
	</script>




<!-- FUNCION PARA ELIMINAR -->
<script type = "text/javascript">
	$(document).ready(function(){

		$('.addcurso').attr("disabled", true);
$("#facultad").on('change', function () {
$("#facultad option:selected").each(function () {
var elegido=$(this).val();
if(elegido == "")
			$('.addcurso').attr("disabled", true);
else
			$('.addcurso').attr("disabled", false);


});
});


			$("#table").on("click", ".deladmin_id", function(){
                        var admin_id = $(this).attr('value');
			 var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
					window.location = 'mallaEliminar.php?admin_id=' + admin_id;
                 }
            })

			$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listacursosMalla.php?idMalla='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div2").html(data).fadeIn('slow');
			$('#loader').html('');
			}
			})
			});


			$("#table").on("click", ".eadmin_id", function(){
			$admin_id = $(this).attr('value');
			$('#show_admin').show();
			$('#show_admin').click(function(){
			$(this).hide();
			$('#edit_form').empty();
			$('#admin_table').show();
			$('#add_admin').show();
			});
			$('#admin_table').fadeOut();
			$('#add_admin').hide();
			$('#edit_form').load('mallaCargar.php?admin_id=' + $admin_id);
			});

		});
</script>


<script type = "text/javascript">
$('#myModal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
		/*$("label.error").remove(); */ //lo utilice para borrar la etiqueta de error del jquery validate
	});
</script>


<!-- <script type="text/javascript">
function editarMalla(id){

	alert(id);

	$.ajax({
		type: 'POST',
		url: './ajax/agregar_facturacion2.php',
		// data: "&facultad="+xFacultad+"&carrera="+xCarrera+"&fActualizacion="+xFActualizacion+"&estado="+xEstado,
		data:"id="+id,

	});
}

</script> -->

</html>
