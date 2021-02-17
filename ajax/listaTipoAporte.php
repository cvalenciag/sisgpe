<?php
	require_once '../valid.php';

  $idPerfil = $_REQUEST['idPerfilEgresado'];
?>
	<table id="table" class="table table-bordered table-hover" style="width:100%">
		<thead class="alert-info">
			<tr>
				<th width="25%" class="text-center">Curso</th>
				<th width="10%" class="text-center">Ciclo</th>
				<th width="25%" class="text-center">Departamento Académico</th>
				<th width="15%" class="text-center">Tipo Curso</th>
				<th width="10%" class="text-center">AoL</th>
				<th width="15%" class="text-center">Objetivos de Aprendizaje</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$q_admin = $conn->query("SELECT dm.idCurso, c.nombreCurso, dm.ciclo, d.descripcion, c.tipoCurso, dm.aol FROM
																detalle_perfilegresado_curso dp LEFT JOIN detalle_malla dm ON (dm.idCurso = dp.idCurso)
        												LEFT JOIN perfilegresado p ON (p.idPerfilEgresado = dp.idPerfilEgresado)
        												LEFT JOIN curso c ON (c.idCurso = dm.idCurso)
        												LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
																WHERE p.idPerfilEgresado='$idPerfil' AND dm.eliminado = 0 GROUP BY dm.idCurso
																ORDER BY dm.ciclo, c.nombreCurso") or die(mysqli_error($conn));

				while($f_admin = $q_admin->fetch_array())
				{
					$idCurso = $f_admin['idCurso'];

					$result = $conn->query("SELECT COUNT(*) total FROM detalle_curso_nivelaporte where idCurso='".$idCurso."' AND eliminado='0'");

					$numReg = $result->fetch_assoc();
			?>

			<tr class="target">
				<td class="text-center"><?php echo $f_admin['nombreCurso']?></td>
				<td class="text-center"><?php echo $f_admin['ciclo']?></td>
				<td class="text-center"><?php echo $f_admin['descripcion']?></td>
				<td class="text-center"><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-académico"?></td>
				<td class="text-center"><?php echo $f_admin['aol']?></td>
				<td class="text-center"><?php echo $numReg['total']?></td>
			</tr>

			<?php
				}
			?>
		</tbody>
</table>
