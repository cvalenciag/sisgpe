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
				<div class = "alert alert-jcr">Reportes / Rubricas por carrera</div>
					<button type="button" style="" class="btn btn-primary" onclick="volverInicio();">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
					</button>

					<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
					<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

					<link rel="stylesheet" href="css/mis_estilos.css">

					<div id="admin_table">
						<div class="col-lg-12" align="center">
							<h3><b><u>Reporte de rubricas por carrera</u></b></h3>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Curso AoL:</label><br/>
									<select name="idCursoRC" id="idCursoRC" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qryCursos = $conn->query("SELECT * FROM curso WHERE estado=1 ORDER BY nombreCurso") or die(mysqli_error($conn));

											foreach ($qryCursos as $cursos)
                      {
                    ?>

										<option value="<?php echo $cursos['idCurso']?>"><?php echo $cursos['nombreCurso']?></option>

										<?php
											}
										?>
									</select>
							</div>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Modalidad:</label><br/>
									<select name="idModalidadRC" id="idModalidadRC" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<option value="1">Oral</option>
										<option value="2">Escrito</option>
									</select>
							</div>
						</div>

						<div class="col-md-4" style="margin-top:25px;">
							<div class = "form-group">
								<label>Fecha de aprobación:</label><br/>
									<select name="fechaAprobacionRC" id="fechaAprobacionRC" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>
						</div>


            <div class="col-lg-12" align="center" style="margin-top:25px;">
							<button id="" type="button" class="btn btn-primary" style="width:250px; height:35px" onclick="generaReporte();">
								<span> <b>CONSULTAR</b> </span> 
							</button>
            </div>
					</div>


					<div id="divReportesRubricaC" class="col-lg-12" style="margin-top:25px;">
						<label>Descargar:&nbsp;</label>
						<a href="#" id="reporteExcel" onclick="exportaExcelRubC();"><img src="images/xls.png" alt=""></a>
						<a href="#" id="reportePDF" onclick="exportaPDFRubC();"><img src="images/pdf.png" alt=""></a>
					</div>

          <div id="resultadosRubricaC" class='col-md-12'></div>

			</div>
		</div>
		<br />
		<br />
		<br />

<?php require("footer.php"); ?>

<script type="text/javascript" src="js/nuevo_reporte_rubrica.js"></script>

</html>
