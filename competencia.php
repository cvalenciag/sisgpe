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
				<div class = "alert alert-jcr">Perfil del egresado / Competencias</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "add_comp" type = "button" class = "btn btn-editar"><span class = "glyphicon glyphicon-plus"></span> Subir fichero csv</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />
					<br />
					
					<div id = "admin_table">
					<label>Descargar</label>
						<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th>Competencia</th>
									<th>Definición</th>
									<th>Tipo competencia</th>
									<th>Estado</th>
								</tr>
							</thead>
							<tbody>						
								<?php
								 if($_SESSION['rol_id']==1)
                                                        $rol="";
                                                        else
                                                        $rol=" and c.estado=1";
								$q_admin = $conn->query("SELECT c.idCompetencia,c.descripcion as competencia,c.definicion,t.descripcion as tipo,c.estado FROM competencia c, tipocompetencia t where c.idTipo=t.idTipo".$rol) or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){
									
							?>	
								<tr class = "target">
									<td><?php echo $f_admin['competencia']?></td>
									<td><?php echo $f_admin['definicion']?></td>
									<td><?php echo $f_admin['tipo']?></td>	
									<div style = "float:left;">
									<td><?php if ($f_admin['estado']==1){
									echo "Activo";
									$btnclas="btn-danger";
                                                                        $title="Desactivar registro";
									$estado=0;
									} 
									else {
									echo "Inactivo";
                                                                        $title="Activar registro";
									$btnclas="btn-success";
									$estado=1;
									}
									?>
									</div>
									<div style = "float:right;">									
									<a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idCompetencia']?>">
                                    <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>
									<a href = "#" class = "btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idCompetencia'].'&estado='.$estado?>">
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
					<div id = "comp_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
							<form id = "formcompetencia" method = "POST" action = "competenciaGrabar.php" enctype = "multipart/form-data">
							
							<div class = "form-group">
								<label class = "titulo">Registre información sobre UNA competencia a la vez.</label>
								</div>
							
								<div class = "form-group">
									<label>Competencia:</label>
									<textarea required = "required" placeholder = "Escriba con mayúsculas y minúsculas" name = "descripcion" class = "form-control" rows="2" maxlength = "80"></textarea>
								</div>
								<div class = "form-group">
									<label>Definición de la competencia:</label>
									<textarea required = "required" name = "definicion" class = "form-control" rows="8"></textarea>
								</div>	
								
								<div class = "form-group">	
									 <label>Tipo de competencia:</label><br/>
                                                
						<select name = "idTipo" id = "idTipo" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
							<?php
								$qborrow = $conn->query("SELECT idTipo,descripcion FROM tipocompetencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
							?>
								<option value = "<?php echo $fborrow['idTipo']?>"><?php echo $fborrow['descripcion']?></option>
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
									<button class = "btn btn-primary" name = "save_admin"><span class = "glyphicon glyphicon-save"></span> Registrar</button>
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
      { width: "15%", targets: 0 },
      { width: "50%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "20%", targets: 3 },
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
                                $('#add_comp').hide();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
                                        $('#add_comp').show();
					$('#admin_table').slideDown();
					$('#formcompetencia')[0].reset();
					$('#admin_form').slideUp();
				});
			});
			
			$('#add_comp').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#add_admin').hide();
				$('#admin_table').slideUp();
				$('#show_admin').click(function(){
					$(this).hide();
					$('#add_admin').show();
					$('#add_comp').show();
					$('#admin_table').slideDown();
					$('#comp_form').slideUp();
				});
				$('#comp_form').slideDown();
                $('#comp_form').load('competenciaCargarCsv.php');
			});
		});
	</script>
	<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Activando/Desactivando el registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
				$admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'competenciaEliminar.php?admin_id=' + $admin_id;
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
				$('#edit_form').load('competenciaCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>
</html>