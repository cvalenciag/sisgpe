<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM departamento WHERE idDepartamento = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "departamentoEditar.php?admin_id=<?php echo $fedit_admin['idDepartamento']?>" enctype = "multipart/form-data">
	<div class = "form-group">
			<label>Codigo UP Departamento Académico:</label>
			<input type = "text" value = "<?php echo $fedit_admin['codUpDepartamento']?>" disabled="disabled" maxlength = "2" required = "required" name = "codUpDepartamento" class = "form-control"/>
		</div>
	<div class = "form-group">
			<label>Nombre corto:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nombreCorto']?>" disabled="disabled" onKeyUp="this.value=this.value.toUpperCase();" required = "required" name = "nombreCorto" class = "form-control" maxlength = "10"/>
		</div>	
		<div class = "form-group">
			<label>Departamento Académico:</label>
			<textarea rows="2" required = "required" placeholder = "Escriba con mayúsculas y minúsculas" maxlength = "80" name = "descripcion" class = "form-control"><?php echo $fedit_admin['descripcion']?></textarea>
		</div>	
		<div class = "form-group">
			<label>Estado:</label><br/>
		 <select name = "estado" required = "required" id = "estado">
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












