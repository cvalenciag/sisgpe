<?php
require_once '../valid.php';

// ===============================================================================================================
$idCriterio	= (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';
$idSubCrite	= (isset($_REQUEST['idSubcriterio']) && !empty($_REQUEST['idSubcriterio']))?$_REQUEST['idSubcriterio']:'';

$qryNivel = $conn->query("SELECT * FROM nivel WHERE estado=1 ORDER BY idNivel") or die(mysqli_error($conn));
// $resNivel = $qryNivel->fetch_assoc();
$datNivel = array();

while($row = $qryNivel->fetch_assoc()){

      $datNivel[] = $row;
 
}


$qrySubCris = $conn->query("SELECT sc.idSubcriterio, sc.idCriterio, sc.idNivel, n.descripcion as descNivel, sc.descripcion as descSubCri, sc.rango, sc.total, sc.maximo, sc.minimo, sc.peso FROM subcriterio sc LEFT JOIN nivel n ON (n.idNivel=sc.idNivel) WHERE idSubcriterio='$idSubCrite' AND idCriterio='$idCriterio'")
or die(mysqli_error($conn));
$resSubCris = $qrySubCris->fetch_assoc();
$descNivel  = $resSubCris['descNivel'];
$descSubCri = $resSubCris['descSubCri'];
$idNivel    = $resSubCris['idNivel'];
$idSubCri   = $resSubCris['idSubcriterio'];
$rango      = $resSubCris['rango'];
$total      = $resSubCris['total'];
$maximo     = $resSubCris['maximo'];
$minimo     = $resSubCris['minimo'];
$peso       = $resSubCris['peso'];

$data = array('idSubcriterio'=> $idSubCri, 'descNivel' => $descNivel, 'descSubCri' => $descSubCri, 'idNivel' => $idNivel, 'rango' => $rango, 'total' => $total, 'maximo' => $maximo, 'minimo' => $minimo, 'peso' => $peso, 'niveles' => $datNivel);

echo json_encode($data, JSON_FORCE_OBJECT);
