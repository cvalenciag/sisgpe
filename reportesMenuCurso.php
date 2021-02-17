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
				<div class = "alert alert-jcr">Reportes / Cursos según aporte a las competencias</div>
					<button type="button" style="" class="btn btn-primary" onclick="returnHome();">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
					</button>

					<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
					<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

					<link rel="stylesheet" href="css/mis_estilos.css">

					<div id="admin_table">
						<?php include("modal/ver_reporteCompetencias.php"); ?>
						<div class="col-lg-12" align="center">
							<h3><b><u>Cursos según aporte a las competencias</u></b></h3>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Carrera:</label><br/>
									<select name="idCarrera" id="idCarrera" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qryCarrera = $conn->query("SELECT * FROM carrera WHERE estado=1") or die(mysqli_error($conn));

											while($resCarrera = $qryCarrera->fetch_array())
											{
										?>

										<option value="<?php echo $resCarrera['idCarrera']?>"><?php echo $resCarrera['descripcion']?></option>

										<?php
											}
										?>
									</select>
							</div>

							<div class = "form-group">
								<label>Fecha de Malla curricular:</label><br/>
									<select name="fechaMalla" id="fechaMalla" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div class = "form-group">
								<label>Tipo de competencia:</label><br/>
									<select name="idCompetencia" id="idTipoCompetencia" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<?php
											$qryTipo = $conn->query("SELECT * FROM tipocompetencia WHERE estado=1") or die(mysqli_error($conn));

											while($resTipo = $qryTipo->fetch_array())
											{
										?>

										<option value="<?php echo $resTipo['idTipo']?>"><?php echo $resTipo['descripcion']?></option>

										<?php
											}
										?>
										<option value="3">Todos</option>
									</select>
							</div>

							<div class = "form-group">
								<label>¿Cursos obligatorios?:</label><br/>
									<select name="obligatorio" id="idObliga" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<option value="1">Si</option>
										<option value="2">No</option>
										<option value="3">Todos</option>
									</select>
							</div>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div id="checkboxSelectCombo"></div>
							<div class = "form-group">
								<label>Competencia:</label><br/>
									<select name="competencias[]" id="competencias" multiple size="5" class="form-control">
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

					<div id="divReportes" class="col-lg-12" style="margin-top:25px;">
						<label>Descargar:&nbsp;</label>
						<a href="#" id="reporteExcel" onclick="exportaExcel();"><img src="images/xls.png" alt=""></a>
						<a href="#" id="reportePDF" onclick="exportaPDF();"><img src="images/pdf.png" alt=""></a>
					</div>

					<!-- Carga los datos ajax -->
					<div class="col-md-12" id="pestanas" style="margin-top:20px">
						<ul id=lista>
                <li id="pestana1" onclick="showResumen();">Detalle</li>
                <li id="pestana2" onclick="showGrafico();">Gráfico</li>
            </ul>
						<!-- <table style="width:100%;">
					    <tr>

								<td>
									<button id="" type="button" class="btn btn-info" style="width:428px; height:35px;" onclick="showResumen();">
					          <span> <b>Detalle</b> </span>
					        </button>
								</td>
					      <td class="text-center">
					        <button id="" type="button" class="btn btn-warning" style="width:428px; height:35px;" onclick="showGrafico();">
					          <span> <b>Gráfico</b> </span>
					        </button>
					      </td>
					    </tr>
					  </table> -->
					</div>

          <!-- <div id="resultados" class='col-md-12'></div> -->
          <div id="resumen" class='col-md-12'></div>
          <div id="grafico" class='col-md-12'></div>

			</div>
		</div>
		<br />
		<br />
		<br />

<?php require("footer.php"); ?>

<script type="text/javascript" src="librerias/plotly-latest.min.js"></script>
<script type="text/javascript" src="js/nuevo_reportes.js"></script>
<!-- <script src="js/jquery.multiselect.js"></script> -->

</html>
