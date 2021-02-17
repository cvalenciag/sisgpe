<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT c.idDepartamento,c.idCurso,c.nombreCurso,c.codUpCurso,c.tipoCurso,c.cantHorasPractica,c.cantHorasTeorica,c.credito,c.estado FROM curso c where c.idCurso = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "cursoEditar.php?admin_id=<?php echo $fedit_admin['idCurso']?>" enctype = "multipart/form-data">
	
	<div class = "form-group">
			<label>Codigo UP:</label>
			<input type = "text" disabled = "disabled" onKeyUp="this.value=this.value.toUpperCase();" value = "<?php echo $fedit_admin['codUpCurso']?>"  name = "codUpCurso" class = "form-control" maxlength = "6"/>
		</div>
		
	<div class = "form-group">
			<label>Curso:</label>
			<textarea required = "required" placeholder = "Escriba con mayúsculas y minúsculas" name = "nombreCurso" rows="3" class = "form-control" maxlength = "150"><?php echo $fedit_admin['nombreCurso']?></textarea>
		</div>

<div class = "form-group">	
			<label>Departamento académico:</label><br/>
                        <select name = "idDepartamento" id = "IdDepartamento">
							<?php  
								$qborrow = $conn->query("SELECT idDepartamento,descripcion FROM departamento where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idDepartamento'] == $fborrow['idDepartamento'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idDepartamento']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>       
		</div>			
		
		<div class = "form-group">
			<label>Tipo de curso:</label><br/>
		 <select name = "tipoCurso" required = "required" id = "tipoCurso">
                         <?php 
                            if($fedit_admin['tipoCurso']==1) { 
                                echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Académico</option>';
                                echo '<option value = "2">Para-académico</option>';
                               
                            } else {
                                 echo '<option value = "1">Académico</option>';
                                 echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Para-académico</option>';
                                  }
                            ?>
		 </select>
		</div>
		
		<div class = "form-group">
			<label>Cantidad de horas teoricas:</label>
			<input type = "number" value = "<?php echo $fedit_admin['cantHorasTeorica']?>" required = "required" min="1" max="99" step="any" name = "cantHorasTeorica" class = "form-control" onKeyPress="if(this.value.length==2) return false;"/>
		</div>
		
		<div class = "form-group">
			<label>Cantidad de horas practicas:</label>
			<input type = "number" value = "<?php echo $fedit_admin['cantHorasPractica']?>" required = "required" min="1" max="99" step="any" name = "cantHorasPractica" class = "form-control" onKeyPress="if(this.value.length==2) return false;"/>
		</div>
		
		<div class = "form-group">
			<label>Creditos:</label>
			<input type = "number" value = "<?php echo $fedit_admin['credito']?>" required = "required" min="0" max="9.99" step="any" name = "credito" class = "form-control" onKeyPress="if(this.value.length==4) return false;"/>
		</div>	
		

		<div class = "form-group">
			<label>Estado:</label><br/>
		 <select name = "estado" required = "required" id = "estado">
                          <?php 
                           if($fedit_admin['estado']==1) { 
                                echo '<option value =' . $fedit_admin['estado'] . 'selected = selected> Activo</option>';
                                echo '<option value = "2">Inactivo</option>';
                               
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

















