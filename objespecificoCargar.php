<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM objespecifico WHERE idObjespecifico = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "objespecificoEditar.php?admin_id=<?php echo $fedit_admin['idObjespecifico']?>" enctype = "multipart/form-data">
		
		<div class = "form-group">
								<label class = "titulo">Registre información sobre UN objetivo específico a la vez.</label>
								</div>
		
		<div class = "form-group">
			<label>Objetivo específico:</label>
			<textarea required = "required" rows="8" name = "definicion" class = "form-control"><?php echo $fedit_admin['definicion']?></textarea>
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












