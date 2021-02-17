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
				<div class = "alert alert-jcr">Administración / Alumnos</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "add_alumno" type = "button" class = "btn btn-editar"><span class = "glyphicon glyphicon-plus"></span> Subir fichero csv</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />
					<br />

					<div id = "admin_table">
					<label>Descargar</label>
						<table id = "table" class = "table table-bordered table-hover" style="100%">
							<thead class = "alert-info">
								<tr>
									<th>Codigo SII</th>
									<th>Nombres</th>
									<th>Apellidos</th>
									<th>Carrera</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							  if($_SESSION['rol_id']==1)
                                                        $rol="";
                                                        else
                                                        $rol=" and c.estado=1";
								$q_admin = $conn->query("SELECT a.idAlumno, a.codSii, a.nomAlumno,a.apeAlumno,c.descripcion as carrera,a.estado FROM alumno a, carrera c where a.idCarrera=c.idcarrera".$rol) or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class = "target">
									<td><?php echo $f_admin['codSii']?></td>
									<td><?php echo $f_admin['nomAlumno']?></td>
									<td><?php echo $f_admin['apeAlumno']?></td>
									<td><?php echo $f_admin['carrera']?></td>
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
									<a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idAlumno']?>">
                                    <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>
									<a href = "#" class = "btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idAlumno'].'&estado='.$estado?>">
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
					<div id = "alumno_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form id = "formalumno" method = "POST" action = "alumnoGrabar.php" enctype = "multipart/form-data">

                                                                <div class = "form-group">
									<label>Codigo SII:</label>
									<input type = "text" name = "codigosii" onKeyUp="this.value=this.value.toUpperCase();" required = "required" maxlength = "15" class = "form-control" />
								</div>
                                                                <div class = "form-group">
									<label>Nombres:</label>
									<input type = "text" name = "nombre" required = "required" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Apellidos:</label>
									<input type = "text" name = "apellido" required = "required" class = "form-control" />
								</div>
								<div class = "form-group">
									<label>Codigo Power Campus:</label>
									<input type = "text" name = "codigopc" onKeyUp="this.value=this.value.toUpperCase();" required = "required" maxlength = "15" class = "form-control" />
								</div>
                                                            <div class = "form-group">
                                                            <label>Carrera:</label><br/>
                                                            <select name = "idCarrera" id = "carrera" required = "required">
                                                            <option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
                                                            <?php
								$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                            ?>
								<option value = "<?php echo $fborrow['idCarrera']?>"><?php echo $fborrow['descripcion']?></option>
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
      { width: "20%", targets: 0 },
      { width: "25%", targets: 1 },
      { width: "25%", targets: 2 },
      { width: "15%", targets: 3 },
      { width: "15%", targets: 4 },
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
				$('#add_alumno').hide();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#add_alumno').show();
					$('#admin_table').slideDown();
					$('#formalumno')[0].reset();
					$('#admin_form').slideUp();
				});
			});
			$('#add_alumno').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#add_admin').hide();
				$('#admin_table').slideUp();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#add_alumno').show();
					$('#admin_table').slideDown();
					$('#alumno_form').slideUp();
				});
				$('#alumno_form').slideDown();
                $('#alumno_form').load('alumnoCargarCsv.php');
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
					window.location = 'alumnoEliminar.php?admin_id=' + $admin_id;
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
				$('#edit_form').load('alumnoCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>
</html>
