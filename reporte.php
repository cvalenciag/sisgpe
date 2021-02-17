<?php
	require_once 'valid.php';

?>	
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Por curso / objetivo</div>
					
					<br />
					
					 <div class = "form-group">	
                         <label>Carrera: </label>           
							<select name = "idCarrera" id = "idCarrera" required = "required" onchange="carga()">
							<option value = "" selected = "selected">todos</option>						
							<?php
								$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){                                                                   
							?>
								<option value = "<?php echo $fborrow['idCarrera']?>"><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
							
						</select>
					</div>
					
									<div class = "form-group">	
										<label>Fecha de malla curricular: </label>
										<select name = "fechaMalla" id = "fechaMalla" required = "required" onchange="carga()">
										<option value = "" selected = "selected">Todos</option>	
										</select>
                                    </div>
                                                                                                                                                                                
                                     <div class = "form-group">	
										<label>Fecha de perfil de egresado: </label>
										<select name = "fechaPerfil" id = "fechaPerfil" required = "required">
										<option value = "" selected = "selected">Todos</option>						
										</select>
                                    </div>

					<div class = "form-group">
					<label>Obligatoriedad: </label>
					<select name = "obligatorio" id = "obligatorio" required = "required" onchange="carga()">
						<option value = "" selected = "selected">Todos</option>						
							<option value = "1">Obligatorio</option>
							<option value = "2">Electivo</option>
							
						</select>
						</div>
						
					<div class = "form-group">												
					<label>Departamento académico: </label>                
					<select name = "idDpto" id = "idDpto" required = "required" onchange="carga()">
					<option value = "" selected = "selected">Todos</option>
					<?php
					$qborrow = $conn->query("SELECT idDepartamento,descripcion FROM departamento where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
					while($fborrow = $qborrow->fetch_array()){
					?>
					<option value = "<?php echo $fborrow['idDepartamento']?>"><?php echo $fborrow['descripcion']?></option>
					<?php
					}
					?>
					</select>
					</div>
					
					<br />
						
								<div id="resultados"></div>
							
			</div>
		</div>
		<br />
		<br />
		<br />
		<?php require("footer.php"); ?>
                
	
	
	<script type = "text/javascript">
        
   $(document).ready(function(){
   
    $('#obligatorio').prop("disabled", true);
	$('#idDpto').prop("disabled", true);
	$('#fechaMalla').prop("disabled", true);
	$('#fechaPerfil').prop("disabled", true);
			
    $("#idCarrera").on('change', function () {
        $("#idCarrera option:selected").each(function () {
            elegido=$(this).val();
					if(elegido == ""){
						$('#obligatorio').prop("disabled", true);
						$('#idDpto').prop("disabled", true);
						$('#fechaMalla').prop("disabled", true);
						$('#fechaPerfil').prop("disabled", true);
					} else {
						$('#obligatorio').prop("disabled", false);
						$('#idDpto').prop("disabled", false);
						$('#fechaMalla').prop("disabled", false);
						$('#fechaPerfil').prop("disabled", false);
						 }
            $.post("./ajax/agregar_reporte.php", { elegido8: elegido }, function(data){
                $("#fechaMalla").html(data);
				
            });
                $.post("./ajax/agregar_reporte.php", { elegido9: elegido }, function(data){
                $("#fechaPerfil").html(data);
				
				});	
			});
        });
		
			
			
                    $("#fechaMalla").on('change', function () {
					$("#fechaMalla option:selected").each(function () {
                        var elegido=$(this).val();
					if(elegido == ""){
						$('#obligatorio').prop("disabled", true);
						$('#idDpto').prop("disabled", true);
					} else {
						$('#obligatorio').prop("disabled", false);
						$('#idDpto').prop("disabled", false);
						 }
					});
				});
   
});


function carga(){
            var idCarrera = $("#idCarrera").val();
			var fechaMalla = $("#fechaMalla").val();
			var idDpto = $('#idDpto').val();
			var obligatorio = $('#obligatorio').val();
			
			$.ajax({
				url:'./ajax/agregar_reporte.php?idCarrera='+idCarrera+'&idDpto=' + idDpto +'&fechaMalla=' + fechaMalla +'&obligatorio=' + obligatorio,
				success:function(data){
					$('#resultados').html(data);	
				}
			})
}

$(document).ready(function(){
  carga();
})
	
	</script>
	
</html>