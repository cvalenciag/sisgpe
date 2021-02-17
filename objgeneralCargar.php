<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT og.idCompetencia,og.idObjgeneral,og.codObjGeneral,og.definicion as definicion,og.estado FROM objgeneral og where og.idObjgeneral = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "objgeneralEditar.php?admin_id=<?php echo $fedit_admin['idObjgeneral']?>" enctype = "multipart/form-data">
	
	<div class = "form-group">
								<label class = "titulo">Registre información sobre UN objetivo general a la vez.</label>
								</div>
								
								<div class = "form-group">
									<label>Código objetivo general:</label>
									<input type = "text" disabled = "disabled" value = "<?php echo $fedit_admin['codObjGeneral']?>" onKeyUp="this.value=this.value.toUpperCase();" name = "codObjGeneral" class = "form-control" maxlength = "12"/>
								</div>
	
		<div class = "form-group">
			<label>Objetivo general:</label>
			<textarea required = "required" rows="8" name = "definicion" class = "form-control"><?php echo $fedit_admin['definicion']?></textarea>
		</div>	
		
		<div class = "form-group">	
			<label>Competencia:</label><br/>
			
                        <select name = "idCompetencia" id = "competencia">
                                                      <?php  
								$qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idCompetencia'] == $fborrow['idCompetencia'])
                                                                        $selected = "selected=selected";
                                                                    
							?>
								<option value = "<?php echo $fborrow['idCompetencia']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>       
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
<script type = "text/javascript">
		$(document).ready(function(){
			CKEDITOR.replace( 'definicion' );
		});
</script>	