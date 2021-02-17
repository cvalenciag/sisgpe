<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT s.idSubcriterio, s.idCriterio,s.descripcion as subcriterio,s.estado FROM subcriterio s WHERE s.idSubcriterio = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "subcriterioEditar.php?idSubcriterio=<?php echo $fedit_admin['idSubcriterio']?>" enctype = "multipart/form-data">
	
<div class = "form-group">	
			<label>Criterio:</label><br/>
			
                        <select name = "idCriterio" id = "criterio">
							<?php  
								$qborrow = $conn->query("SELECT * FROM criterio where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idCriterio'] == $fborrow['idCriterio'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idCriterio']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
                        
		</div>	



	<div class = "form-group">		
									<label>Descripción:</label>
									<textarea name = "descripcion" rows="8" required = "required" class = "form-control"><?php echo $fedit_admin['subcriterio']?></textarea>
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
