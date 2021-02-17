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
				<div class = "alert alert-jcr">Reportes / Logro de Competencias del Alumno por Carrera</div>
					<button type="button" style="" class="btn btn-primary" onclick="volverInicio();">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
					</button>

					<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
					<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

					<link rel="stylesheet" href="css/mis_estilos.css">

					<div id="admin_table">
						<div class="col-lg-12" align="center">
							<h3><b><u>Reporte de Logro de Competencias del Alumno por Carrera</u></b></h3>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Carrera:</label><br/>
									<select name="idCarrera" id="idCarrera" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qryCarrera = $conn->query("SELECT * FROM carrera WHERE estado=1") or die(mysqli_error($conn));

											foreach ($qryCarrera as $carrera)
                      {
                    ?>

										<option value="<?php echo $carrera['idCarrera']?>"><?php echo $carrera['descripcion']?></option>

										<?php
											}
										?>
									</select>
							</div>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Evaluación 1:</label><br/>
									<select name="idSemestre1" id="idSemestre1" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$añoActual 		= date("Y");
											$añoAnterior	= date("Y") - 1;

										?>

										<option value="<?php echo $añoAnterior.'-1' ?>"><?php echo $añoAnterior.'-1' ?></option>
										<option value="<?php echo $añoAnterior.'-2' ?>"><?php echo $añoAnterior.'-2' ?></option>
										<option value="<?php echo $añoActual.'-1' ?>"><?php echo $añoActual.'-1' ?></option>
										<option value="<?php echo $añoActual.'-2' ?>"><?php echo $añoActual.'-2' ?></option>
									</select>
							</div>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class = "form-group">
								<label>Evaluación 2:</label><br/>
									<select name="idSemestre2" id="idSemestre2" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$añoActual 		= date("Y");
											$añoAnterior	= date("Y") - 1;

										?>

										<option value="<?php echo $añoAnterior.'-1' ?>"><?php echo $añoAnterior.'-1' ?></option>
										<option value="<?php echo $añoAnterior.'-2' ?>"><?php echo $añoAnterior.'-2' ?></option>
										<option value="<?php echo $añoActual.'-1' ?>"><?php echo $añoActual.'-1' ?></option>
										<option value="<?php echo $añoActual.'-2' ?>"><?php echo $añoActual.'-2' ?></option>
									</select>
							</div>
						</div>


            <div class="col-lg-12" align="center" style="margin-top:25px;">
							<button id="" type="button" class="btn btn-primary" style="width:250px; height:35px" onclick="generaReporte();">
								<span> <b>CONSULTAR</b> </span>
							</button>
            </div>
					</div>


					<div id="divReportesLogros" class="col-lg-12" style="margin-top:25px;">
						<label>Descargar:&nbsp;</label>
						<a href="#" id="reporteExcel" onclick="exportaExcelLogro();"><img src="images/xls.png" alt=""></a>
						<a href="#" id="reportePDF" onclick="exportaPDFLogro();"><img src="images/pdf.png" alt=""></a>
					</div>

					<div class="col-md-12" id="pestanas" style="margin-top:20px">
						<ul id=lista>
                <li id="pestana1" onclick="showResumen();">Detalle</li>
                <li id="pestana2" onclick="showGrafico();">Gráfico</li>
            </ul>
					</div>

          <!-- <div id="resultadosLogro" class='col-md-12'></div> -->
					<div id="resumen" class='col-md-12'></div>
          <div id="grafico" class='col-md-12'></div>

			</div>
		</div>
		<br />
		<br />
		<br />

<?php require("footer.php"); ?>

<script type="text/javascript" src="librerias/plotly-latest.min.js"></script>
<script type="text/javascript" src="js/nuevo_reporte_logros.js"></script>

</html>
