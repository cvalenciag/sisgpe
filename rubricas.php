<?php
	require_once 'valid.php';
?>
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class="container-fluid">
			<?php require("menu.php"); ?>
			<div class="col-lg-1"></div>
			<div class="col-lg-9 well" style="margin-top:110px;background-color:#fefefe;">
				<div class="alert alert-jcr">Rubrica / Curso y sus criterios de evaluación</div>
					<button id="add_admin" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id="show_admin" type="button" style="display:none;" class="btn btn-primary">
            <span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver
          </button>

					<br><br>

					<?php
						$sqlTempo = $conn->query("SELECT * FROM tmp") or die(mysqli_error($conn));
						if ($sqlTempo->num_rows>0){
							$delete=mysqli_query($conn, "DELETE FROM tmp");
						}
					?>

					<div id="admin_table">
					<label>Descargar</label>
						<table id="table" class="table table-bordered table-hover" style="100%">
							<thead class = "alert-info">
								<tr>
                  <th class="text-center">Curso AoL</th>
									<th class="text-center">Cantidad de Criterios</th>
									<th class="text-center">Fecha de <br> aprobación</th>
									<th class="text-center">Estado</th>
								</tr>
							</thead>
							<tbody>
							 <?php
							  if($_SESSION['rol_id']==1)
                	$rol="";
								else
								$rol=" WHERE r.estado=1";

                $qryRubricas = $conn->query("SELECT idRubrica, idCurso, nombreCurso, fechaAprobacion, r.estado
								FROM rubrica r LEFT JOIN curso c USING (idCurso) $rol") or die(mysqli_error($conn));

                foreach ($qryRubricas as $rubricas)
                {
									$idCurso   	= $rubricas['idCurso'];
									$idRubrica	= $rubricas['idRubrica'];

                  $qryTotRub = $conn->query("SELECT COUNT('".$idCurso."') totalRubricas FROM detalle_rubrica where idCurso='".$idCurso."' AND idRubrica='$idRubrica'");
									$totalRub  = $qryTotRub->fetch_assoc();

							?>
								<tr class="target">
                  <td class="text-justify"><?php echo $rubricas['nombreCurso'] ?></td>
									<td class="text-center"><?php echo $totalRub['totalRubricas'];?></td>
									<td class="text-center"><?php echo $rubricas['fechaAprobacion'] ?></td>
									<div style = "float:left;">
									  <td><?php if ($rubricas['estado']==1)
                    {
									    echo "Activo";
									    $btnclas = "btn-danger";
									    $title   = "Desactivar Registro";
									    $estado  = 0;
									}else {
									    echo "Inactivo";
									    $btnclas = "btn-success";
									    $title   = "Activar Registro";
									    $estado  = 1;
									}
									?>

									</div>

                  <div style = "float:right;">
                    <!-- <button type="button" name="button" class="btn btn-sm btn-success vadmin_id" value="<?php echo $rubricas['idRubrica'] ?>" onclick="muestraRegistros(<?php echo $rubricas['idRubrica'] ?>)">
                      <span class="glyphicon glyphicon-search" title="Ver Registro"></span>
                    </button> -->

                    <button type="button" name="button" class="btn btn-sm btn-editar eadmin_id" value="<?php echo $rubricas['idRubrica'] ?>">
                      <span class="glyphicon glyphicon-edit" title="Editar Registro"></span>
                    </button>

                    <!-- <button type="button" name="button" class="btn btn-sm <?php echo $btnclas?> deladmin_id" value="<?php echo $rubricas['idRubrica'] ?>">
                      <span class="glyphicon glyphicon-off" title="<?php echo $title?>"></span>
                    </button> -->
										<a href="#" class="btn btn-sm <?php echo $btnclas?> deladmin_id" value="<?php echo $rubricas['idRubrica'].'&estado='.$estado ?>">
											<span class="glyphicon glyphicon-off" title="<?php echo $title?>"></span>
										</a>
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
					<div id="admin_form" style = "display:none;">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<div class="form-group">
                <label>Curso AoL:</label><br/>
						    <select name="idCurso" id="idCurso" required="required">
                  <option value="" selected="selected">Seleccione una opción</option>
							    <?php
								    $qryCursos = $conn->query("SELECT idCurso, nombreCurso FROM curso c LEFT JOIN detalle_malla dm USING(idCurso) WHERE c.estado=1 AND dm.AoL=1 AND dm.eliminado=0 GROUP BY idCurso ORDER BY nombreCurso") or die(mysqli_error($conn));

                    foreach ($qryCursos as $cursos)
                    {
							    ?>
								      <option value="<?php echo $cursos['idCurso']?>"><?php echo $cursos['nombreCurso']?></option>
							    <?php
								    }
							    ?>
						    </select>
							</div>

              <div class="form-group">
								<label>Fecha de aprobación:</label><br/>
								<input type="date" name="fAprobacion" id="fAprobacion" value="<?php echo date("Y-m-d");?>"/>
              </div>

              <div class="form-group">
								<label>Estado:</label><br/>
								<select name="estado" id="estado">
							     <option value="1" selected="selected">Activo</option>
							     <option value="0" >Inactivo</option>
						     </select>
							</div>

              <!-- BOTON PARA MOSTRAR EL MODAL -->
              <div class="form-group">
                <button type="button" class="btn btn-default" id="btnAddCriterios" onclick="showModalCriterios();">
                  <span class="glyphicon glyphicon-search"></span> Agregar Criterios
                </button>
              </div>

              <!-- Carga los datos ajax -->
              <div id="resultados" class='col-md-12' style="margin-top:10px"></div>

              <div class="form-group">
                <button class="btn btn-primary" name="" id="btnSaveRubrica" onclick="saveRubrica();">
                  <span class="glyphicon glyphicon-save"></span> Guardar
                </button>
              </div>
						</div>
					</div>
			</div>
		</div>
    <div class="modal fade" id="modalAddCriterios" role="dialog" tabindex="-2"></div>
    <div class="modal fade" id="modalShowCriterios" role="dialog" tabindex="-2"></div>
		<br><br><br>
		<?php require("footer.php"); ?>
    <script type="text/javascript" src="js/nuevo_rubrica.js"></script>
		<script type="text/javascript">
		$( function() {
			$( "#fAprobacion" ).datepicker({
				showOn: "button",
				buttonImage: "images/calendario.png",
				buttonImageOnly: true,
				dateFormat: 'yy-mm-dd',
				buttonText: "Select date"
			});
		});

		//PARA LA TABLA GENERAL ==================================
		$(document).ready(function() {
			$('#table').DataTable( {
				"language": {
						"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
					},
					dom: 'Bfrtip',
					 buttons: [
					{
						extend: 'pdf',
						text: '<img src="images/pdf.png" width=20 height=20/>',
						titleAttr: 'Exportar a pdf'
					},
					{
						extend: 'excel',
						text: '<img src="images/xls.png" width=20 height=20/>',
						titleAttr: 'Exportar a excel'
					},
					{
						extend: 'csv',
						text: '<img src="images/csv.png" width=20 height=20/>',
						titleAttr: 'Exportar a csv'
					},
					{
						extend: 'print',
						text: '<img src="images/print.png" width=20 height=20/>',
						titleAttr: 'Imprimir'
					}],
				columnDefs: [
					{ width: "55%", targets: 0 },
					{ width: "15%", targets: 1 },
					{ width: "15%", targets: 2 },
					{ width: "15%", targets: 3 },
				],
			});
		});


		$(document).ready(function(){
			$('#btnSaveRubrica').attr("disabled", true);
			$('#btnAddCriterios').attr("disabled", true);
			$('#add_admin').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#admin_table').slideUp();
				$('#admin_form').slideDown();

			$('#show_admin').click(function(){
				$(this).hide();
				$('#add_admin').show();
				$('#admin_table').slideDown();
				$('#admin_form').slideUp();
				window.location = 'rubricas.php';
			});
			});
		});


		$(document).ready(function(){
			$('#btnSaveRubrica').attr("disabled", true);
			$('#btnAddCriterios').attr("disabled", true);
			$("#idCurso").on('change', function () {
				$("#idCurso option:selected").each(function () {
					var idCurso = $(this).val();
					if(idCurso == ""){
						$('#btnSaveRubrica').attr("disabled", true);
						$('#btnAddCriterios').attr("disabled", true);
					}else{
						$('#btnSaveRubrica').attr("disabled", false);
						$('#btnAddCriterios').attr("disabled", false);
					}
					});
				});
		});


		//FUNCIONES PARA CARGA Y ACTUALIZACION DE DATOS =============================================================
		$(document).ready(function(){
		  $("#table").on("click", ".eadmin_id", function(){
		    $admin_id = $(this).attr('value');
		    $('#show_admin').show();
		    $('#show_admin').click(function(){
		      $(this).hide();
		      $('#edit_form').empty();
		      $('#admin_table').show();
		      $('#add_admin').show();
		    });

		    $('#admin_table').fadeOut();
		    $('#add_admin').hide();
		    $('#edit_form').load('rubricasCargar.php?admin_id='+$admin_id);
		  });


			$result = $('<center><label>Activando/Desactivando el registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
				admin_id = $(this).attr('value');
				$(this).parents('td').empty().append($result);
				$('.deladmin_id').attr('disabled', 'disabled');
				$('.eadmin_id').attr('disabled', 'disabled');
				setTimeout(function(){
					window.location = 'rubricasEliminar1.php?admin_id='+admin_id;
				}, 1000);
			});

		});
		</script>
</html>
