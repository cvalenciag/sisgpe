<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$idCarrera      = $_POST['idCarrera'];
$fAprobacion    = $_POST['fAprobacion'];
// $fActualizacion = $_POST['fActualizacion'];
$estado         = $_POST['estado'];


$sql  = $conn->query("SELECT * FROM objgeneral o, tmp t where o.idObjgeneral=t.idObjgeneral and t.idSession='".$session_id."'");

if($sql->num_rows>0)
{
  $idCarreraOg = $conn->insert_id;

  $sql2 = $conn->query("SELECT * from carrera_og where fAprobacion='".$fAprobacion."' and idCarrera='".$idCarrera."' and eliminado=0 and estado='".$estado."'");

  if($sql2->num_rows==0)
  {
    $conn->query("INSERT INTO carrera_og (idCarreraOg,idCarrera,fAprobacion,estado,eliminado)
                  VALUES('$idCarreraOg','$idCarrera','$fAprobacion','$estado','0')") or die (mysqli_error($conn));
  }


  if($conn->affected_rows == 1)
  {
    $idCarreraOg = $conn->insert_id;

    while ($row = mysqli_fetch_array($sql))
  	{ // abre while
      $idTmp         = $row['idTmp'];
  	  $idObjgeneral  = $row['idObjgeneral'];
  	  $ordenamiento  = $row['ordenamiento'];

      $conn->query("INSERT INTO detalle_carrera_og (idCarreraOg,idCarrera,idObjgeneral,ordenamiento,eliminado)
                    VALUES('$idCarreraOg','$idCarrera','$idObjgeneral','$ordenamiento','0')") or die (mysqli_error($conn));

        if($conn->affected_rows==1){
          $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$idTmp."' and idSession='".$session_id."'");
        }


    } // cierra while

    echo '<script type = "text/javascript">
          alert("Registro agregado correctamente.");
          window.location = "carreraog.php";
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
