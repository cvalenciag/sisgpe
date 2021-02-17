<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$tipoCompetencia = (isset($_REQUEST['tipoCompetencia']) && !empty($_REQUEST['tipoCompetencia']))?$_REQUEST['tipoCompetencia']:'';

$idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$tipObjetivo   = (isset($_REQUEST['idTipoObj']) && !empty($_REQUEST['idTipoObj']))?$_REQUEST['idTipoObj']:'';

$idObjGeneral     = (isset($_REQUEST['idObGral']) && !empty($_REQUEST['idObGral']))?$_REQUEST['idObGral']:'';
$idObjEspecifico  = (isset($_REQUEST['idObjEspe']) && !empty($_REQUEST['idObjEspe']))?$_REQUEST['idObjEspe']:'';

$idTipoAporte = (isset($_REQUEST['idTipoAporte']) && !empty($_REQUEST['idTipoAporte']))?$_REQUEST['idTipoAporte']:'';
$idCarrera    = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$idCurso      = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
// $idCiclo      = (isset($_REQUEST['idCiclo']) && !empty($_REQUEST['idCiclo']))?$_REQUEST['idCiclo']:'';


if($_REQUEST['op'] == 'U')
{
    $conn->query("UPDATE detalle_curso_nivelaporte SET tipoaporte='$idTipoAporte' WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' AND idCompetencia='$idCompetencia' AND idObjgeneral='$idObjGeneral' AND idObjespecifico='$idObjEspecifico' AND idTipo='$tipoCompetencia' AND tipoobj=$tipObjetivo AND eliminado=0 ") or die (mysqli_error($conn));

}else {

  $conn->query("UPDATE detalle_curso_nivelaporte SET tipoaporte='$idTipoAporte' WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' AND idCompetencia='$idCompetencia' AND idObjgeneral='$idObjGeneral' AND idObjespecifico='$idObjEspecifico' AND idTipo='$tipoCompetencia' AND tipoobj=$tipObjetivo AND eliminado=0 ") or die (mysqli_error($conn));

}
