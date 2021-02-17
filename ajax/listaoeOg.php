<?php
	require_once '../valid.php';
	$session_id= $_SESSION['session_id'];

	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){*/
         $idOgOe = $_REQUEST['idOgOe'];
?>
		<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th width="25%" class="text-center">Objetivo específico</th>
									<th width="15%" class="text-center">Ordenamiento</th>
                                </tr>
							</thead>
							<tbody>
							<?php
								$q_admin = $conn->query("SELECT o.idObjespecifico, o.definicion, d.ordenamiento FROM detalle_og_oe d,objespecifico o where d.idObjespecifico = o.idObjespecifico and d.idOgOe='".$idOgOe."' and d.eliminado='0' order by d.ordenamiento") or die(mysqli_error($conn));
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
