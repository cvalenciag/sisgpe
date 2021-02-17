<?php
	require_once 'valid.php';
?>
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style="margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Reportes / Malla Curricular</div>
					<button type="button" style="" class="btn btn-primary" onclick="volverInicio();">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
					</button>

					<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
					<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

					<div id="admin_table">
						<div class="col-lg-12" align="center">
							<h3><b><u>Reporte de Malla Curricular</u></b></h3>
						</div>

						<div class="col-md-3" style="margin-top:25px;">
							<div class="form-group">
								<label>Facultad:</label><br/>
									<select name="idFacultad" id="idFacultadMP" required="required" class="form-control" style="width:200px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qryFac = $conn->query("SELECT * FROM facultad WHERE estado=1") or die(mysqli_error($conn));

											while($resFac	= $qryFac->fetch_array())
											{
										?>

										<option value="<?php echo $resFac['idFacultad']?>"><?php echo $resFac['descripcion']?></option>

										<?php
											}
										?>
									</select>
							</div>
						</div>

						<div class="col-md-3" style="margin-top:25px;">
							<div class="form-group">
								<label>Carrera:</label><br/>
									<select name="idCarrera" id="idCarreraMP" required="required" class="form-control" style="width:200px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>
						</div>

						<div class="col-md-3" style="margin-top:25px;">
							<div class = "form-group">
								<label>Fecha de Malla curricular:</label><br/>
									<select name="fechaMP" id="fechaMP" required="required" class="form-control" style="width:200px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>
						</div>

						<div class="col-md-3" style="margin-top:25px;">
							<div class = "form-group">
								<label>Cursos obligatorios:</label><br/>
									<select name="obligatorio" id="idObligaMP" required="required" class="form-control" style="width:200px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<option value="1">Si</option>
										<option value="0">No</option>
										<option value="-1">Todos</option>
									</select>
							</div>
						</div>


            <div class="col-lg-12" align="center" style="margin-top:25px;">
							<button id="" type="button" class="btn btn-primary" style="width:250px; height:35px" onclick="generaReporte();">
								<span> <b>CONSULTAR</b> </span>
							</button>
            </div>
					</div>


					<div id="divReportesMalla" class="col-lg-12" style="margin-top:25px;">
						<label>Descargar:&nbsp;</label>
						<a href="#" id="reporteExcel" onclick="exportaExcelMalla();"><img src="images/xls.png" alt=""></a>
						<a href="#" id="reportePDF" onclick="exportaPDFMalla();"><img src="images/pdf.png" alt=""></a>
					</div>

          <div id="resultadosMP" class='col-md-12'></div>


			</div>
		</div>
		<br />
		<br />
		<br />

<?php require("footer.php"); ?>

<!-- <script type="text/javascript" src="librerias/plotly-latest.min.js"></script> -->
<script type="text/javascript" src="js/nuevo_reporte_mallaperfil.js"></script>

</html>
