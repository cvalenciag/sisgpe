<?php
require_once ('connect.php');

$idFacultad 	= $_REQUEST['idFacultad'];
$idCarrera  	= $_REQUEST['idCarrera'];
$fechaMalla 	= $_REQUEST['fechaMalla'];
$obligaCurso	= $_REQUEST['obligatorio'];


$qryFac = $conn->query("SELECT * FROM facultad WHERE idFacultad='$idFacultad'") or die(mysqli_error($conn));
$resFac = $qryFac->fetch_array();
$nomFac = $resFac['descripcion'];

$qryCar = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'") or die(mysqli_error($conn));
$resCar = $qryCar->fetch_array();
$nomCar = $resCar['descripcion'];

$fechaNow = date('d-m-Y');


if($obligaCurso==1){
  $nameObliga = 'Si';
}else if($obligaCurso==0) {
  $nameObliga = 'No';
}else {
  $nameObliga = 'Todos';
}


// CONSULTA DE DATOS ======================================================================================
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

$sql = $conn->query("SELECT dm.ciclo, c.codUpCurso, c.nombreCurso, d.nombreCorto, c.cantHorasTeorica,
                    c.cantHorasPractica, c.credito FROM carrera ca LEFT JOIN facultad f ON (ca.idFacultad = f.idFacultad)
                    LEFT JOIN malla m ON (ca.idCarrera = m.idCarrera)
                    LEFT JOIN detalle_malla dm ON (m.idmalla = dm.idMalla)
                    LEFT JOIN curso c ON (dm.idCurso = c.idCurso)
                    LEFT JOIN departamento d ON (c.idDepartamento = d.idDepartamento)
                    WHERE f.idFacultad='$idFacultad' AND m.idCarrera='$idCarrera' AND fAprobacion = '$fechaMalla' $sWhere ORDER BY dm.ciclo , d.nombreCorto") or die(mysqli_error($conn));


$countSQL = $conn->query("SELECT COUNT(*) totalCursos FROM carrera ca
                    LEFT JOIN facultad f ON (ca.idFacultad = f.idFacultad)
                    LEFT JOIN malla m ON (ca.idCarrera = m.idCarrera)
                    LEFT JOIN detalle_malla dm ON (m.idmalla = dm.idMalla)
                    LEFT JOIN curso c ON (dm.idCurso = c.idCurso)
                    LEFT JOIN departamento d ON (c.idDepartamento = d.idDepartamento)
                    WHERE f.idFacultad='$idFacultad' AND m.idCarrera='$idCarrera' AND fAprobacion = '$fechaMalla' $sWhere ORDER BY dm.ciclo , d.nombreCorto") or die(mysqli_error($conn));

$resCountSQL = $countSQL->fetch_array();
$totalCursos = $resCountSQL['totalCursos'];
//FIN CONSULTA DE DATOS =========================================================================================
?>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<table style="width:100%;">
  <tr>
    <th colspan="7" align="center">
      <font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">Reporte de Malla Curricular</font></th>
  </tr>
  <tr>
    <th colspan="7" align="center">
      <font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">(Fecha de consulta: <?php echo $fechaNow ?>)</th>
  </tr>
</table>
<br>
<table style="width:100%;">
  <tr>
    <th align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
      Facultad:</font></th>

    <td align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>"><?php echo $nomFac ?></font></td>

    <th></th>

    <th align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
      Fecha de malla curricular:</font></th>

    <td align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>"><?php echo $fechaMalla ?></font></td>

    <th></th>

    <th align="right"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
      Cantidad de cursos:</font></th>

    <td align="right"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>"><?php echo $totalCursos ?></font></td>
  </tr>
  <tr>
    <th align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
      Carrera:</font></th>

    <td align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>"><?php echo $nomCar ?></font></td>

    <th></th>

    <th align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
      Cursos obligatorios:</font></th>

    <td align="left"><font color="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>"><?php echo $nameObliga ?></font></td>

  </tr>
</table>
<br>
<table style="width:100%;">
	<thead>
    <tr bgcolor="<?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>">
     	<th align="center"><font style="color:white;">Ciclo</font></th>
     	<th align="center"><font style="color:white;">Código</font></th>
     	<th align="center"><font style="color:white;">Cursos</font></th>
     	<th align="center"><font style="color:white;">Departamento <br> Académico</font></th>
     	<th align="center"><font style="color:white;">Horas <br> teóricas</font></th>
     	<th align="center"><font style="color:white;">Horas <br> prácticas</font></th>
     	<th align="center"><font style="color:white;">Créditos</font></th>
   	</tr>
 	</thead>
 	<tbody>
<?php
     	while ($row = mysqli_fetch_array($sql))
     	{
?>
     	<tr>
       	<td align="center"><?php echo $row['ciclo'] ?></td>
       	<td align="center"><?php echo $row['codUpCurso'] ?></td>
       	<td align="justify"><?php echo $row['nombreCurso'] ?></td>
       	<td align="center"><?php echo $row['nombreCorto'] ?></td>
       	<td align="center"><?php echo $row['cantHorasTeorica'] ?></td>
       	<td align="center"><?php echo $row['cantHorasPractica'] ?></td>
       	<td align="center"><?php echo $row['credito'] ?></td>
    	</tr>
<?php
     	}
?>
 	</tbody>
</table>
