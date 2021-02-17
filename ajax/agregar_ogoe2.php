<?php
require_once '../valid.php';
$session_id= $_SESSION['session_id'];

$idOg = (isset($_REQUEST['idOg']) && !empty($_REQUEST['idOg']))?$_REQUEST['idOg']:'';
$idOgOe = (isset($_REQUEST['idOgOe']) && !empty($_REQUEST['idOgOe']))?$_REQUEST['idOgOe']:'';
$idOe = (isset($_REQUEST['idOe']) && !empty($_REQUEST['idOe']))?$_REQUEST['idOe']:'';
$ordenamiento = (isset($_REQUEST['ordenamiento']) && !empty($_REQUEST['ordenamiento']))?$_REQUEST['ordenamiento']:'';


if ($idOg!='' && $idOe!='' && $idOgOe!='' && $_REQUEST['op']=='D')//codigo elimina un curso del array tabla temp
{
  $resultMalla  = $conn->query("SELECT COUNT(*) total FROM detalle_og_oe WHERE idOgOe='".$idOgOe."' AND eliminado='0'");
  $numRegMalla  = $resultMalla->fetch_assoc();

  if($numRegMalla['total']==1){
    echo '<script type = "text/javascript">
     alert("No es posible eliminar el registro. Favor de eliminar el registro principal.");
     </script>';

  }else {
    $sql = "DELETE FROM detalle_og_oe WHERE idOgOe='$idOgOe' and idObjgeneral='$idOg' and idObjespecifico='$idOe'";
    $query = mysqli_query($conn,$sql);
  }
}


if ($idOg!='' && $idOe!='' && $idOgOe!='' && $_REQUEST['op']=='E')  //
{

            $sql3=$conn->query("select * from detalle_og_oe where idOgOe = '$idOgOe' and idObjgeneral='$idOg' and ordenamiento='$ordenamiento'");

            if ($sql3->num_rows==0)
            {

                    $update_tmp=mysqli_query($conn, "update detalle_og_oe set ordenamiento='$ordenamiento' where idOgOe = '$idOgOe' and idObjgeneral='$idOg' and idObjespecifico='$idOe'");

                       echo '
                        <script type = "text/javascript">
                        alert("El ordenamiento fue actualizado correctamente.");
                        </script>';
            }


                            else {
                                    echo '
                                        <script type = "text/javascript">
                                            alert("El numero de orden ya existe. Por favor cambie de número.");
                                        </script>';
                                 }

}



if ($idOg!='' && $idOe!='' && $idOgOe!='' && $_REQUEST['op']=='I')  //
{

        $sql2=$conn->query("select * from detalle_og_oe where idObjespecifico='$idOe' and idObjgeneral='$idOg' and idOgOe='$idOgOe' and eliminado=0");
            if ($sql2->num_rows==0)
            {

            // $sql3=$conn->query("select * from detalle_og_oe where idOgOe = '$idOgOe' and idObjgeneral='$idOg' and ordenamiento='$ordenamiento'");
            // if ($sql3->num_rows==0)
            // { // inicio if num_rows

                    $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_og_oe (idOgOe,idObjgeneral,idObjespecifico,ordenamiento,eliminado) VALUES ('$idOgOe','$idOg','$idOe','$ordenamiento','0')");

                       echo '
                        <script type = "text/javascript">
                        alert("El objetivo específico fue agregado satisfactoriamente.");
                        </script>';
            }


                            else {
                                    echo '
                                    <script type = "text/javascript">
                                      alert("El número de orden ya existe. Favor de cambiar el número.");
                                    </script>';

                                          echo '<script type = "text/javascript">
                                        $("#ordenamiento_' . $idOe . '").val("");
                                        </script>
                                        ';
                                 }

           }


        // else {
        //         echo '
        //             <script type = "text/javascript">
        //                 alert("El objetivo específico ya se encuentra registrado en la base de datos.");
        //             </script>';
        //      }

// }


// luego muestra la tabla detalle_og_oe con los cursos seleccionados de acuerdo a la carrera elegida

	$sql=$conn->query("select * from objespecifico o, detalle_og_oe d where o.idObjespecifico=d.idObjespecifico and d.idOgOe='".$idOgOe."' ORDER BY d.ordenamiento");
        if ($sql->num_rows>0) {
        ?>

<table id = "tablEditar" class = "table table-bordered table-hover" style="width:100%;">
<thead class = "alert-info">
<tr class = "alert-info">
	<th class='text-center'>Objetivo especifico</th>
	<th class='text-center'>Ordenamiento</th>
	<th class='text-center' colspan="2">Opciones</th>
</tr>
</thead>
<tbody>

<?php
	while ($row=mysqli_fetch_array($sql))
	{
	$idOgOe=$row["idOgOe"];
        $idOg=$row["idObjgeneral"];
        $idOe=$row["idObjespecifico"];
	$definicion=$row['definicion'];
	$ordenamiento=$row['ordenamiento'];
		?>
		<tr>
			<td class='text-center'><?php echo $definicion;?></td>
			<td class='text-center'>
                        <input type="text" class="form-control" style="text-align:right" id="orden_<?php echo $idOe;?>" value ="<?php echo $ordenamiento?>" required = "required">
                        <input type="hidden" id="idOg" name="idTmp" value="<?php echo $idOg;?>"/>
                        <input type="hidden" id="idOgOe" name="idTmp" value="<?php echo $idOgOe;?>"/>
                        </td>

			<td class='text-center'>
                        <a href="#" title="Grabar Cambio" class="editarDet" value="<?php echo $idOe;?>"><i class="btn btn-sm btn-success glyphicon glyphicon-edit"></i></a>
                        </td>
                        <td class='text-center'>
                        <a href="#" title="Eliminar Registro" onclick="eliminarDet('<?php echo $idOgOe ?>','<?php echo $idOg; ?>','<?php echo $idOe; ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a>

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
                        var idOgOe = $("#idOgOe").val();
                        var idOg = $("#idOg").val();
						var orden = $('#orden_'+id).val();
			$.ajax({
                        type: "GET",
                        url: "./ajax/agregar_ogoe2.php",
                        data: "idOg="+idOg+"&idOe="+id+"&idOgOe="+idOgOe+"&ordenamiento="+orden+"&op=E",
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                        });
			});

</script>
