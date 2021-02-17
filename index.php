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
		<link rel= "shortcut icon" type= "image/png" href= "images/favicon.png"/>
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
			<?php require("login.php"); ?>
			</div>
			<div class = "col-lg-4">
			</div>
		</div>
                
<nav class = "navbar navbar-fixed-bottom">
			<div class = "container-fluid">
				<!--<label class = "navbar-text pull-left">Vicerrectorado Académico</label>
				<label class = "navbar-text pull-right">Gestión del Aprendizaje y Aseguramiento de la Calidad</label>-->
                                
                                <div class = "form-group" align = "center" style="float:center;padding-top:20px;">
						<div><label class = "navegador" style="font-size:10px !important;color:#888;font-family:Century Gothic;">Navegadores soportados:</label></div>
						<div><img src="images/chrome.png">
						<img src="images/firefox.png">
						<img src="images/safari.png">
						<img src="images/opera.png"></div>
					</div>
			</div>
</nav>
 </body>              
        <script src = "js/jquery.js"></script>
	<script src = "js/bootstrap.js"></script>  
        <script src = "js/login.js"></script>
       
</html>
