<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM criterio WHERE idCriterio = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "criterioEditar.php?admin_id=<?php echo $fedit_admin['idCriterio']?>" enctype = "multipart/form-data">
	<div class = "form-group">
			<label>Descripción:</label>
			<textarea rows="8" required = "required" name = "descripcion" class = "form-control"><?php echo $fedit_admin['descripcion']?></textarea>
		</div>	
		<div class = "form-group">
			<label>Definición:</label>
			<textarea rows="8" required = "required" name = "definicion" class = "form-control"><?php echo $fedit_admin['definicion']?></textarea>
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
			<button class = "btn btn-primary" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar Cambios</button>
		</div>
	</form>		
</div>	
