<!-- <head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
</head> -->


<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];
$idCa = (isset($_REQUEST['idCa']) && !empty($_REQUEST['idCa']))?$_REQUEST['idCa']:'';
$idCarreraCompetencia = (isset($_REQUEST['idCarreraCompetencia']) && !empty($_REQUEST['idCarreraCompetencia']))?$_REQUEST['idCarreraCompetencia']:'';
$idCo = (isset($_REQUEST['idCo']) && !empty($_REQUEST['idCo']))?$_REQUEST['idCo']:'';
$ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';

/*if ($idTemp!='')//codigo elimina un curso del array tabla temp
{
    $id_tmp=intval($idTemp);
    $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

/*$session_id= $_SESSION['session_id'];*/
/*if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['ordenamiento'])){$ordenamiento=$_POST['ordenamiento'];}*/

/*if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

	/* Connect To Database*/
	//include 'connect.php';

/*if (!empty($id) and !empty($ordenamiento))
{
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,ordenamiento,idSession) VALUES ('$id','$ordenamiento','$session_id')");

}

if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);
$delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}*/

if (isset($_POST['elegido1']))//codigo elimina un elemento del array
{
  $elegido1 = $_POST['elegido1'];
$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido1' ORDER BY descripcion") or die(mysqli_error($conn));
while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";

}

/*if (isset($_POST['elegido1']))//codigo elimina un elemento del array
{
  $elegido1 = $_POST['elegido1'];
$qborrow = $conn->query("SELECT idObjgeneral,definicion FROM objgeneral where estado=1 and idCompetencia='$elegido1' ORDER BY definicion") or die(mysqli_error($conn));
while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idObjgeneral'] ."'>". $fborrow['definicion'] . "</option>";
  }*/
    }

if ($idCa!='' && $idCo!='' && $idCarreraCompetencia!='' && $_REQUEST['op']=='D')//codigo elimina un curso del array tabla temp
{
  $resultMalla  = $conn->query("SELECT COUNT(*) total FROM detalle_carrera_competencia WHERE idCarreraCompetencia='".$idCarreraCompetencia."' AND eliminado='0'");
  $numRegMalla  = $resultMalla->fetch_assoc();

  if($numRegMalla['total']==1){
    echo '<script type = "text/javascript">
     alert("No es posible eliminar el registro. Favor de eliminar el registro principal.");
     </script>';

  }else {
    $sql = "DELETE FROM detalle_carrera_competencia WHERE idCarreraCompetencia='$idCarreraCompetencia' and idCarrera='$idCa' and idCompetencia='$idCo'";
    $query = mysqli_query($conn,$sql);
  }
}

if ($idCa!='' && $idCo!='' && $idCarreraCompetencia!='' && $_REQUEST['op']=='E')  //
{

            $sql3=$conn->query("select * from detalle_carrera_competencia where idCarreraCompetencia = '$idCarreraCompetencia' and idCarrera='$idCa' and ordenamiento='$ordenamiento'");

            if ($sql3->num_rows==0)
            {

                    $update_tmp=mysqli_query($conn, "update detalle_carrera_competencia set ordenamiento='$ordenamiento' where idCarreraCompetencia = '$idCarreraCompetencia' and idCarrera='$idCa' and idCompetencia='$idCo'");

                       echo '
                        <script type = "text/javascript">
                        alert("El ordenamiento fue actualizado correctamente.");
                        </script>';
            }


                            else {
                                    echo '
                                        <script type = "text/javascript">
                                            alert("El numero de orden ya existe. Por favor cambie de número");
                                        </script>';
                                 }

}


if ($idCa!='' && $idCo!='' && $idCarreraCompetencia!='' && $_REQUEST['op']=='I')  //
{

        $sql2=$conn->query("select * from detalle_carrera_competencia where idCompetencia='$idCo' and idCarrera='$idCa' and idCarreraCompetencia='$idCarreraCompetencia' and ordenamiento='$ordenamiento' and eliminado=0");
            if ($sql2->num_rows==0)
            {

            // $sql3=$conn->query("select * from detalle_carrera_competencia where idCarreraCompetencia = '$idCarreraCompetencia' and idCarrera='$idCa' ");
            // if ($sql3->num_rows==0)
            // { // inicio if num_rows

                    $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_carrera_competencia (idCarreraCompetencia,idCarrera,idCompetencia,ordenamiento,eliminado) VALUES ('$idCarreraCompetencia','$idCa','$idCo','$ordenamiento','0')");

                       echo '
                        <script type = "text/javascript">
                        alert("La competencia fue agregada satisfactoriamente.");
                        </script>';
            }


                            else {
                                    echo '
                                        <script type = "text/javascript">
                                          alert("El numero de orden ya existe. Por favor cambie de número");
                                        </script>';

                                          echo '<script type = "text/javascript">
                                        $("#ordenamiento_' . $idCo . '").val("");
                                        </script>
                                        ';
                                 }

           }


        // else {
        //         echo '
        //             <script type = "text/javascript">
        //                 alert("La competencia ya se encuentra registrada en la base de datos");
        //             </script>';
        //      }

// }

/*



    if ($idCarrera!='')  // codigo que inserta cursos seleccionados en la tabla temp
{

 $ordenamiento = $_POST['ordenamiento'];

if ($idCarrera!='' && $idCompetencia!='' && $idCarreraCompetencia!='')  //
{
    echo "ordenamiento: " . $ordenamiento;
    $sql1=$conn->query("select * from tmp where idCompetencia='$idCompetencia' and idCarrera='$idCarrera' and idSession='$session_id'");
    if ($sql1->num_rows==0)
    { // inicio if num_rows

        $sql2=$conn->query("select * from detalle_carrera_competencia where idCompetencia='$idCompetencia' and idCarrera='".$idCarrera."' and idCarreraCompetencia='$idCarreraCompetencia' and eliminado=0");
            if ($sql2->num_rows==0)
            { // inicio if num_rows

 $sql3=$conn->query("select * from tmp where idCarrera='$idCarrera' and ordenamiento='$ordenamiento' and idSession='$session_id'");
            echo "cantidad: " . $sql3->num_rows;
              if ($sql3->num_rows==0)
            { // inicio if num_rows

            $insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,idCarrera,ordenamiento,idSession) VALUES ('$idCompetencia','$idCarrera','$ordenamiento','$session_id')");
            }
            else {
               echo '
                <script type = "text/javascript">
                alert("La competencia fue agregada satisfactoriamente!!!");
                </script>';
                }
          else {
                                    echo '
                                        <script type = "text/javascript">
                                            alert("El numero de orden ya existe. Por favor cambie de numero!!!");
                                        </script>';
                                 }

       }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("La competencia ya se encuentra registrado en nuestra Base de datos!!!");
                    </script>';
             }

     }
        else {
                echo '
                    <script type = "text/javascript">
                        alert("La competencia ya fue agregado!!!");
                    </script>';
            } // cierra else


}*/


/*if (isset($_POST['id']) and isset($_POST['ordenamiento']) and isset($_POST['idCarrera']))  // codigo que inserta cursos seleccionados en la tabla temp
{

 $idCarrera = $_POST['idCarrera'];
 $idCarreraCompetencia = $_POST['idCarreraCompetencia'];
 $id = $_POST['id'];
 $ordenamiento = $_POST['ordenamiento'];

$sql2=$conn->query("select * from detalle_carrera_competencia where idCompetencia='$id' and idCarrera='".$idCarrera."' and idCarreraCompetencia='$idCarreraCompetencia' and eliminado=0");
				if ($sql2->num_rows==0)
				{ // inicio if num_rows
$insert_tmp=mysqli_query($conn, "INSERT INTO tmp (idCompetencia,idCarrera,ordenamiento,idSession) VALUES ('$id','$idCarrera','$ordenamiento','$session_id')");

				} else {
						echo '
				<script type = "text/javascript">
					alert("Registro ya existe!!!");
				</script>';
					} */

// luego muestra la tabla temp con los cursos seleccionados de acuerdo a la carrera elegida

$sql=$conn->query("select * from competencia c, detalle_carrera_competencia d where c.idCompetencia=d.idCompetencia and d.idCarreraCompetencia='".$idCarreraCompetencia."'");
        if ($sql->num_rows>0) {
        ?>
<table id = "tablEditar" class = "table table-bordered table-hover" style="width:100%">
<thead class = "alert-info">
<tr class = "alert-info">
	<th class='text-center'>Competencia</th>
	<th class='text-center'>Ordenamiento</th>
  <th colspan="2">Opciones</th>
</tr>
</thead>
<tbody>
<?php
	/*$sql=mysqli_query($conn, "select * from competencia, tmp where competencia.idCompetencia=tmp.idCompetencia and tmp.idSession='".$session_id."'");*/
	while ($row=mysqli_fetch_array($sql))
	{
$idCarreraCompetencia=$row["idCarreraCompetencia"];
        $idCa=$row["idCarrera"];
        $idCo=$row["idCompetencia"];
  $descripcion=$row['descripcion'];
  $ordenamiento=$row['ordenamiento'];
    ?>
	 <tr>
      <td class='text-center'><?php echo $descripcion;?></td>
      <td class='text-center'>
                        <input type="text" class="form-control" style="text-align:right" id="orden_<?php echo $idCo;?>" value ="<?php echo $ordenamiento?>" required = "required">
                        <input type="hidden" id="idCa" name="idTmp" value="<?php echo $idCa;?>"/>
                        <input type="hidden" id="idCarreraCompetencia" name="idTmp" value="<?php echo $idCarreraCompetencia;?>"/>
                        </td>

      <td class='text-center'>
                        <a href="#" title="Grabar cambio" class="editarDet" value="<?php echo $idCo;?>"><i class="btn btn-sm btn-success glyphicon glyphicon-edit"></i></a>
                        </td>
                        <td class='text-center'>
                        <a href="#" title="Eliminar el registro" onclick="eliminarDet('<?php echo $idCarreraCompetencia ?>','<?php echo $idCa; ?>','<?php echo $idCo; ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a>

                        </td>
    </tr>
    <?php
  }

?>
</tbody>
</table>

 <?php
    }
?>




<script>

$("#tablEditar").on("click", ".editarDet", function(){
                        var id = $(this).attr('value');
                        var idCarreraCompetencia = $("#idCarreraCompetencia").val();
                        var idCa = $("#idCa").val();
            var orden = $('#orden_'+id).val();
      $.ajax({
                        type: "GET",
                        url: "./ajax/agregar_carreracompetencia2.php",
                        data: "idCa="+idCa+"&idCo="+id+"&idCarreraCompetencia="+idCarreraCompetencia+"&ordenamiento="+orden+"&op=E",
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                        });
      });

</script>
