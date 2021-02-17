<?php
	require_once '../valid.php';
	$idRubrica	= $_REQUEST['idRubrica'];
?>

	<table id="table" class="table table-bordered table-hover" style="width:100%">
		<thead class = "alert-info">
			<tr>
				<th width="70%" class="text-center">Descripción de nivel</th>
				<th width="10%" class="text-center">Orden de Nivel</th>
				<th width="10%" class="text-center">Rotulo de Nivel</th>
				<th width="10%" class="text-center">Puntaje</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$q_admin = $conn->query("SELECT
    dr.idRubrica,
    dr.idNivel,
    n.descripcion AS descNivel, 
    dr.ordNivel,
    dr.idSubcri,
    s.descripcion AS descCriterio,
    dr.puntajeRango
FROM
    detalle_rubrica dr
        LEFT JOIN
    nivel n ON (n.idNivel = dr.idNivel)
        LEFT JOIN
    subcriterio s ON (s.idSubcriterio = dr.idSubcri)
WHERE dr.idRubrica='$idRubrica' ORDER BY dr.ordNivel") or die(mysqli_error($conn));

				while($f_admin = $q_admin->fetch_array())
				{
			?>
				<tr class = "target">
					<td class="text-justify"><?php echo $f_admin['descCriterio']?></td>
					<td class="text-center"><?php echo $f_admin['ordNivel']?></td>
					<td class="text-center"><?php echo $f_admin['descNivel']?></td>
					<td class="text-center"><?php echo $f_admin['puntajeRango']?></td>
				</tr>
				<?php
					}
				?>
		</tbody>
	</table>
