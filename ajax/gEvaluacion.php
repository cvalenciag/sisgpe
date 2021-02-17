<?php
	require_once 'valid.php';
	$idUser       = $_SESSION['admin_id'];

	$qryIdEvaluador = $conn->query("SELECT * FROM evaluador WHERE idUsuario='$idUser'") or die (mysqli_error($conn));
	$resIdEvaluador = $qryIdEvaluador->fetch_array();
	$idEvaluador		= $resIdEvaluador['idEvaluador'];

	// echo $idUser;
?>
<!DOCTYPE html>
<html lang="eng">
	<?php require("head.php"); ?>
		<div class="container-fluid">
			<?php require("menu.php"); ?>
			<div class="col-lg-1"></div>
			<div class="col-lg-9 well" style="margin-top:110px;background-color:#fefefe;">
				<div class="alert alert-jcr">AoL / Evaluaciones</div>
					<?php
						if($_SESSION['rol_id'] == 1){
					?>
					<button id="generaCalculos" type="button" class="btn btn-info" onclick="genCalculos();">Generar</button>
					<?php
						}
					?>

					<?php if($_SESSION['rol_id']!=5)
					{
					?>
						<button id="addNew" type="button" class="btn btn-primary">
							<span class="glyphicon glyphicon-plus"></span> Agregar nuevo</button>
						<button id="returnNew" type="button" style="display:none;" class="btn btn-primary">
							<span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<?php
					}
					?>

					<br><br>

					<div id="admin_table">
					<label>Descargar</label>
						<table id="tableEval" class="table table-bordered table-hover" style="width:100%;">
							<thead class="alert-info">
								<tr>
									<th class="text-center">Curso</th>
									<th class="text-center">Tipo</th>
									<th class="text-center">Proyecto</th>
									<th class="text-center">Modalidad</th>
									<th class="text-center">Fecha</th>
									<th class="text-center">Estado</th>
								</tr>
							</thead>
							<tbody>
                <?php
								if($_SESSION['rol_id']==1)
									$rol=" GROUP BY idEvaluacion";
								else
									$rol=" WHERE e.estado=1 AND idEvaluador='$idEvaluador'";

                  $qryRegEvaluacion = $conn->query("SELECT idEvaluacion, e.idCurso, nombreCurso, e.idTipoeval, te.descripcion, e.idModal, e.idGrupoAlumno, ga.descripcion as nomGrupo, e.fechaEvaluacion, e.estado, e.estadoEval FROM evaluacion e
									LEFT JOIN detalle_evaluador_curso de ON (de.idCurso = e.idCurso)
	        				LEFT JOIN curso c ON (c.idCurso=e.idCurso)
                  LEFT JOIN tipo_evaluacion te ON (te.idTipoEval = e.idTipoeval)
									LEFT JOIN grupoAlumno ga ON (ga.idGrupoAl = e.idGrupoAlumno) $rol ") or die (mysqli_error($conn));

                  foreach ($qryRegEvaluacion as $qryReg)
                  {
                  ?>
                  <tr class="target">
  									<td class="text-justify"><?php echo $qryReg['nombreCurso'] ?></td>
  									<td class="text-center"><?php echo $qryReg['descripcion'] ?></td>
  									<td class="text-center"><?php echo $qryReg['nomGrupo'] ?></td>
  									<td class="text-center"><?php echo $qryReg['idModal'] == 1 ? 'Escrito' : 'Oral' ?></td>
  									<td class="text-center"><?php echo $qryReg['fechaEvaluacion'] ?></td>
  									<div style = "float:left;">
  									  <td>
                        <?php if ($qryReg['estado']==1)
												{
                          $estadoEval = $qryReg['estadoEval']==1 || $qryReg['estadoEval']==0 ? "Pendiente" : "Evaluado";
													echo $estadoEval;
                          $btnclas  = "btn-danger btn-sm";
                          $title    = "Desactivar Registro";
                          $estado   = 0;
                        }else {
                          // echo "Inactivo";
                          $btnclas  = "btn-success btn-sm";
                          $title    = "Activar registro";
                          $estado   = 1;
                        }
										?>
  									</div>
  									<div style = "float:right;">
											<?php
												if($_SESSION['rol_id']==5){
											?>
												<button type="button" class="btn btn-sm btn-success" name="button" onclick="showRegistro(<?php echo $qryReg['idEvaluacion'] ?>)">
													<span class="glyphicon glyphicon-search" title="Ver Registro"></span>
												</button>

												<a title="Iniciar evaluación" href="#" onclick="iniciarEvaluacion(<?php echo 	$qryReg['idEvaluacion'] ?>)">
													<img src="images/task.png" style="width:30px;height:30px;" />
												</a>

											<?php
												}else {
											?>
												<button type="button" class="btn btn-sm btn-success" name="button" onclick="showRegistro(<?php echo $qryReg['idEvaluacion'] ?>)">
													<span class="glyphicon glyphicon-search" title="Ver Registro"></span>
												</button>

												<button type="button" class="btn btn-sm btn-editar" name="button" onclick="editEvaluacion(<?php echo $qryReg['idEvaluacion'] ?>)">
													<span class = "glyphicon glyphicon-edit" title="Editar Registro"></span>
												</button>

												<!-- <button type="button" class="btn btn-sm <?php echo $btnclas ?>" name="button"
													value="" id="btnDeleteEval_<?php echo $qryReg['idEvaluacion'] ?>_<?php echo $estado ?>" onclick="deleteReg(this.id);">
													<span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
												</button> -->
												<a href="#" class="btn <?php echo $btnclas?> deladmin_id" value="<?php echo 	$qryReg['idEvaluacion'].'&estado='.$estado?>">
												<span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
												</a>

												<a title="Iniciar evaluación" href="#" onclick="iniciarEvaluacion(<?php echo 	$qryReg['idEvaluacion'] ?>)">
													<img src="images/task.png" style="width:30px;height:30px;" />
												</a>

											<?php
												}
											?>



  									</div>
                    </td>
  								</tr>
                  <?php
                  }
                ?>

							</tbody>
						</table>
					</div>
					<div id="edit_form"></div>
					<div id="admin_form" style="display:none;">
						<div class="col-lg-2"></div>
						<div class="col-lg-6">

							<!-- <div class="form-group">
                <label>Carrera:</label><br/>
						    <select name="idCarrera" id="idCarrera" required = "required">
                  <option value="" selected="selected">Seleccione una opción</option>
                  <?php
                  $qryCarreras = $conn->query("SELECT * FROM carrera WHERE estado=1 ORDER BY nombreCorto") or die(mysqli_error($conn));

                  while ($resCarreras = $qryCarreras->fetch_array()) {
                  ?>
                    <option value="<?php echo $resCarreras['idCarrera'] ?>">
                      <?php echo $resCarreras['descripcion'] ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
							</div> -->

							<div class="form-group">
                <label>Departamento Académico:</label><br/>
						    <select name="depAcad" id="idDepAcad" required = "required" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                  <?php
                  $qryDepAcad = $conn->query("SELECT * FROM departamento WHERE estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

                  while ($resQryAcad = $qryDepAcad->fetch_array()) {
                  ?>
                    <option value="<?php echo $resQryAcad['idDepartamento'] ?>">
                      <?php echo $resQryAcad['descripcion'] ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>
							</div>

              <div class="form-group">
                <label>Curso:</label><br/>
						    <select name="idCurso" id="idCurso" required = "required" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                </select>
							</div>


							<div class="form-group">
                <label>Tipo de evaluación:</label><br/>
                <select name="idTipoEval" id="idTipoEval" required="required" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                  <?php
                    $qryTipoEval = $conn->query("SELECT * FROM tipo_evaluacion WHERE estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

                    while($resTipoEval = $qryTipoEval->fetch_array()){
                  ?>
                    <option value="<?php echo $resTipoEval['idTipoEval'] ?>">
                      <?php echo $resTipoEval['descripcion'] ?>
                    </option>
                  <?php
                    }
                  ?>
                </select>
              </div>


							<div class="form-group">
								<label>Modalidad:</label><br/>
                <select name="idModalidad" id="idModalidad" required="required" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                  <option value="1">Escrito</option>
                  <option value="2">Oral</option>
                </select>
							</div>

              <div class="form-group">
								<label>Fecha de evaluación:</label><br/>
								<input type="date" name="fechaEval" id="fechaEval" value="<?php echo date('Y-m-d') ?>"/>
              </div>

							<div class="form-group">
								<label>Semestre:</label><br/>
								<select name="idSemestre" id="idSemestre" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                  <?php
                    $añoAct = date("Y");
                    $añoAnt = date('Y', strtotime("$añoAct -1 year") );
                  ?>
									<option value="<?php echo $añoAnt.'-1' ?>" ><?php echo $añoAnt.'-1' ?></option>
									<option value="<?php echo $añoAnt.'-2' ?>" ><?php echo $añoAnt.'-2' ?></option>
									<option value="<?php echo $añoAct.'-1' ?>" ><?php echo $añoAct.'-1' ?></option>
									<option value="<?php echo $añoAct.'-2' ?>" ><?php echo $añoAct.'-2' ?></option>

                </select>
							</div>

							<div class="form-group">
								<label>Nombre de proyecto:</label><br/>
								<select name="idGrupoAlum" id="idGrupoAlum" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
									<?php
						        $qryGrupos = $conn->query("SELECT * FROM grupoAlumno WHERE estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

						        foreach ($qryGrupos as $gpos)
						        {
						        ?>
						          <option value="<?php echo $gpos['idGrupoAl'] ?>"><?php echo $gpos['descripcion'] ?></option>
						        <?php
						        }
						      ?>
                </select>
							</div>

              <!-- Carga los datos ajax -->
              <div id="resultados" class='col-md-12' style="margin-top:10px"></div>

							<div class="form-group">
								<button id="btnRegistrar" class="btn btn-primary" name="" onclick="saveEvaluacion();">
                  <span class = "glyphicon glyphicon-save"></span> Registrar
                </button>
							</div>
						</div>
            <div class="col-lg-2">
              <br><br><br>

  						<div class="form-group">
                <label>Rúbrica:</label><br/>
                <select name="idRubrica" id="idRubrica" required="required" onchange="validaCampos();">
                  <option value="" selected="selected">Seleccione una opción</option>
                </select>
  						</div>

              <br><br><br>

              <div class="form-group">
                <button type="button" class="btn btn-md btn-warning" id="addEvaluadores" onclick="showModalEval();">
                  <span class="glyphicon glyphicon-plus"></span> Agregar Evaluadores
                </button>
              </div>

							<div id="resultEvaluadores" class='col-md-12' style="margin-top:10px"></div>

              <br><br><br><br>
              <div class="form-group">
                <button type="button" class="btn btn-md btn-success" id="showDetalles" onclick="showDetalles();">Ver Detalles
                </button>
              </div>
            </div>
					</div>
			</div>
		</div>

    <div class="modal fade" id="modalAddEvaluadores" role="dialog" tabindex="-2"></div>
    <div class="modal fade" id="modalVerAlumnos" role="dialog" tabindex="-2"></div>
    <div class="modal fade" id="modalVerRegistroEval" role="dialog" tabindex="-2"></div>
		<br><br><br>

		<?php require("footer.php"); ?>
    <script type="text/javascript" src="js/nueva_evaluacion.js"></script>

		<script type = "text/javascript">
		$(document).ready(function(){
			$result = $('<center><label>Activando/Desactivando el registro...</label></center>');
			$("#tableEval").on("click", ".deladmin_id", function(){
				admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'gEvaluacionEliminar.php?idEvaluacion='+admin_id;
				}, 1000);
			});
		});
	</script>
</html>
