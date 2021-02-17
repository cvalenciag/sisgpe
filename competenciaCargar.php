<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT c.idCompetencia,c.definicion,c.idTipo,c.descripcion as competencia,c.estado FROM competencia c WHERE c.idCompetencia = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "competenciaEditar.php?idCompetencia=<?php echo $fedit_admin['idCompetencia']?>" enctype = "multipart/form-data">
	
	<div class = "form-group">
								<label class = "titulo">Registre información sobre UNA competencia a la vez.</label>
								</div>
	
		<div class = "form-group">
			<label>Competencia:</label>
			<textarea required = "required" placeholder = "Escriba con mayúsculas y minúsculas" name = "descripcion" rows="2" maxlength = "80" class = "form-control"><?php echo $fedit_admin['competencia']?></textarea>
		</div>	
		<div class = "form-group">
			<label>Definición de la competencia:</label>
			<textarea required = "required" name = "definicion" rows="8" class = "form-control"><?php echo $fedit_admin['definicion']?></textarea>
		</div>	
		
		<div class = "form-group">	
			<label>Tipo de competencia:</label><br/>
			
                        <select name = "idTipo" id = "idTipo">

							<?php
								$qborrow = $conn->query("SELECT idTipo,descripcion FROM tipocompetencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idTipo'] == $fborrow['idTipo'])
                                                                        $selected = "selected=selected";
							?>
								<option value = "<?php echo $fborrow['idTipo']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
                        
		</div>
		
		<div class = "form-group">
			<label>Estado:</label><br/>
		 <select name = "estado" id = "estado">
			<?php 
                           if($fedit_admin['estado']==1) { 
                                echo '<option value =' . $fedit_admin['estado'] . 'selected = selected> Activo</option>';
                                echo '<option value = "0">Inactivo</option>';
                               
                            } else {
                                 echo '<option value = "1">Activo</option>';
                                 echo '<option value =' . $fedit_admin['estado'] . 'selected = selected>Inactivo</option>';
                                  }
                            ?>				
                </select>
		</div>
		
		<div class = "form-group">	
			<button class = "btn btn-warning" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar Cambios</button>
		</div>
	</form>		
</div>
<script type = "text/javascript">
		$(document).ready(function(){
			CKEDITOR.replace( 'definicion' );
		});
</script>
