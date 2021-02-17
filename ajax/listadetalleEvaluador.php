<?php
	require_once '../valid.php';

	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){*/
         $idEvaluador = $_REQUEST['idEvaluador'];
?>


							<?php
								$q_admin = $conn->query("SELECT e.dniEvaluador,e.rucEvaluador,e.nomEvaluador,e.apeEvaluador,e.relUpEvaluador,e.catEvaluador,s.descripcion as sector,e.orgaEvaluador,c.descripcion as cargo,e.descEvaluador,e.celEvaluador,e.dirEvaluador,e.correo1,e.correo2,e.nomAsistente,e.correoAsistente,e.sumillaEval,e.comentEvaluador,e.ultimaCapacitacion,e.idusuario FROM evaluador e, cargo c, sector s where e.idEvaluador = '".$idEvaluador."' and e.idSector = s.idSector and e.idCargo = c.idCargo") or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){

							?>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>


							<table style="width:100%">
  <tr>
    <th>DNI:</th>
    <td><?php echo $f_admin['dniEvaluador']?></td>
  </tr>
  <tr>
   <th>RUC:</th>
    <td><?php echo $f_admin['rucEvaluador']?></td>
  </tr>
  <tr>
    <th>Nombres:</th>
    <td><?php echo $f_admin['nomEvaluador']?></td>
  </tr>
    <tr>
    <th>Apellidos:</th>
    <td><?php echo $f_admin['apeEvaluador']?></td>
  </tr>
    <tr>
   <th>Relación con UP:</th>
    <td><?php echo ($f_admin['relUpEvaluador']==1) ? "Colaborador" : "Externo"?></td>
  </tr>
    <tr>
    <th>Categoría del evaluador:</th>
    <td><?php echo ($f_admin['catEvaluador']==1) ? "Docente" : "Especialista"?></td>
  </tr>
    <tr>
    <th>Sector en el que labora:</th>
    <td><?php echo $f_admin['sector']?></td>
  </tr>
    <tr>
    <th>Organización actual:</th>
    <td><?php echo $f_admin['orgaEvaluador']?></td>
  </tr>
    <tr>
    <th>Cargo actual:</th>
    <td><?php echo $f_admin['cargo']?></td>
  </tr>
      <tr>
    <th>Descripción del cargo:</th>
    <td><?php echo $f_admin['descEvaluador']?></td>
  </tr>
    <tr>
    	<th>Celular:</th>
    <td><?php echo $f_admin['celEvaluador']?></td>
  </tr>
    <tr>
    <th>Dirección</th>
    <td><?php echo $f_admin['dirEvaluador']?></td>
  </tr>
    <tr>
    <th>Correo principal:</th>
    <td><?php echo $f_admin['correo1']?></td>
  </tr>
    <tr>
    <th>Correo secundario:</th>
    <td><?php echo $f_admin['correo2']?></td>
  </tr>
    <tr>
    <th>Asistente:</th>
    <td><?php echo $f_admin['nomAsistente']?></td>
  </tr>
    <tr>
    	<th>Correo asistente:</th>
    <td><?php echo $f_admin['correoAsistente']?></td>
  </tr>
    <tr>
    <th>Sumilla del evaluador:</th>
    <td><?php echo $f_admin['sumillaEval']?></td>
  </tr>
    <tr>
    <th>Comentarios sobre el evaluador:</th>
    <td><?php echo $f_admin['comentEvaluador']?></td>
  </tr>
    <tr>
    <th>Última capacitación:</th>
    <td><?php echo $f_admin['ultimaCapacitacion']?></td>
  </tr>
    <tr>
    <th>Usuario:</th>
    <td><?php echo $f_admin['user']?></td>
  </tr>
</table>


							<?php
								}
							?>
