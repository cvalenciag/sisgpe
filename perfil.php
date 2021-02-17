<?php
	require_once 'valid.php';
?>
<!DOCTYPE html>	
<html lang = "eng">
		<?php require("head.php"); ?>
         <div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;">
					<div class = "alert alert-jcr">Usuario / Editar perfil</div>
			
                                <?php
	$qedit_admin = $conn->query("SELECT * FROM usuario WHERE idUsuario = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "usuarioEditar.php?admin_id=<?php echo $fedit_admin['idUsuario']?>" enctype = "multipart/form-data">
		<div class = "form-group">
			<label>Usuario:</label>
			<input type = "text" value = "<?php echo $fedit_admin['username']?>" required = "required" name = "username" class = "form-control" readonly />
		</div>
                <div class = "form-group">
			<label>Email:</label>
			<input type = "text" value = "<?php echo $fedit_admin['email']?>" required = "required" name = "email" class = "form-control" readonly />
		</div>	
		<div class = "form-group">	
			<label>Contraseña:</label>
			<input type = "password" value = "<?php echo $fedit_admin['password']?>"  maxlength = "12" name = "password" required = "required" class = "form-control" />
		</div>	
		<div class = "form-group">	
			<label>Nombres:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nombre']?>"  name = "nombre" required = "required" class = "form-control" />
		</div>	
		<div class = "form-group">	
			<label>Apellidos:</label>
			<input type = "text" value = "<?php echo $fedit_admin['apellido']?>"  name = "apellido" required = "required" class = "form-control" />
		</div>	
		
		<div class = "form-group">	
			<button class = "btn btn-warning" name = "edit_perfil"><span class = "glyphicon glyphicon-edit"></span> Guardar Cambios</button>
		</div>
	</form>		
</div>	                
			</div>
		</div>
                <br />
		<br />
		<br />
                
		<?php 
       require("footer.php"); ?>
</html>
