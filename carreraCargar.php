<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT c.idCarrera, c.nombreCorto,c.idFacultad,c.descripcion as carrera,c.estado FROM carrera c WHERE c.idCarrera = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "carreraEditar.php?idCarrera=<?php echo $fedit_admin['idCarrera']?>" enctype = "multipart/form-data">
	
	<div class = "form-group">
			<label>Nombre corto:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nombreCorto']?>" disabled="disabled" onKeyUp="this.value=this.value.toUpperCase();" maxlength = "15" name = "nombreCorto" class = "form-control" />
		</div>
	
		<div class = "form-group">
			<label>Carrera:</label>
			<textarea required = "required" rows="1" maxlength = "50" placeholder = "Escriba con mayúsculas y minúsculas" name = "descripcion" class = "form-control"><?php echo $fedit_admin['carrera']?></textarea>
		</div>
		
		
		<div class = "form-group">	
			<label>Facultad:</label><br/>
			
                        <select name = "idFacultad" id = "facultad">
							<?php  
								$qborrow = $conn->query("SELECT * FROM facultad where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idFacultad'] == $fborrow['idFacultad'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idFacultad']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
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
