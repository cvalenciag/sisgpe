
<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$idOgOe = (isset($_REQUEST['idOgOe']) && !empty($_REQUEST['idOgOe']))?$_REQUEST['idOgOe']:'';
$idObjespecifico = (isset($_REQUEST['idObjespecifico']) && !empty($_REQUEST['idObjespecifico']))?$_REQUEST['idObjespecifico']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
$idTemp = (isset($_REQUEST['id']) && !empty($_REQUEST['id']))?$_REQUEST['id']:'';
/*if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['ordenamiento'])){$ordenamiento=$_POST['ordenamiento'];}*/
if ($idTemp!='')//codigo elimina un curso del array tabla temp
{
    $id_tmp=intval($idTemp);  
    $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}
/*if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

if (isset($_POST['elegido']))//codigo elimina un elemento del array
{
  $elegido = $_POST['elegido'];
  $qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 and idTipo='$elegido' ORDER BY descripcion") or die(mysqli_error($conn));

  echo "<option value = '' selected = 'selected'>Seleccione una competencia</option>";

  while($fborrow = $qborrow->fetch_array())
  {

    echo "<option value = '". $fborrow['idCompetencia'] ."'>". $fborrow['descripcion'] . "</option>";
  }

  echo "<option value = '0' >No aplica</option>";
}

if (isset($_POST['elegido1']))//codigo elimina un elemento del array
{
  $elegido1 = $_POST['elegido1'];
  $qborrow1 = $conn->query("SELECT idObjgeneral,definicion FROM objgeneral where estado=1 and idCompetencia='$elegido1' ORDER BY definicion") or die(mysqli_error($conn));

  echo "<option value = '' selected = 'selected'>Seleccione un objetivo general</option>";

  while($fborrow1 = $qborrow1->fetch_array())
  {

    echo "<option value = '". $fborrow1['idObjgeneral'] ."'>". substr($fborrow1['definicion'], 0, 80). '...'  . "</option>";
  }

  echo "<option value = '0' >No aplica</option>";

}

if ($idObjgeneral!='')  // codigo que inserta cursos seleccionados en la tabla temp
{

 // $ordenamiento = $_REQUEST['ordenamiento'];

  $ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';

  if ($idObjgeneral!='' && $idObjespecifico!='' && $idOgOe!='')  //
  {
    /*echo "ordenamiento: " . $ordenamiento;*/
    $sql1=$conn->query("select * from tmp where idObjespecifico='$idObjespecifico' and idObjgeneral='$idObjgeneral' and fAprobacion='$fAprobacion' and idSession='$session_id'");

    if ($sql1->num_rows==0)
    { // inicio if num_rows

      $sql2=$conn->query("select * from detalle_og_oe where idObjespecifico='$idObjespecifico' and idObjgeneral='$idObjgeneral' and idOgOe='$idOgOe' and eliminado=0");

      if ($sql2->num_rows==0)
      { // inicio if num_rows

        $sql3=$conn->query("select * from tmp where idObjgeneral='$idObjgeneral' and ordenamiento='$ordenamiento' and idSession='$session_id'");
          /*  echo "cantidad: " . $sql3->num_rows;*/
          if ($sql3->num_rows==0)
          { // inicio if num_rows

            $insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idObjespecifico,idObjgeneral,fAprobacion,ordenamiento,idSession) VALUES ('$idObjespecifico','$idObjgeneral','$fAprobacion','$ordenamiento','$session_id')");

            echo '<script type = "text/javascript">
                    alert("El objetivo específico fue agregado satisfactoriamente.");
                  </script>';

          }else {

            echo '<script type = "text/javascript">
                  alert("El número de orden ya existe. Favor de cambiar el número.");
                  </script>';

            echo '<script type = "text/javascript">
                  $("#ordenamiento_' . $idObjespecifico . '").val("");
                  </script>';
          }

      }else {
                echo '
                    <script type = "text/javascript">
                        alert("El objetivo específico ya se encuentra registrado en la base de datos.");
                    </script>';
      }

    }else {
                echo '
                    <script type = "text/javascript">
                        alert("El objetivo específico ya fue agregado.");
                    </script>';
            } // cierra else


  }

  // luego muestra la tabla temp con los cursos seleccionados de acuerdo a la carrera elegida

  	$sql=$conn->query("select * from objespecifico, tmp where objespecifico.idObjespecifico=tmp.idObjespecifico and tmp.idObjgeneral='".$idObjgeneral."' and tmp.fAprobacion = '$fAprobacion' and tmp.idSession='".$session_id."'");
          if ($sql->num_rows>0) {
  ?>
  <table class="table table-bordered" style="width:100%;">
  <tr class="alert-info">
  	<th class='text-center'>Objetivo especifico</th>
  	<th class='text-center'>Ordenamiento</th>
  	<th></th>
  </tr>
  <?php
  	/*$sql=mysqli_query($conn, "select * from objespecifico, tmp where objespecifico.idObjespecifico=tmp.idObjespecifico and tmp.idSession='".$session_id."'");*/
  	while ($row=mysqli_fetch_array($sql))
  	{
  	$id_tmp=$row["idTmp"];
  	$definicion=$row['definicion'];
  	$ordenamiento=$row['ordenamiento'];
  		?>
  		<tr>
  			<td class='text-center'><?php echo $definicion;?></td>
  			<td class='text-center'><?php echo $ordenamiento;?></td>

  			<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>','<?php echo $idObjgeneral  ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a></td>
  		</tr>
  		<?php
  	}


  ?>

  </table>

   <?php
      }

  }
  ?>
