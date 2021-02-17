<?php
	require_once 'valid.php';
	$session_id= $_SESSION['session_id'];	
?>
<!DOCTYPE html> 
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Diseño curricular / Competencias por carrera</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>

					<br><br>
					<?php
						$sqlTempo = $conn->query("SELECT * FROM tmp") or die(mysqli_error($conn));
						if ($sqlTempo->num_rows>0){
							$delete=mysqli_query($conn, "DELETE FROM tmp");
						}
					?>

					<div id = "admin_table">
					<label>Descargar</label>
					<?php include("modal/ver_competencia2.php"); ?>
						<table id = "table" class = "table table-bordered table-hover" style="width: 100%;">
							<thead class = "alert-info">
								<tr>
									<th class="text-center" style="vertical-align:middle;">Carrera</th>
                  <th class="text-center" style="vertical-align:middle;">Fecha de aprobación</th>
									<th class="text-center" style="vertical-align:middle;">Cantidad de competencias</th>
									<th class="text-center" style="vertical-align:middle;">Estado</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							  // if($_SESSION['rol_id']==1)
                //                                         $rol="";
                //                                         else
                //                                         $rol=" and m.estado=1";
								$q_admin = $conn->query("SELECT o.idCarreraCompetencia, c.descripcion AS carrera, o.fAprobacion, o.estado FROM carrera_competencia o, carrera c WHERE o.idCarrera=c.idCarrera AND o.eliminado='0' order by c.descripcion, o.fAprobacion desc") or die(mysqli_error($conn));

								while($f_admin = $q_admin->fetch_array())
								{
									$idCarreraCompetencia = $f_admin['idCarreraCompetencia'];

									$result = $conn->query("SELECT COUNT(*) total FROM detalle_carrera_competencia WHERE idCarreraCompetencia='". $idCarreraCompetencia."' and eliminado='0'");

									$numReg = $result->fetch_assoc();
							?>
								<tr class = "target">
									<td><?php echo $f_admin['carrera']?></td>
									<td><?php echo $f_admin['fAprobacion']?></td>
									<td><?php echo $numReg['total'];?></td>
									<div style = "float:left;">
									<td><?php if ($f_admin['estado']==1){
									echo "Activo";
										$btnclas="btn-danger";
										$title="Desactivar Registro";
										$estado=0;
									}
									else {
									echo "Inactivo";
										$btnclas="btn-success";
										$title="Activar Registro";
										$estado=1;
									}
									?>
									</div>
									<div style = "float:right;">

									<button type="button" name="button" class = "btn btn-sm btn-success vadmin_id" data-toggle="modal" data-target="#vercompetencias2" value = "<?php echo $f_admin['idCarreraCompetencia']?>">
										<span class="glyphicon glyphicon-search" title="Ver Registro"></span>
									</button>
									<!-- <a href = "#"  > </a> -->
									<a href = "#" class = "btn btn-editar btn-sm eadmin_id" value = "<?php echo $f_admin['idCarreraCompetencia']?>">
                                    <span class = "glyphicon glyphicon-edit" title="Editar Registro"></span> </a>
									<a href = "#" class = "btn-sm btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idCarreraCompetencia']?>">
                                    <span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span> </a>
									</div>
									</td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
					<div id = "edit_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
                                                <?php
                                                    include("modal/buscar_competencia.php");

                                                ?>
							<!-- <form id = "formcarrera" method = "POST" action = "carreracompetenciaGrabar.php" enctype = "multipart/form-data"> -->
							<div class = "form-group">
                            <label>Facultad:</label><br/>
						    <select name = "idFacultad" id = "facultad" required = "required">
							<option value = "" selected = "selected">Seleccione una opción</option>
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
						<select name = "idCarrera" id = "carrera" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
						</select>
								</div>

                                                                <div class = "form-group">
									<label>Fecha de aprobación:</label><br/>
									<input type = "text" name = "fAprobacion" id = "fAprobacion" readonly value="<?php echo date("Y-m-d");?>"/>
                                                                    </div>


								<div class = "form-group">
									<label>Estado:</label><br/>
									<select name = "estado" id = "estado">
							<option value = "1" selected = "selected">Activo</option>
							<option value = "0" >Inactivo</option>
						</select>
								</div>
                                                                <!-- <input type="hidden" id="idTmp" name="idTmp" value=""/> -->
                <button type="button" class="btn btn-default btn-sm addCC" data-toggle="modal" data-target="#myModal" id="btnAddCompetencia" onclick="validar();">
						 			<span class="glyphicon glyphicon-search"></span> Agregar Competencias
								</button>

              	<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

								<div class = "form-group">
									<button id="btnRegistrarC" class="btn btn-primary btn-sm" name="" onclick="saveCompetencia();">
										<span class="glyphicon glyphicon-save"></span> Registrar</button>
								</div>
							<!-- </form> -->
						</div>
					</div>
			</div>
		</div>
		<br />
		<br />
		<br />

		<?php require("footer.php"); ?>
                                <script type="text/javascript" src="js/nuevo_reg_carreracompetencia.js"></script>
<script type="text/javascript">
  $( function() {
    $( "#fAprobacion" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendario.png",
      buttonImageOnly: true,
      dateFormat: 'yy-mm-dd',
      buttonText: "Select date"
    });

  } );
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
      { width: "25%", targets: 0 },
      { width: "25%", targets: 1 },
      { width: "25%", targets: 2 },
      { width: "25%", targets: 3 },
    ],
    } );
} );
	</script>
	<script type = "text/javascript">
		$(document).ready(function()
		{
			$('#btnRegistrarC').attr("disabled", true);
				$('#add_admin').click(function()
				{
					$(this).hide();
					$('#show_admin').show();
					$('#admin_table').slideUp();
					$('#admin_form').slideDown();

					$('#show_admin').click(function()
					{
						$(this).hide();
						$('#add_admin').show();
						$('#admin_table').slideDown();
						// $('#formcarrera')[0].reset();
						$('#carrera').empty();
						$('#admin_form').slideUp();
						window.location = 'carreracompetencia.php';
					});
				});
		});
	</script>


<script>
	$(document).ready(function(){
	function load(page){
			var q= $("#q").val();
			var carrera= $("#carrera").val();
			var idCarreraCompetencia= $("#idCarreraCompetencia").val();
			var fAprobacion= $("#fAprobacion").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/competencia_carreracompetencia.php?action=ajax&page='+page+'&q='+q+'&idCarrera=' + carrera +'&idCarreraCompetencia=' + idCarreraCompetencia+'&fAprobacion=' + fAprobacion,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
				}
			})

		}

$('.addCC').click(function(){
            load(1);
        })
		});
	</script>

	<script type = "text/javascript">

	$(document).ready(function(){
            $('.addCC').attr("disabled", true);
                    $("#facultad").on('change', function () {
        $("#facultad option:selected").each(function () {
                        var elegido=$(this).val();
            if(elegido == "")
                    $('.addCC').attr("disabled", true);
            else
                    $('.addCC').attr("disabled", false);


            });
            });

			$("#table").on("click", ".deladmin_id", function(){
             var admin_id = $(this).attr('value');
			 var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
					window.location = 'carreracompetenciaEliminar.php?admin_id=' + admin_id;
                 }
            })

			$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listacompetenciaCarrera.php?idCarreraCompetencia='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div").html(data).fadeIn('slow');
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
			$('#edit_form').load('carreracompetenciaCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>

<script type = "text/javascript">
$('#myModal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
		/*$("label.error").remove(); */ //lo utilice para borrar la etiqueta de error del jquery validate
	});
</script>

<script>
    function validar()
    {
			// alert('entra');
    	var carrera1= $("#carrera").val();
    	var fAprobacion1= $("#fAprobacion").val();
    	var estado1= $("#estado").val();
        $.ajax({
            type:'POST', //aqui puede ser igual get
            url: './ajax/validacioncarreracompetencia.php',//aqui va tu direccion donde esta tu funcion php
            data: "idCarrera="+carrera1+"&fAprobacion="+fAprobacion1+"&estado="+estado1,//aqui tus datos
            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
													$("#resultados").html(datos);
													if ( ($("#idResultC").val()) == 1)
													{
														// $('#myModal').modal('hide');
														alert("La fecha de aprobación para la carrera seleccionada ya se encuentra registrada. Favor de modificar.");
														$('#btnRegistrarC').attr("disabled", true);
													}else{
														$('#btnRegistrarC').attr("disabled", false);
                          }
												}
                    });
  	}

</script>

<script type="text/javascript">
function saveCompetencia(){

	// alert('entra');

	var xFacultad 			= $('#facultad').val();
	var xCarrera				=	$('#carrera').val();
	var xEstado					=	$('#estado').val();
	var xFAprobacion		= document.getElementById("fAprobacion").value;

	$.ajax({
		type: 'POST',
		url: 'carreracompetenciaGrabar2.php',
		// data: "&facultad="+xFacultad+"&carrera="+xCarrera+"&fActualizacion="+xFActualizacion+"&estado="+xEstado,
		data:"&facultad="+xFacultad+"&idCarrera="+xCarrera+"&fAprobacion="+xFAprobacion+"&estado="+xEstado,

		beforeSend: function(objeto){
	      $("#resultados").html("Mensaje: Cargando...");
			},

		success: function(datos){
			$("#resultados").html(datos);

				if ( ($("#idResultC").val()) == 2){
					alert("Debe registrar el detalle de competencias antes de grabar las competencias or carrera.");
					// $('#btnRegistrarC').attr("disabled", true);

				}else{
					$('#btnRegistrarC').attr("disabled", false);
				}

		  }

	});

}

</script>

</html>
