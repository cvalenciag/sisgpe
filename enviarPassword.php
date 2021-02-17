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
                <link rel = "stylesheet" type = "text/css" href = "css/jquery.dataTables.css" />				
</head>
<body>
		<div class = "container-fluid" style = "margin-top:4%;">
			<div class = "col-lg-4">
			</div>
			
			<div class = "col-lg-4 well">
                        
                      <h3 class = "logingestor" style="text-align:center;">Gestor de Competencias</h3>                               
				<hr style = "border:1px solid #d3d3d3; width:100%;" />
		
		<label class = "control-label">Ingrese su correo electronico para recuperar contraseña:</label>
		<div class="regisFrm">
			<form enctype = "multipart/form-data">
                <div id = "username_warning" class = "form-group">
				<input type="email" id="email" name="email" placeholder="Ingresar correo electrónico" required="required" class = "form-control">
				  
                </div>
				
				<div class="form-group">
					<button type = "button" id = "forgotSubmit" class = "btn btn-primary btn-block">Enviar</button>
				</div>
				
				<div class = "form-group">
                         <a href = "index.php" class = "btn btn-editar btn-block">
						<span class = "glyphicon glyphicon-eye-open" class = "titulo"></span> Volver</a>
				</div>
			</form>
		</div>  
            
              <div style="float:center;padding-top:5px;" >                                    
			 <img border=0 src="images/gda.png" width = "100%" height = "100%" align = "center"/></label>
              </div>           
                
<div id = "result" style="float:center;padding-top:3px;">
				</div> 
		</div>				
                        
			</div>
			<div class = "col-lg-4">
			</div>
			
			
 </body>              
        <script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>  
    <script src = "js/recuperar.js"></script>	
</html>



   