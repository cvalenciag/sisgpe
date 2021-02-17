<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];

$idCa = (isset($_REQUEST['idCa']) && !empty($_REQUEST['idCa']))?$_REQUEST['idCa']:'';
$idCarreraOg = (isset($_REQUEST['idCarreraOg']) && !empty($_REQUEST['idCarreraOg']))?$_REQUEST['idCarreraOg']:'';
$idOg = (isset($_REQUEST['idOg']) && !empty($_REQUEST['idOg']))?$_REQUEST['idOg']:'';
$ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';

if (isset($_POST['elegido3']))//selecciona combo hijo
{
  $elegido3 = $_POST['elegido3'];
$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido3' ORDER BY descripcion") or die(mysqli_error($conn));
while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";

}
}

if (isset($_POST['elegido4']))//selecciona combo hijo
{
  $elegido4 = $_POST['elegido4'];

  if ($elegido4!='0') {
    $qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 and idTipo='$elegido4' ORDER BY descripcion") or die(mysqli_error($conn));
  }else {
    $qborrow1 = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
  }

?>
<!-- <option value = "" selected = "selected">Seleccioneadfadsf una opción</option> -->

<?php
if ($elegido4 == '0') {
  echo "<option value=''>Todas las competencias</option>";

  while($fborrow1 = $qborrow1->fetch_array()){

    echo "<option value = '". $fborrow1['idCompetencia'] ."'>". $fborrow1['descripcion'] . "</option>";

  }
}else {
  while($fborrow = $qborrow->fetch_array()){

    echo "<option value = '". $fborrow['idCompetencia'] ."'>". $fborrow['descripcion'] . "</option>";

  }
}

    }


if ($idCa!='' && $idOg!='' && $idCarreraOg!='' && $_REQUEST['op']=='D')//codigo elimina un curso del array tabla temp
{
  $resultMalla  = $conn->query("SELECT COUNT(*) total FROM detalle_carrera_og WHERE idCarreraOg='".$idCarreraOg."' AND eliminado='0'");
  $numRegMalla  = $resultMalla->fetch_assoc();

  if($numRegMalla['total']==1){
    echo '<script type = "text/javascript">
     alert("No es posible eliminar el registro. Favor de eliminar el registro principal.");
     </script>';

  }else {
    $sql = "DELETE FROM detalle_carrera_og WHERE idCarreraOg='$idCarreraOg' and idCarrera='$idCa' and idObjgeneral='$idOg'";
    $query = mysqli_query($conn,$sql);
  }
}


if ($idCa!='' && $idOg!='' && $idCarreraOg!='' && $_REQUEST['op']=='E')  //
{

            $sql3=$conn->query("select * from detalle_carrera_og where idCarreraOg = '$idCarreraOg' and idCarrera='$idCa' and ordenamiento='$ordenamiento'");

            if ($sql3->num_rows==0)
            {

                    $update_tmp=mysqli_query($conn, "update detalle_carrera_og set ordenamiento='$ordenamiento' where idCarreraOg = '$idCarreraOg' and idCarrera='$idCa' and idObjgeneral='$idOg'");

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

if ($idCa!='' && $idOg!='' && $idCarreraOg!='' && $_REQUEST['op']=='I')  //
{

        // $sql2=$conn->query("select * from detalle_carrera_og where idObjgeneral='$idOg' and idCarrera='$idCa' and idCarreraOg='$idCarreraOg' and eliminado=0");
        // if ($sql2->num_rows==0)
        // {

            $sql3=$conn->query("select * from detalle_carrera_og where idCarreraOg = '$idCarreraOg' and idCarrera='$idCa' and idObjgeneral='$idOg' and ordenamiento='$ordenamiento' and eliminado=0");

            if ($sql3->num_rows==0)
            { // inicio if num_rows

                    $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_carrera_og (idCarreraOg,idCarrera,idObjgeneral,ordenamiento,eliminado) VALUES ('$idCarreraOg','$idCa','$idOg','$ordenamiento','0')");

                       echo '
                        <script type = "text/javascript">
                        alert("El objetivo general fue agregado satisfactoriamente.");
                        </script>';
            }else {
                                    echo '
                                        <script type = "text/javascript">
                                          alert("El número de orden ya existe. Favor de cambiar el número.");
                                        </script>';

                                          echo '<script type = "text/javascript">
                                        $("#ordenamiento_' . $idOg . '").val("");
                                        </script>
                                        ';
                                 }

           }


        // else {
        //         echo '
        //             <script type = "text/javascript">
        //                 alert("El objetivo general ya se encuentra registrado en la base de datos");
        //             </script>';
        //      }

// }


$sql=$conn->query("select * from objgeneral o, detalle_carrera_og d where o.idObjgeneral=d.idObjgeneral and d.idCarreraOg='".$idCarreraOg."'");
        if ($sql->num_rows>0) {
        ?>

<table id = "tablEditar" class = "table table-bordered table-hover" style="width:100%;">
<thead class = "alert-info">
<tr>
  <th class='text-center'>Objetivo general</th>
  <th class='text-center'>Ordenamiento</th>
  <th class='text-center' colspan="2">Opciones</th>
</tr>
</thead>
<tbody>

  <?php
  while ($row=mysqli_fetch_array($sql))
  {
    $idCarreraOg=$row["idCarreraOg"];
    $idCa=$row["idCarrera"];
    $idOg=$row["idObjgeneral"];
    $definicion=$row['definicion'];
    $ordenamiento=$row['ordenamiento'];
  ?>
    <tr>
      <td class='text-center'><?php echo $definicion;?></td>
      <td class='text-center'>
                        <input type="text" class="form-control" style="text-align:right" id="orden_<?php echo $idOg;?>" value ="<?php echo $ordenamiento?>" required = "required">
                        <input type="hidden" id="idCa" name="idTmp" value="<?php echo $idCa;?>"/>
                        <input type="hidden" id="idCarreraOg" name="idTmp" value="<?php echo $idCarreraOg;?>"/>
                        </td>

      <td class='text-center'>
                        <a href="#" title="Grabar Cambio" class="editarDet" value="<?php echo $idOg;?>"><i class="btn btn-sm btn-success glyphicon glyphicon-edit"></i></a>
                        </td>
                        <td class='text-center'>
                        <a href="#" title="Eliminar el registro" onclick="eliminarDet('<?php echo $idCarreraOg ?>','<?php echo $idCa; ?>','<?php echo $idOg; ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a>

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
                        var idCarreraOg = $("#idCarreraOg").val();
                        var idCa = $("#idCa").val();
            var orden = $('#orden_'+id).val();
      $.ajax({
                        type: "GET",
                        url: "./ajax/agregar_carreraog2.php",
                        data: "idCa="+idCa+"&idOg="+id+"&idCarreraOg="+idCarreraOg+"&ordenamiento="+orden+"&op=E",
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                        });
      });

</script>
