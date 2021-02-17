<?php 
	session_start();
	if(isset($_SESSION['admin_id'])){
		header('location:home.php');
	}
?>
<!DOCTYPE html>
<html lang = "eng">
<head>
		<title>Sistema de aseguramiento del aprendizaje (AoL) | Pre-grado UP</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
                <link rel = "stylesheet" type = "text/css" href = "css/chosen.min.css" />
                <link rel = "stylesheet" type = "text/css" href = "css/main.css" />
</head>
<body>
		<div class = "container-fluid" style = "margin-top:4%;">
			<div class = "col-lg-4">
			</div>		
	<div class = "col-lg-4 well">
     <h3 class = "logingestor" style="text-align:center;">Gestor de Competencias</h3>                               
				<hr style = "border:1px solid #d3d3d3; width:100%;" />
		<label class = "control-label">Reestablecer contraseña contraseña:</label>
		<div class="regisFrm">
			<form enctype = "multipart/form-data">	
                 <div id = "password_warning" class = "form-group">
				<input type="password" name="password" id = "password" placeholder="contraseña" class = "form-control" required="required"></div>
				
                 <div id = "cpassword_warning" class = "form-group">
				<input type="password" name="confirm_password" id = "confirm_password" placeholder="confirmar contraseña" class = "form-control" required="required">
                 </div>
				<div class="send-button">
					<input type="hidden" id="fp_code" name="fp_code" value="<?php echo $_REQUEST['fp_code']; ?>"/>
                    <input type="hidden" id="id_code" name="id_code" value="<?php echo $_REQUEST['id_code']; ?>"/>
					<button type="button" class = "btn btn-primary btn-block" id="resetSubmit">Recuperar contraseña </button>
				</div>
				 <div style="float:center;padding-top:15px;" >                             
				<img border=0 src="images/gda.png" width = "100%" height = "100%" align = "center"/>
                </div>
				<div id = "result" style="float:center;padding-top:3px;">
				</div>  				
				
			</form>
		</div>
			<div class = "col-lg-4">
			</div>
		</div>	
	  <script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>  
    <script src = "js/resetear.js"></script>	
 </body>              
       
</html>
