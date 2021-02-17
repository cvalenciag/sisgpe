<?php

require_once '../valid.php';

$idFacultad 	= (isset($_REQUEST['idFacultad']) && !empty($_REQUEST['idFacultad']))?$_REQUEST['idFacultad']:'';
$idCarrera  	= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaPerfil 	= (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';


$sql = $conn->query("SELECT * FROM tipocompetencia WHERE estado=1") or die(mysqli_error($conn)); 
?>

<div class=""style="margin-top:15px;">
	<table id="tablaPerfil" class="table table-bordered" style="width:100%;">
  	<thead>
			<tr bgcolor="#E7E6E6">
		 		<th class="text-center" colspan="4"><font color="#595959">Perfil de egreso</font></th>
		 	</tr>
     	<!-- <tr bgcolor="#A6A6A6">
       	<th class="text-center" colspan="2"><font color="#fff">Competencia</font></th>
       	<th class="text-center"><font color="#fff">Objetivo General</font></th>
       	<th class="text-center"><font color="#fff">Objetivo Específico</font></th>
     	</tr> -->
   	</thead>
   	<tbody>
     	<?php
       	while ($row = mysqli_fetch_array($sql))
       	{
					$idTipo = $row['idTipo'];

					$sql2 = $conn->query("SELECT dcn.idCarrera, dcn.idCompetencia, dcn.idTipo, c.descripcion, ordenamiento as ordenComp FROM
    detalle_curso_nivelaporte dcn
        LEFT JOIN
    competencia c ON (c.idCompetencia = dcn.idCompetencia
        AND c.idTipo = dcn.idTipo)
				LEFT JOIN
    detalle_carrera_competencia dcc ON (dcc.idCarrera = dcn.idCarrera
        AND dcc.idCompetencia = dcn.idCompetencia)
WHERE
    dcn.idCarrera ='$idCarrera' AND dcn.idTipo ='$idTipo'
GROUP BY dcn.idCompetencia") or die(mysqli_error($conn));

     	?>
       	<tr>
         	<td class="text-justify" colspan="4"><font color="   <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
			      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
			      ($idCarrera==21 ? '#1e9bd1' :
			      ($idCarrera==31 ? '#f0a02b' :
			      ($idCarrera==32 ? '#f9d126' :
			      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?> " size=3><b><?php echo $row['descripcion'] ?></b	></font></td>
      	</tr>

					<?php
					while ($row2 = mysqli_fetch_array($sql2))
	       	{
						$idCompetencia	= $row2['idCompetencia'];

						$sql3 = $conn->query("SELECT * FROM detalle_curso_nivelaporte dcn
        													LEFT JOIN objgeneral c ON (c.idObjgeneral = dcn.idObjgeneral
        													AND c.idCompetencia = dcn.idCompetencia)
																	LEFT JOIN detalle_carrera_og dco ON (dco.idCarrera = dcn.idCarrera
        													AND dco.idObjgeneral = dcn.idObjgeneral)
																	WHERE dcn.idCarrera = '$idCarrera' AND dcn.idTipo = '$idTipo'
        													AND dcn.idCompetencia = '$idCompetencia'
																	GROUP BY dcn.idObjGeneral") or die(mysqli_error($conn));

					?>
						<tr bgcolor="   <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
				      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
				      ($idCarrera==21 ? '#1e9bd1' :
				      ($idCarrera==31 ? '#f0a02b' :
				      ($idCarrera==32 ? '#f9d126' :
				      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?> ">
							<td><font color="#fff">Competencia</font></td>
							<td colspan="3"><font color="#fff">0<?php echo $row2['ordenComp'].' '.$row2['descripcion']  ?></font></td>
						</tr>

						<?php

						while ($row3 = mysqli_fetch_array($sql3))
						{
							$idObjGeneral	= $row3['idObjgeneral'];
							$ordenamiento	= $row3['ordenamiento'];

							$id1 = $ordenamiento[0];
	            $id2 = (($ordenamiento[1] != '' || $ordenamiento[1] != null) ? $ordenamiento[1] : 0);

							$sql4 = $conn->query("SELECT doge.idObjgeneral, doge.idObjespecifico, obje.definicion AS descObje,
    																doge.ordenamiento AS ordenObjetivo FROM detalle_og_oe doge
        														LEFT JOIN objespecifico obje ON (obje.idObjespecifico = doge.idObjespecifico) WHERE doge.idObjgeneral = '$idObjGeneral'
																		ORDER BY doge.ordenamiento") or die(mysqli_error($conn));
					?>

						<tr bgcolor="#E7E6E6">
							<td class="text-center"><b>Objetivo <br> general</b></td>
							<td class="text-center"><b><?php echo '0'.$id1.'.0'.$id2 ?></b></td>
							<!-- <td class="text-center"></td> -->
							<td class="text-justify" colspan="2"><font color=""><?php echo $row3['definicion']  ?></font></td>
						</tr>

						<?php

						while ($row4 = mysqli_fetch_array($sql4))
						{
							$ordenamientoE = $row4['ordenObjetivo'];
							$idE1 = $ordenamientoE[0];
							$idE2 = ($ordenamientoE[1] != '' ? $ordenamientoE[1] : 0);
							$idE3 = ($ordenamientoE[2] != '' ? $ordenamientoE[2] : 0);
							?>

							<tr bgcolor="#F9F9F9">
								<td></td>
								<td class="text-center"><b>Objetivo <br>específico</b></td>
								<!-- <td class="text-center"></td> -->
								<td class="text-center"><b><?php echo '0'.$idE1.'.0'.$idE2.'.0'.$idE3 ?></b></td>
								<td class="text-justify"><font color=""><?php echo $row4['descObje']  ?></font></td>
							</tr>
     	<?php
							}
						}
					}
       	}
     	?>
   	</tbody>
 	</table>
</div>
