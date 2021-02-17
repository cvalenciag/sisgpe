<?php

header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
header('Content-type: application/x-msexcel'); // This should work for the rest
header('Content-Disposition: attachment; filename=ReporteDePerfilDeEgreso.xls');

require_once ('connect.php');

$idFacultad 	= $_REQUEST['idFacultad'];
$idCarrera  	= $_REQUEST['idCarrera'];
$fechaPerfil 	= $_REQUEST['fechaPerfil'];

$qryFac = $conn->query("SELECT * FROM facultad WHERE idFacultad='$idFacultad'") or die(mysqli_error($conn));
$resFac = $qryFac->fetch_array();
$nomFac = $resFac['descripcion'];

$qryCar = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'") or die(mysqli_error($conn));
$resCar = $qryCar->fetch_array();
$nomCar = $resCar['descripcion'];

// $fechPerfil = n('d-m-Y', $fechaPerfil);
$fechaNow = date('d-m-Y');
?>

<table style="width:100%;"> 
  <tr>
    <td colspan="7" align="center"><font color="#808080"><?php echo $nomFac ?></font></td>
  </tr>
  <tr>
    <td colspan="7" align="center">
      <b><font color=" <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?> ">Carrera: <?php echo $nomCar ?></font></b>


    </td>
  </tr>
  <tr>
    <td colspan="7" align="center">
      <b><font color=" <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?> ">Fecha del Perfil de egreso: <?php echo $fechaPerfil ?></font></b>
    </td>
  </tr>
  <tr>
    <td colspan="7" align="center"><font color=" <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
    ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
    ($idCarrera==21 ? '#1e9bd1' :
    ($idCarrera==31 ? '#f0a02b' :
    ($idCarrera==32 ? '#f9d126' :
    ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?> ">Fecha de consulta: <?php echo $fechaNow ?></font></td>
  </tr>
</table>
<br>
<table style="width:100%; font-size:10px;" border="1">
  <thead>
    <tr>
      <th colspan="7" align="center" bgcolor="#E7E6E6">Perfil de egreso</th>
    </tr>
    <tr bgcolor="
      <?php echo $idCarrera==11 ? '#30a04a' : ($idCarrera == 12 ? '#7a183b' :
      ($idCarrera==13 ? '#e04544' : ($idCarrera==14 ? '#4c3278' :
      ($idCarrera==21 ? '#1e9bd1' :
      ($idCarrera==31 ? '#f0a02b' :
      ($idCarrera==32 ? '#f9d126' :
      ($idCarrera==41 ? '#9c4a93' : '#1fa9aa') ) ) ) ) ) ) ?>" style="color:#FFFFFF">
      <th align="center">Tipo de <br> competencia</th>
      <th align="center">Número de <br> competencia</th>
      <th align="center">Competencia</th>
      <th align="center">Número de <br> Obj. general</th>
      <th align="center">Objetivo general</th>
      <th align="center">Número de <br> Obj. específico</th>
      <th align="center">Objetivo específico</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $qryDatos = $conn->query("SELECT
    dco.idCarrera,
    tc.idTipo,
    tc.descripcion AS descTipoComp,
    c.idCompetencia,
    c.descripcion AS descCompetencia,
    doge.idObjgeneral,
    objg.definicion AS descObjG,
    dco.ordenamiento AS ordenObjetivoG,
    doge.idObjespecifico,
    obje.definicion AS descObjE,
    doge.ordenamiento AS ordenObjetivoE
FROM
    detalle_og_oe doge
        LEFT JOIN
    objespecifico obje ON (obje.idObjespecifico = doge.idObjespecifico)
        LEFT JOIN
    detalle_carrera_og dco ON (dco.idObjgeneral = doge.idObjgeneral)
        LEFT JOIN
    objgeneral objg ON (objg.idObjgeneral = dco.idObjgeneral)
        LEFT JOIN
    competencia c ON (c.idCompetencia = objg.idCompetencia)
        LEFT JOIN
    tipocompetencia tc ON (tc.idTipo = c.idTipo)
        LEFT JOIN
    perfilegresado pf ON (pf.idCarrera = dco.idCarrera)
WHERE
    pf.IdCarrera = '$idCarrera'
        AND fAprobacionPerfil = '$fechaPerfil'
ORDER BY dco.idCarrera, c.idCompetencia,  doge.ordenamiento") or die(mysqli_error($conn));


    foreach ($qryDatos as $datos)
    {
      $cadenaObGral = $datos['ordenObjetivoG'];
      $idObGral1 = $cadenaObGral[0];
      $idObGral2 = $cadenaObGral[1];
      // $idObGral3 = $cadenaObGral[2];

      $cadenaObEsp = $datos['ordenObjetivoE'];
      $idObEsp1 = $cadenaObEsp[0];
      $idObEsp2 = $cadenaObEsp[1];
      $idObEsp3 = $cadenaObEsp[2];

    ?>

    <tr>
      <td align="left"><?php echo $datos['descTipoComp'] ?></td>
      <td align="right"><?php echo $datos['idCompetencia'] ?></td>
      <td align="left"><?php echo $datos['descCompetencia'] ?></td>
      <td align="right" style="mso-number-format:'\@';"><?php echo '0'.$idObGral1.'.0'.$idObGral2 ?></td>
      <td align="justify"><?php echo $datos['descObjG'] ?></td>
      <td align="right" style="mso-number-format:'\@';"><?php echo '0'.$idObEsp1.'.0'.$idObEsp2.'.0'.$idObEsp3 ?></td>
      <td align="justify"><?php echo $datos['descObjE'] ?></td>
    </tr>

    <?php
    }

    ?>
  </tbody>
</table >
