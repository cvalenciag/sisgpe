<?php
	include 'connect.php';

	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){*/
         $idCarreraCompetencia = $_REQUEST['idCarreraCompetencia'];
?>
		<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th width="25%" class="text-center">Competencia</th>
									<th width="15%" class="text-center">Ordenamiento</th>
                                </tr>
							</thead>
							<tbody>
							<?php
								$q_admin = $conn->query("SELECT c.idCompetencia, c.descripcion, d.ordenamiento FROM detalle_carrera_competencia d,competencia c where d.idCompetencia = c.idCompetencia and d.idCarreraCompetencia='".$idCarreraCompetencia."' and d.eliminado='0' order by d.ordenamiento") or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class = "target">
									<td><?php echo $f_admin['descripcion']?></td>
									<td><?php echo $f_admin['ordenamiento']?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
