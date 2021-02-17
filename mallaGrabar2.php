<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera      = $_POST['idCarrera'];
$fAprobacion    = $_POST['fAprobacion'];
$fActualizacion = $_POST['fActualizacion'];
$estado         = $_POST['estado'];


$qryTemp = $conn->query("SELECT * FROM curso c, tmp t WHERE c.idCurso=t.idCurso AND idCarrera='".$idCarrera."' AND idSession='".$session_id."' AND fAprobacion='".$fAprobacion."'");

if($qryTemp->num_rows>0)
{
  $idMalla = $conn->insert_id;

  $qryMalla = $conn->query("SELECT * FROM malla WHERE idCarrera='".$idCarrera."' AND fAprobacion = '" . $fAprobacion. "' AND fActualizacion='".$fActualizacion."' AND eliminado=0");

  if($qryMalla->num_rows==0)
  {
    $conn->query("INSERT INTO malla (idMalla, idCarrera, fAprobacion, fActualizacion, estado, eliminado)
                  VALUES('$idMalla', '$idCarrera', '$fAprobacion', '$fActualizacion', '$estado', '0')") or die (mysqli_error($conn));
  }
  // else {
  //   echo "1";
    // echo '<script type = "text/javascript">
    //       alert("La carrera seleccionada ya se encuentra registrada en el sistema. Modifique la fecha de actualizacion");
    //       window.location = "malla.php";
    //       </script>';
  // }

  if($conn->affected_rows == 1)
  {
    $idMalla = $conn->insert_id;

    while ($row = mysqli_fetch_array($qryTemp))
  	{ // abre while
      $idTmp        = $row['idTmp'];
      $idCurso      = $row['idCurso'];
  	  $ciclo        = $row['ciclo'];
      $obligatorio  = $row['obligatorio'];
      $aol          = $row['aol'];


      $conn->query("INSERT INTO detalle_malla (idMalla, idCarrera, idCurso, ciclo, obligatoriedad, aol, eliminado)
                    VALUES('$idMalla', '$idCarrera', '$idCurso', '$ciclo','$obligatorio','$aol', '0')") or die (mysqli_error($conn));

      if($conn->affected_rows==1){
        $deleteTempo = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");
      }

    } // cierra while

    echo '<script type = "text/javascript">
          alert("Registro agregado correctamente.");
          window.location = "malla.php";
          </script>';

  } //AFECTED ROWS

}else {

  // echo "2";
   echo "<input type='hidden' id='idResult' value='2'/>";

  // echo '
  //    <script type = "text/javascript">
  //      alert("Debe registrar el detalle de cursos antes de grabar la malla.");
  //      window.location = "malla.php";
  //    </script>';
}

?>
