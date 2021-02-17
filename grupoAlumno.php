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
				<div class = "alert alert-jcr">Evaluaciones / Grupo de alumnos</div>
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
						<table id = "table" class="table table-bordered table-hover" style="width:100%">
							<thead class="alert-info">
								<tr>
									<th class="text-center">Descripción del proyecto</th>
									<th class="text-center">Curso</th>
									<th class="text-center">Semestre</th>
                  <th class="text-center">Estado</th>
								</tr>
							</thead>
							<tbody>
							<?php
							//SI ES ADMINISTRADOR
							if($_SESSION['rol_id']==1){
            		$rol="";
								// echo 'is admin';
							}else{
								$rol=" WHERE ga.estado=1";
							}


							$q_admin = $conn->query("SELECT ga.idGrupoAl, ga.descripcion, ga.semestre, ga.idCurso, c.nombreCurso, ga.infAdjunto, ga.fechaAprobacion, ga.estado FROM grupoAlumno ga LEFT JOIN curso c ON (c.idCurso=ga.idCurso)".$rol) or die(mysqli_error($conn));
							while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class="target">
									<td class="text-justify"><?php echo $f_admin['descripcion']?></td>
									<td class="text-center"><?php echo $f_admin['nombreCurso']?></td>
									<td class="text-center"><?php echo $f_admin['semestre']?></td>

									<div style = "float:left;">
                  	<td>
											<?php
											if ($f_admin['estado']==1)
											{
												echo "Activo";
                    		$title="Desactivar registro";
												$btnclas="btn-danger btn-sm";
												$estado=0;
											} else {
												echo "Inactivo";
												$title="Activar registro";
												$btnclas="btn-success btn-sm";
												$estado=1;
											}
									?>
									</div>
									<div style = "float:right;">
										<button type="button" name="button" class="btn btn-success btn-sm" onclick="showAlumnosReg(<?php echo $f_admin['idGrupoAl']?>)">
											<span class = "glyphicon glyphicon-search" title="Ver registro"></span>
										</button>

                		<a href = "#" class = "btn btn-editar btn-sm eadmin_id" value = "<?php echo $f_admin['idGrupoAl']?>">
                      <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>

										<!-- <a href = "#" class="btn <?php echo $btnclas?> deladmin_id" value="<?php echo $f_admin['idGrupoAl'] ?>" id="btnDesactivar">
											<span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
										</a> -->

										<a href="#" class="btn <?php echo $btnclas?> deladmin_id" value="<?php echo $f_admin['idGrupoAl'].'&estado='.$estado?>">
											<span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
										</a>
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
							<!-- <form id = "formgrupoAl" method = "POST" action="grupoAlumnoGrabar.php" enctype = "multipart/form-data"> -->
								<!-- <div class = "form-group">
								<label class = "titulo">Registre información de grupos de alumnos.</label>
								</div> -->

								<div class = "form-group">
									<label>Nombre del grupo:</label>
									<input type="text" name="descGrupo" value="" required="required" maxlength="50" name="descripcion" class = "form-control" id="descGrupo">
									<!-- <textarea required = "required" maxlength = "50" rows="1" name = "descripcion" class = "form-control"></textarea> -->
								</div>

								<div class = "form-group">
									<label>Semestre:</label><br/>
									<select name="idSemestre" id="idSemestre" class="form-control">
	                  <option value="" selected="selected">Seleccione una opción</option>
	                  <?php
	                    $añoAct = date("Y");
	                    $añoAnt = date('Y', strtotime("$añoAct -1 year") );
	                  ?>
	                    <option value="<?php echo $añoAnt.'-1' ?>"><?php echo $añoAnt.'-1' ?></option>
	                    <option value="<?php echo $añoAnt.'-2' ?>"><?php echo $añoAnt.'-2' ?></option>
	                    <option value="<?php echo $añoAct.'-1' ?>"><?php echo $añoAct.'-1' ?></option>
	                    <option value="<?php echo $añoAct.'-2' ?>"><?php echo $añoAct.'-2' ?></option>
	                  </select>
								</div>

								<div class = "form-group">
									<label>Curso:</label><br/>
									<select name="idCurso" id="idCurso" class="form-control">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
										// $qryCursos = $conn->query("SELECT * FROM curso left join detalle_malla using (idCurso) WHERE estado=1 and AoL=1 group by idCurso order by nombreCurso ") or die(mysqli_error($conn));
										$qryCursos = $conn->query("SELECT
    idCurso, nombreCurso
FROM
    detalle_malla
        LEFT JOIN
    curso USING (idCurso)
WHERE
    aol = 1 AND eliminado = 0
GROUP BY idCurso
ORDER BY nombreCurso ") or die(mysqli_error($conn));

										foreach ($qryCursos as $cursos)
										{
										?>
											<option value="<?php echo $cursos['idCurso'] ?>">
												<?php echo $cursos['nombreCurso'] ?>
											</option>
										<?php
										}
										?>
									</select>
								</div>

								<form method="POST" action="grupoAlumnoUpload.php" enctype="multipart/form-data">
								<div class = "form-group">
									<label>Informe adjunto:</label>
    							<input type='file' name='uploadFile' class="form-control" required="required" id="uploadFile">
									<!-- <br>
									<input type="text" name="nameArchivo" value="" required="required" maxlength="50" class="form-control" id="nameArchivo"> -->
   							</div>
								</form>

								<div class="form-group">
	                <button type="button" class="btn btn-md btn-warning" id="addAlumnos" onclick="showModalAlumnos();">
	                  <span class="glyphicon glyphicon-plus"></span> Agregar alumnos
	                </button>
	              </div>

								<div class="form-group">
									<label>Integrantes:</label>
								</div>

								<!-- <div class = "form-group">
									<label>Estado:</label><br/>
									<select name = "estado" id = "estado">
										<option value = "1" selected = "selected">Activo</option>
										<option value = "0" >Inactivo</option>
									</select>
								</div> -->
								<div id="resultAlumnos" class='col-md-12'></div>
								<div id="resultados" class='col-md-12' style="margin-top:5px"></div>

								<div class = "form-group">
									<button class = "btn btn-primary" name="save_user" onclick="saveRegistro();">
										<span class = "glyphicon glyphicon-save"></span> Registrar
									</button>
								</div>
							<!-- </form> -->
						</div>
					</div>
			</div>
		</div>
		<div class="modal fade" id="modalAddAlumnos" role="dialog" tabindex="-2"></div>
		<div class="modal fade" id="modalShowAlumnos" role="dialog" tabindex="-2"></div>
		<br />
		<br />
		<br />
		<?php require("footer.php"); ?>
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
      { width: "30%", targets: 0 },
      { width: "30%", targets: 1 },
      { width: "10%", targets: 2 },
      { width: "30%", targets: 3 },
    ],
    } );
} );
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$('#add_admin').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#admin_table').slideUp();
				$('#admin_form').slideDown();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#admin_table').slideDown();
					// $('#formgrupoAl')[0].reset();
					$('#admin_form').slideUp();
					window.location = 'grupoAlumno.php';
				});
			});
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Activando/Desactivando el registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
				admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'grupoAlumnoEliminar.php?admin_id='+admin_id+'&deleteCab=dc';
				}, 1000);
			});

			// $("#table").on("click", ".deladmin_id", function(){
			// 	var admin_id = $(this).attr('value');
			//  	var p = confirm("¿Está seguro de eliminar el registro?");
			//
			// 	if(p){
			// 		window.location = 'grupoAlumnoEliminar.php?admin_id='+admin_id+'&deleteCab=dc';
      //   }
      // });

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
				$('#edit_form').load('grupoAlumnoCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>

	<script type="text/javascript">
	// FUNCION PARA MOSTRAR MODAL DE ALUMNOS
	function showModalAlumnos(edit, idGrupoAlum){

		if(edit==2){
			urlModalAlumnos = './modal/modalAddAlumnos.php?editar='+edit+'&idGrupoAlum='+idGrupoAlum;
		}else {
			urlModalAlumnos = './modal/modalAddAlumnos.php';
		}


	  $.get(urlModalAlumnos, function(data){
	    $('#modalAddAlumnos').html(data).modal();
	  })
	}


	function saveRegistro(){
		descGrupo		= $('#descGrupo').val();
		idSemestre	= $('#idSemestre').val();
		idCurso			= $('#idCurso').val();
		nameFile		= $('#uploadFile').val();

		// alert(idSemestre+'_'+idCurso);
		// alert(nameArchivo);
		// return false;

		if(idSemestre=='' || idCurso==''){
			alert('Favor de capturar todos los datos.');

			$('#idSemestre').css("border", "3px solid red");
			$('#idCurso').css("border", "3px solid red");

			return false;
		}else {

			$('#idSemestre').css("border", "");
			$('#idCurso').css("border", "");
		}

		$.ajax({
	    type: 'POST',
	  	url: 'grupoAlumnoGrabar.php',
	    data: "descGrupo="+descGrupo+'&idSemestre='+idSemestre+'&idCurso='+idCurso+'&fileName='+nameFile+'&add=a',

	    beforeSend: function(objeto){
	      $("#resultados").html("Mensaje: Cargando...");
	    },

	    success: function(datos){
	      $("#resultados").html(datos);
				if ( ($("#idResult").val()) == 2){
				alert("Debe registrar el detalle de alumnos antes de grabar el registro.");
				}
	    }

	  }); //LLAVE AJAX
	}


	function showAlumnosReg(idGpoAl){
		urlModalAlumnos = './modal/modalShowAlumnos.php?idGpoAl='+idGpoAl;

	  $.get(urlModalAlumnos, function(data){
	    $('#modalShowAlumnos').html(data).modal();
	  })
	}
	</script>


</html>
