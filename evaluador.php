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
				<div class = "alert alert-jcr">Organización / Evaluadores</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "add_evaluador" type = "button" class = "btn btn-editar"><span class = "glyphicon glyphicon-plus"></span> Subir fichero csv</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />
					<br />

					<div id = "admin_table">
					<label>Descargar</label>
					<?php include("modal/ver_detalle_evaluador.php"); ?>
					<?php include("modal/ver_detalle_curso.php"); ?>
					<?php include("modal/ver_detalle_competencia.php"); ?>
						<table id = "table" class = "table table-bordered table-hover" style="100%">
							<thead class = "alert-info">
								<tr>
									<th class="text-center" style="vertical-align:middle;">Nombre evaluador</th>
									<th class="text-center" style="vertical-align:middle;">Apellido evaluador</th>
									<th class="text-center" style="vertical-align:middle;">Organización</th>
									<th class="text-center" style="vertical-align:middle;">Cargo</th>
									<th class="text-center" style="vertical-align:middle;">Correo</th>
									<th class="text-center" style="vertical-align:middle;">Cursos AOL</th>
									<th class="text-center" style="vertical-align:middle;">Competencias</th>
									<th class="text-center" style="vertical-align:middle;">Estado</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							  if($_SESSION['rol_id']==1)
                                                        $rol="";
                                                        else
                                                        $rol=" and e.estado=1";
								$q_admin = $conn->query("SELECT e.idEvaluador, e.nomEvaluador,e.apeEvaluador,e.orgaEvaluador,c.descripcion as cargo,e.correo1,e.estado FROM evaluador e, cargo c where e.idCargo=c.idCargo".$rol) or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class = "target">
									<td><?php echo $f_admin['nomEvaluador']?></td>
									<td><?php echo $f_admin['apeEvaluador']?></td>
									<td><?php echo $f_admin['orgaEvaluador']?></td>
									<td><?php echo $f_admin['cargo']?></td>
									<td><?php echo $f_admin['correo1']?></td>

									<td>
										<div style = "float:right;">

									<a href = "#" class = "btn btn-primary vadmin_id" data-toggle="modal" data-target="#agregarcurso" value = "<?php echo $f_admin['idEvaluador']?>">
                                    <span class="glyphicon glyphicon-floppy-saved" title="Agregar Curso AOL"></span> </a>
									</div>
									</td>

									<td>
										<div style = "float:right;">

									<a href = "#" class = "btn btn-primary vadmin_id" data-toggle="modal" data-target="#agregarcompetencia" value = "<?php echo $f_admin['idEvaluador']?>">
                                    <span class="glyphicon glyphicon-floppy-saved" title="Agregar Competencia"></span> </a>
									</div>
									</td>

									<div style = "float:left;">
									<td><?php if ($f_admin['estado']==1){
									echo "Activo";
									$btnclas="btn-danger";
                                                                        $title="Desactivar registro";
									$estado=0;
									}
									else {
									echo "Inactivo";
									$btnclas="btn-success";
                                                                        $title="Activar registro";
									$estado=1;
									}
									?>
									</div>
									<div style = "float:right;">

									<a href = "#" class = "btn btn-success vadmin_id" data-toggle="modal" data-target="#verdetalle" value = "<?php echo $f_admin['idEvaluador']?>">
                                    <span class="glyphicon glyphicon-search" title="Ver detalle"></span> </a>

									<a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idEvaluador']?>">
                                    <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>
									<a href = "#" class = "btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idEvaluador'].'&estado='.$estado?>">
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
					<div id = "evaluador_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form id = "formevaluador" method = "POST" action = "evaluadorGrabar.php" enctype = "multipart/form-data">

					<div class = "form-group">
									<label>DNI:</label>
									<input type = "text" name = "dni" required = "required" maxlength = "8" class = "form-control" onkeypress="return validar(event)"/>
								</div>
								<div class = "form-group">
									<label>RUC:</label>
									<input type = "text" name = "ruc" maxlength = "11" class = "form-control" onkeypress="return validar(event)"/>
								</div>
								<div class = "form-group">
									<label>Nombres:</label>
									<input type = "text" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "nombres" maxlength = "50"  class = "form-control" />
									</div>
						<div class = "form-group">
									<label>Apellidos:</label>
									<input type = "text" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "apellidos" maxlength = "50"  class = "form-control" />
									</div>

								<div class = "form-group">
									<label>Relación con UP:</label><br/>
									<select name = "tipoRelacion" id = "tipoRelacion" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<option value = "1" >Colaborador</option>
							<option value = "2" >Externo</option>
						</select>
								</div>

								<div class = "form-group">
									<label>Categoría del evaluador:</label><br/>
									<select name = "categoriaEval" id = "categoriaEval" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<option value = "1" >Docente</option>
							<option value = "2" >Especialista</option>
						</select>
								</div>

								<div class = "form-group">
                        <label>Sector en el que labora:</label><br/>
						<select name = "idSector" id = "sector" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<?php
								$qborrow = $conn->query("SELECT idSector,descripcion FROM sector ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
							?>
								<option value = "<?php echo $fborrow['idSector']?>"><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
								</div>

									<div class = "form-group">
									<label>Organización actual:</label>
									<input type = "text" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "organizacion" maxlength = "50"  class = "form-control" />
									</div>

									<div class = "form-group">
                        <label>Cargo actual:</label><br/>
						<select name = "idCargo" id = "cargo" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<?php
								$qborrow = $conn->query("SELECT idCargo,descripcion FROM cargo ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
							?>
								<option value = "<?php echo $fborrow['idCargo']?>"><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
								</div>

									<div class = "form-group">
									<label>Descripción del cargo:</label>
									<textarea required = "required" rows="3" name = "descripcion" class = "form-control" maxlength = "500" ></textarea>
									</div>

									<div class = "form-group">
									<label>Celular:</label>
									<input type = "text" name = "celular" maxlength = "9" class = "form-control" onkeypress="return validar(event)"/>
								</div>

								<div class = "form-group">
									<label>Dirección:</label>
									<textarea rows="3" name = "direccion" class = "form-control" maxlength = "100" ></textarea>
									</div>

									<div class = "form-group">
									<label>Correo principal:</label>
									<input type="email" name = "correo1" required ="required" class = "form-control" maxlength = "50"/>
								</div>

									<div class = "form-group">
									<label>Correo secundario:</label>
									<input type="email" name = "correo2" class = "form-control" maxlength = "50"/>
								</div>

								<div class = "form-group">
									<label>Asistente:</label>
									<input type = "text" onKeyUp="this.value=this.value.toUpperCase();" name = "asistente" maxlength = "50"  class = "form-control" />
									</div>

									<div class = "form-group">
									<label>Correo asistente:</label>
									<input type="email" name = "correo3" class = "form-control" maxlength = "50"/>
								</div>

								<div class = "form-group">
									<label>Sumilla del evaluador:</label>
									<textarea required = "required" rows="3" name = "sumilla" class = "form-control" maxlength = "500" ></textarea>
									</div>

									<div class = "form-group">
									<label>Comentarios sobre el evaluador:</label>
									<textarea rows="3" name = "comentarios" class = "form-control" maxlength = "500" ></textarea>
									</div>

									 <div class = "form-group">
									<label>Última capacitación:</label>
									<input type = "date" name = "fcapacitacion" id = "fcapacitacion" value="<?php echo date("Y-m-d");?>" class = "form-control"/>
                                                                    </div>

								<div class = "form-group">
									<label>Usuario:</label><br>
									<!-- <input type = "text" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "usuario" maxlength = "20"  class = "form-control" /> -->
									<select name = "usuario" id = "usuario" required = "required">
										<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
										<?php
											$qborrow = $conn->query("SELECT * FROM usuario WHERE idRol=5 ") or die(mysqli_error($conn));
											while($fborrow = $qborrow->fetch_array()){
										?>
											<option value = "<?php echo $fborrow['idUsuario']?>"><?php echo $fborrow['username']?></option>
										<?php
											}
										?>
									</select>
									</div>

								<div class = "form-group">
									<label>Estado:</label><br/>
									<select name = "estado" id = "estado">
							<option value = "1" selected = "selected">Activo</option>
							<option value = "0" >Inactivo</option>
						</select>
								</div>

								<div class = "form-group">
									<button class = "btn btn-primary" name = "save_user"><span class = "glyphicon glyphicon-save"></span> Registrar</button>
								</div>
							</form>
						</div>
					</div>
			</div>
		</div>
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
	"pageLength": 100,
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
      { width: "10%", targets: 0 },
      { width: "10%", targets: 1 },
      { width: "5%", targets: 2 },
      { width: "10%", targets: 3 },
      { width: "10%", targets: 4 },
      { width: "13%", targets: 5 },
      { width: "13%", targets: 6 },
      { width: "29%", targets: 7 },
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
				$('#add_evaluador').hide();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#add_evaluador').show();
					$('#admin_table').slideDown();
					$('#formevaluador')[0].reset();
					$('#admin_form').slideUp();
				});
			});
				$('#add_evaluador').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#add_admin').hide();
				$('#admin_table').slideUp();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#add_evaluador').show();
					$('#admin_table').slideDown();
					$('#evaluador_form').slideUp();
				});
				$('#evaluador_form').slideDown();
                $('#evaluador_form').load('evaluadorCargarCsv.php');
			});
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Activando/Desactivando registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
				$admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'evaluadorEliminar.php?admin_id=' + $admin_id;
				}, 1000);
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
				$('#edit_form').load('evaluadorCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>

<script type = "text/javascript">
		$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listadetalleEvaluador.php?idEvaluador='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div2").html(data).fadeIn('slow');
			$('#loader').html('');
			}
			})
			});
			</script>

			<script type = "text/javascript">
		$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listacursos.php?idEvaluador='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div3").html(data).fadeIn('slow');
			$('#loader').html('');
			}
			})
			});
			</script>

			<script type = "text/javascript">
		$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listacompetencias.php?idEvaluador='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div4").html(data).fadeIn('slow');
			$('#loader').html('');
			}
			})
			});
			</script>

<script type = "text/javascript">
function validar(e){
var expresion=/[\d\b]/;
return expresion.test(String.fromCharCode(e.which));
}
</script>


</html>
