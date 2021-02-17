<?php
	include 'connect.php';

	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){*/
         $idCarreraOg = $_REQUEST['idCarreraOg'];
?>
		<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th width="25%" class="text-center">Objetivo general</th>
									<th width="15%" class="text-center">Ordenamiento</th>
                                </tr>
							</thead>
							<tbody>
							<?php
								$q_admin = $conn->query("SELECT o.idObjgeneral, o.definicion, d.ordenamiento FROM detalle_carrera_og d,objgeneral o where d.idObjgeneral = o.idObjgeneral and d.idCarreraOg='".$idCarreraOg."' and d.eliminado='0' order by d.ordenamiento") or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class = "target">
									<td><?php echo $f_admin['definicion']?></td>
									<td><?php echo $f_admin['ordenamiento']?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
