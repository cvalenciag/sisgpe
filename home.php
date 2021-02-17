<?php
	require_once 'valid.php';
?>
<!DOCTYPE html>
<html lang = "eng">
<?php require("head.php"); ?>

<div class = "container-fluid">
         <div style="height:35px;"></div>

<div class = "col-lg-3 well" style = "margin-top:90px;background-color:#fefefe;">
                                <?php require("cuenta_user.php")?>
				<hr style = "border:1px dotted #d3d3d3;"/>
				<div class = "form-group" style="margin-top:100px;">
                                        <a class = "btn btn-primary btn-block" href = "logout.php"><i class = "glyphicon glyphicon-log-out"></i> Cerrar Sesión</a>
				</div>
</div>


<?php if($_SESSION['rol_id']==5){ ?>
	<div class = "col-lg-3" style = "margin-top:90px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "evaluacionesEvaluador">
						<img src = "images/evaluaciones.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> AoL</a>
					</div>
	</div>

	<div class = "col-lg-3" style = "margin-top:90px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "reportes">
						<img src = "images/reportes.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> Reportes</a>
					</div>
	</div>


	<div class = "col-lg-3" style = "margin-top:50px; margin-left: 1px; display: flex;justify-content: center;">
	                 <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "documentos">
						<img src = "images/icono6.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px" ><i ></i> Documentos</a>
					</div>
	</div>

<?php }else { ?>
	<div class = "col-lg-3" style = "margin-top:90px;display: flex;justify-content: center;">

	                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "administracion">
	                                <img src = "images/gestiondatos.png" width = "75px" height = "75px"/>
									<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i>Administración</a>
					</div>
	</div>

	<div class = "col-lg-3" style = "margin-top:90px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "planestudios">
						<img src = "images/planestudios.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> Diseño Curricular</a>
					</div>
	</div>


	<div class = "col-lg-3" style = "margin-top:90px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "reportes">
						<img src = "images/reportes.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> Reportes</a>
					</div>
	</div>

	 <?php if($_SESSION['rol_id']==1){ ?>
	<div class = "col-lg-3" style = "margin-top:50px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "usuarios">
						<img src = "images/usuarios.png" width = "75px" height = "75px"/>


						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> Seguridad</a>
					</div>
	</div>
	<?php }?>

	<div class = "col-lg-3" style = "margin-top:50px;display: flex;justify-content: center;">
	                                <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "evaluaciones">
						<img src = "images/evaluaciones.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px"><i ></i> AoL</a>
					</div>
	</div>



	<div class = "col-lg-3" style = "margin-top:50px;display: flex;justify-content: center;">
	                 <div class = "bordeando btn btn-home btn-block" style="width:70% !important;padding:20px 0px 20px 0px;" id = "documentos">
						<img src = "images/icono6.png" width = "75px" height = "75px"/>

						<a style="color: #fff;display: block;width: 100%;padding: 6px 12px;text-decoration:none;font-size:17px" ><i ></i> Documentos</a>
					</div>
	</div>
<?php } ?>



</div>
<br />
		<br />
		<br />
   <?php
   require("footer.php");
   ?>

   <script type = "text/javascript">
   $('#administracion').click(function(){

				window.location = "facultad.php";
				});

				 $('#planestudios').click(function(){

				window.location = "malla.php"; 
				});

					 $('#reportes').click(function(){

				window.location = "reportesMenuCurso.php";
				});

				 $('#usuarios').click(function(){

				window.location = "usuario.php";
				});

				 $('#evaluaciones').click(function(){

				window.location = "tipoevaluacion.php";
				});
				 $('#evaluacionesEvaluador').click(function(){

				window.location = "gEvaluacion.php";
				});

				$('#documentos').click(function(){

				window.location = "home.php";
				});
				</script>

   </html>
