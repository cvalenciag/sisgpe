<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM usuario WHERE idUsuario = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "usuarioEditar.php?admin_id=<?php echo $fedit_admin['idUsuario']?>" enctype = "multipart/form-data">
		<div class = "form-group">
			<label>Usuario:</label>
			<input type = "text" value = "<?php echo $fedit_admin['username']?>" required = "required" maxlength = "24" name = "username" class = "form-control" readonly />
		</div>
                <div class = "form-group">
			<label>Email:</label>
			<input type = "text" value = "<?php echo $fedit_admin['email']?>" required = "required" maxlength = "50" name = "email" class = "form-control" readonly />
		</div>	
		<div class = "form-group">	
			<label>Contraseña:</label>
			<input type = "password" value = "<?php echo $fedit_admin['password']?>"  maxlength = "12" name = "password" required = "required" class = "form-control" />
		</div>	
		<div class = "form-group">	
			<label>Nombres:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nombre']?>"  name = "nombre" required = "required" class = "form-control" maxlength = "100"/>
		</div>	
		<div class = "form-group">	
			<label>Apellidos:</label>
			<input type = "text" value = "<?php echo $fedit_admin['apellido']?>"  name = "apellido" required = "required" class = "form-control" maxlength = "200"/>
		</div>	
		<div class = "form-group">	
			<label>Rol:</label><br/>
                        <select name = "idRol" id = "idRol">
						<?php  
								$qborrow = $conn->query("SELECT * FROM rol where estado=1 ORDER BY idRol") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idRol'] == $fborrow['idRol'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idRol']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
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
