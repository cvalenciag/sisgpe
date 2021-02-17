<?php

  require_once '../valid.php';
  $session_id= $_SESSION['session_id'];


	$idCurso       = $_POST['idCurso'];
	$idTipo        = $_POST['idTipo'];
	$idCompetencia = $_POST['idCompetencia'];
	$idObjgeneral  = $_POST['idObjgeneral'];
	$idCriterio    = $_POST['idCriterio'];
	$fAprobacion   = $_POST['fAprobacion'];
	$estado        = $_POST['estado'];


  $sql2=$conn->query("SELECT * FROM rubrica WHERE idCurso='".$idCurso."' AND idTipoCompetencia='$idTipo' AND idCompetencia='$idCompetencia' AND idObjgeneral='$idObjgeneral' AND idCriterio='$idCriterio' AND fAprobacion='$fAprobacion' AND eliminado=0");

  if ($sql2->num_rows > 0){ 
    echo "1";
	}
