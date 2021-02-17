<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT c.idAlumno, c.nomAlumno,c.apeAlumno,c.idCarrera,c.codSII,c.codPowerCampus,c.estado FROM alumno c WHERE c.idAlumno = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "alumnoEditar.php?idAlumno=<?php echo $fedit_admin['idAlumno']?>" enctype = "multipart/form-data">
	
                <div class = "form-group">
			<label>Codigo SII:</label>
			<input type = "text" value = "<?php echo $fedit_admin['codSII']?>" disabled="disabled" onKeyUp="this.value=this.value.toUpperCase();" maxlength = "15" name = "codigosii" class = "form-control" />
		</div>
                <div class = "form-group">
			<label>Nombres:</label>
			<input type = "text" value = "<?php echo $fedit_admin['nomAlumno']?>" name = "nombre" class = "form-control" />
		</div>
		      <div class = "form-group">
			<label>Apellidos:</label>
			<input type = "text" value = "<?php echo $fedit_admin['apeAlumno']?>" name = "apellido" class = "form-control" />
		</div>
		<div class = "form-group">
			<label>Codigo Power Campus:</label>
			<input type = "text" value = "<?php echo $fedit_admin['codPowerCampus']?>" disabled="disabled" onKeyUp="this.value=this.value.toUpperCase();" maxlength = "15" name = "codPc" class = "form-control" />
		</div>
		
		
		<div class = "form-group">	
			<label>Carrera:</label><br/>
			
                        <select name = "idCarrera" id = "carrera">
							<?php  
								$qborrow = $conn->query("SELECT * FROM carrera where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idCarrera'] == $fborrow['idCarrera'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idCarrera']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
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
