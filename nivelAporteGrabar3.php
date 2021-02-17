<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera      		= $_POST['idCarrera'];
$fAprobacionMalla		= $_POST['fAprobacionMalla'];
$fAprobacionPerfil	= $_POST['fAprobacionPerfil'];


$qryTemp = $conn->query("SELECT * FROM curso c, tmp t WHERE c.idCurso=t.idCurso AND idSession='".$session_id."'");

if($qryTemp->num_rows>0)
{
  $idPerfil = $conn->insert_id;

  $qryPerfil = $conn->query("SELECT * FROM perfilegresado WHERE idCarrera='".$idCarrera."' AND fAprobacionMalla='".$fAprobacionMalla."' AND fAprobacionPerfil='".$fAprobacionPerfil."' AND eliminado=0");

  if($qryPerfil->num_rows==0)
  {
    $conn->query("INSERT INTO perfilegresado (idPerfilEgresado, idCarrera, fAprobacionMalla, fAprobacionPerfil, eliminado)
                  VALUES('$idPerfil', '$idCarrera', '$fAprobacionMalla', '$fAprobacionPerfil', '0')") or die (mysqli_error($conn));
  }

	if($conn->affected_rows == 1)
  {
    $idPerfil = $conn->insert_id;

    while ($row = mysqli_fetch_array($qryTemp))
  	{ // abre while
      $idTmp        = $row['idTmp'];
      $idCurso      = $row['idCurso'];
  	  $ciclo        = $row['ciclo'];
      $aol          = $row['aol'];


      $conn->query("INSERT INTO detalle_perfilegresado_curso (idPerfilEgresado, idCarrera, idCurso, fAprobacionMalla, fAprobacionPerfil, eliminado) VALUES('$idPerfil', '$idCarrera', '$idCurso', '$fAprobacionMalla','$fAprobacionPerfil', '0')") or die (mysqli_error($conn));

      if($conn->affected_rows==1){
        $deleteTempo = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");
      }

    } // cierra while

    echo '<script type = "text/javascript">
          alert("Registro agregado correctamente.");
          window.location = "nivelAporte.php";
          </script>';

  } //AFECTED ROWS

}
