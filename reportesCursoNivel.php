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
				<div class = "alert alert-jcr">Reportes / Cursos según nivel de aporte a los objetivos generales</div>
					<button type="button" style="" class="btn btn-primary" onclick="volverInicio();">
						<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
					</button>

					<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
					<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">

					<link rel="stylesheet" href="css/mis_estilos.css">
					<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
  				<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->

					<div id="admin_table">
						<?php include("modal/ver_reporteCompetencias.php"); ?>
						<div class="col-lg-12" align="center">
							<h3><b><u>Cursos según nivel de aporte a los objetivos generales</u></b></h3>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div class="form-group">
								<label>Carrera:</label><br/>
									<select name="idCarrera" id="idCarreraNivel" required="required" class="form-control" style="width:250px;">
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
									<select name="fechaMalla" id="fechaMallaNivel" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div class = "form-group">
								<label>Tipo de competencias:</label><br/>
									<select name="idCompetencia" id="idTipoCompetenciaNivel" required="required" class="form-control" style="width:250px;">
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
								<label>¿Cursos obligatorios?</label><br/>
									<select name="obligatorio" id="idObligaNivel" required="required" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
										<option value="1">Si</option>
										<option value="2">No</option>
										<option value="3">Todos</option>
									</select>
							</div>
						</div>

						<div class="col-lg-4" style="margin-top:25px;">
							<div class = "form-group">
								<label>Competencia:</label><br/>
									<select name="competencias" id="idCompetenciaNivel" class="form-control" style="width:250px;">
										<option value="" selected="selected">Seleccione una opción</option>
									</select>
							</div>

              <div class = "form-group">
								<label>Nivel de aporte:</label><br/>
                <!-- <form> -->
                  <label class="checkbox-inline">
                    <input type="checkbox" name="tipoaporte[]" id="contribuyeNivel" value="1">Contribuye
                  </label>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="tipoaporte[]" id="lograNivel" value="2">Logra
                  </label>
                  <br>
                  <label class="checkbox-inline">
                    <input type="checkbox" name="tipoaporte[]" id="sostieneNivel" value="3">Sostiene
                  </label>
                  &nbsp;&nbsp;
                  <label class="checkbox-inline">
                    <input type="checkbox" name="tipoaporte[]" id="naNivel" value="4">No aplica
                  </label>
                <!-- </form> -->
							</div>
						</div>

            <div class="col-lg-12" align="center" style="margin-top:25px;">
							<button id="" type="button" class="btn btn-primary" style="width:250px; height:35px" onclick="verReporte();">
								<span> <b>CONSULTAR</b> </span>
							</button>
            </div>
					</div> 

					<div id="divReportes" class="col-lg-12" style="margin-top:20px;">
						<label>Descargar:&nbsp;</label>
						<a href="#" id="reporteExcel" onclick="exportaExcel();"><img src="images/xls.png" alt=""></a>
						<a href="#" id="reportePDF" onclick="exportaPDF();"><img src="images/pdf.png" alt=""></a>
					</div>

					<!-- Carga los datos ajax -->
					<div class="col-md-12" id="pestanas" style="margin-top:20px">
						<ul id=lista>
                <li id="pestana1" onclick="mostrarDatos();">Detalle</li>
                <li id="pestana2" onclick="mostrarResumen();">Resumen</li>
            </ul>

						<!-- <ul class="nav nav-pills nav-justified">
    					<li class="nav-item">
      					<a class="nav-link active" onclick="mostrarDatos();">DETALLE</a>
    					</li>
    					<li class="nav-item">
      					<a class="nav-link" onclick="mostrarResumen();">RESUMEN</a>
    					</li>
  					</ul> -->
						<!-- <table style="width:100%;">
					    <tr>
					      <td class="text-center">
					        <button id="table_btn" type="button" class="btn btn-warning" style="width:428px; height:35px;" onclick="mostrarDatos();">
					          <span> <b>Detalle</b> </span>
					        </button>
					      </td>
								<td class="text-center">
					        <button id="table_btn" type="button" class="btn btn-info" style="width:428px; height:35px;" onclick="mostrarResumen();">
					          <span> <b>Resumen</span>
					        </button>
					      </td> -->
					      <!-- <td class="text-center">
					        <button id="" type="button" class="btn btn-warning" style="width:280px; height:35px;" onclick="mostrarGrafico();">
					          <span> <b>GRAFICO</b> </span>
					        </button>
					      </td> -->
					    <!-- </tr>
					  </table> -->
					</div>



          <div id="resultadosNivel" class='col-md-12'></div>
          <div id="resumenNivel" class='col-md-12'></div>
          <!-- <div id="graficoNivel" class='col-md-12'></div> -->

			</div>
		</div>
		<div class="modal fade" id="modalCursosReporte" role="dialog" tabindex="-2"></div>
		<br />
		<br />
		<br />

<?php require("footer.php"); ?>

<script type="text/javascript" src="librerias/plotly-latest.min.js"></script>
<script type="text/javascript" src="js/nuevo_reporte_nivel.js"></script>

</html>
