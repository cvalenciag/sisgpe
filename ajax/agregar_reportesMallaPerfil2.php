<?php

require_once '../valid.php';

$idFacultad 	= (isset($_REQUEST['idFacultad']) && !empty($_REQUEST['idFacultad']))?$_REQUEST['idFacultad']:'';
$idCarrera  	= (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla 	= (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$obligaCurso	= (isset($_REQUEST['obligaCurso']) && !empty($_REQUEST['obligaCurso']))?$_REQUEST['obligaCurso']:'';

$sWhere='';
if($obligaCurso == 1){
	$sWhere = "AND dm.obligatoriedad=1";
}

if($obligaCurso == 0){
	$sWhere = "AND dm.obligatoriedad=0";
}

if($obligaCurso == '-1'){
	$sWhere = "";
}

$sql = $conn->query("SELECT dm.ciclo, c.codUpCurso, c.nombreCurso, d.nombreCorto, c.cantHorasTeorica, c.cantHorasPractica,
										 c.credito FROM carrera ca LEFT JOIN facultad f ON (ca.idFacultad = f.idFacultad) LEFT JOIN malla m ON (ca.idCarrera = m.idCarrera) LEFT JOIN detalle_malla dm ON (m.idmalla = dm.idMalla) LEFT JOIN curso c ON (dm.idCurso = c.idCurso) LEFT JOIN departamento d ON (c.idDepartamento = d.idDepartamento)
										 WHERE f.idFacultad='$idFacultad' AND m.idCarrera='$idCarrera' AND fAprobacion = '$fechaMalla'
        		 				 $sWhere ORDER BY dm.ciclo , d.nombreCorto") or die(mysqli_error($conn));

if ($sql->num_rows>0)
{
?>

<div class="" style="margin-top:15px;">
	<table id="tablaResultMP" class="table table-bordered" style="width:100%;">
  	<thead>
			<tr bgcolor="#E7E6E6">
		 		<th class="text-center" colspan="7"><font color="#595959">Malla curricular</font></th>
		 	</tr>
			<tr bgcolor="
	      <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
	      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
	      ($idCarrera==21 ? '#1e9bd1' :
	      ($idCarrera==31 ? '#f0a02b' :
	      ($idCarrera==32 ? '#f9d126' :
	      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
       	<th class="text-center"><font color="#fff">Ciclo</font></th> 
       	<th class="text-center"><font color="#fff">Código</font></th>
       	<th class="text-center"><font color="#fff">Cursos</font></th>
       	<th class="text-center"><font color="#fff">Departamento <br> Académico</font></th>
       	<th class="text-center"><font color="#fff">Horas <br> teóricas</font></th>
       	<th class="text-center"><font color="#fff">Horas <br> prácticas</font></th>
       	<th class="text-center"><font color="#fff">Créditos</font></th>
     	</tr>
   	</thead>
   	<tbody>
     	<?php
       	while ($row = mysqli_fetch_array($sql))
       	{
     	?>
       	<tr>
         	<td class="text-center"><?php echo $row['ciclo'] ?></td>
         	<td class="text-center"><?php echo $row['codUpCurso'] ?></td>
         	<td class="text-justify"><?php echo $row['nombreCurso'] ?></td>
         	<td class="text-center"><?php echo $row['nombreCorto'] ?></td>
         	<td class="text-center"><?php echo $row['cantHorasTeorica'] ?></td>
         	<td class="text-center"><?php echo $row['cantHorasPractica'] ?></td>
         	<td class="text-center"><?php echo $row['credito'] ?></td>
      	</tr>
     	<?php
       	}
     	?>
   	</tbody>
 	</table>
</div>
<?php
}else{
?>

<br>
<table style="width:100%;">
  <tr>
    <td class="text-center">
      <b>No existen datos para mostrar...</b>
      <!-- <input type="hidden" name="" id="idResultadoNivel" value="1"> -->
    </td>
  </tr>
</table>

<?php
}
?>
