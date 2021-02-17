<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM facultad WHERE idFacultad = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "facultadEditar.php?admin_id=<?php echo $fedit_admin['idFacultad']?>" enctype = "multipart/form-data">
	<div class = "form-group">
			<label>Nombre corto:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nombreCorto']?>" disabled="disabled" onKeyUp="this.value=this.value.toUpperCase();" maxlength = "10" name = "nombreCorto" class = "form-control"/>
		</div>	
		<div class = "form-group">
			<label>Facultad:</label>
			<textarea rows="2" required = "required" maxlength = "70" placeholder = "Escriba con mayúsculas y minúsculas" name = "descripcion" class = "form-control"><?php echo $fedit_admin['descripcion']?></textarea>
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
