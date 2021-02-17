<?php
	require_once '../valid.php';

	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){*/
         $idMalla = $_REQUEST['idMalla'];
?>
		<table id = "table" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									<th width="25%" class="text-center">Curso</th>
									<th width="15%" class="text-center">Departamento académico</th>
									<th width="15%" class="text-center">Tipo curso</th>
                                </tr>
							</thead>
							<tbody>
							<?php
								$q_admin = $conn->query("SELECT c.idCurso,c.nombreCurso,c.tipoCurso, d.descripcion FROM detalle_malla m,curso c, departamento d where m.idCurso = c.idCurso and c.idDepartamento = d.idDepartamento and m.idMalla='".$idMalla."' and m.eliminado='0' order by c.nombreCurso") or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
								<tr class = "target">
									<td><?php echo $f_admin['nombreCurso']?></td>
									<td><?php echo $f_admin['descripcion']?></td>
									<td><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-académico"?></td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
