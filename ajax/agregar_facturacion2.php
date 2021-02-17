<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];
$idCa = (isset($_REQUEST['idCa']) && !empty($_REQUEST['idCa']))?$_REQUEST['idCa']:'';
$idMalla = (isset($_REQUEST['idMalla']) && !empty($_REQUEST['idMalla']))?$_REQUEST['idMalla']:'';
$idCu = (isset($_REQUEST['idCu']) && !empty($_REQUEST['idCu']))?$_REQUEST['idCu']:'';
$ciclo = (isset($_REQUEST['ciclo']) && !empty($_REQUEST['ciclo']))?$_REQUEST['ciclo']:'';
$obligatorio = (isset($_REQUEST['obligatorio']) && !empty($_REQUEST['obligatorio']))?$_REQUEST['obligatorio']:'';
$aol = (isset($_REQUEST['aol']) && !empty($_REQUEST['aol']))?$_REQUEST['aol']:'';

/*
if ($idTemp!='')//codigo elimina un curso del array tabla temp
{
    $id_tmp=intval($idTemp);
    $delete=mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='".$id_tmp."'");
}
*/

if (isset($_POST['elegido1']))//codigo que al seleccionar el combo de facultad, muestra las opciones de carrera
{
  $elegido1 = $_POST['elegido1'];
    $qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 and idFacultad='$elegido1' ORDER BY descripcion") or die(mysqli_error($conn));
    while($fborrow = $qborrow->fetch_array()){
        echo "<option value = '". $fborrow['idCarrera'] ."'>". $fborrow['descripcion'] . "</option>";
        }
}



//document.getElementById("ciclo_"' + $idCurso + ').focus();
if ($idCa!='' && $idCu!='' && $idMalla!='' && $_REQUEST['op']=='D')//codigo elimina un curso del array tabla temp
{
    $resultMalla  = $conn->query("SELECT COUNT(*) total FROM detalle_malla WHERE idMalla='".$idMalla."' AND eliminado='0'");
    $numRegMalla  = $resultMalla->fetch_assoc();

    if($numRegMalla['total']==1){
      echo '<script type = "text/javascript">
       alert("No es posible eliminar el registro. Favor de eliminar el registro principal.");
       </script>';

    }else {

      $sql = "DELETE FROM detalle_malla WHERE idMalla='$idMalla' and idCarrera='$idCa' and idCurso='$idCu'";
      $query = mysqli_query($conn,$sql);
    }



}

if ($idCa!='' && $idCu!='' && $idMalla!='' && $_REQUEST['op']=='E')  //
{
                    $update_tmp=mysqli_query($conn, "UPDATE detalle_malla set ciclo='$ciclo' , obligatoriedad='$obligatorio' , aol = '$aol' where idMalla = '$idMalla' and idCarrera='$idCa' and idCurso='$idCu'");

                       echo '
                        <script type = "text/javascript">
                        alert("Los datos se actualizaron correctamente.");
                        </script>';
            }




       if ($idCa!='' && $idCu!='' && $idMalla!='' && $_REQUEST['op']=='I')  //
        {

        $sql2=$conn->query("select * from detalle_malla where idCurso='$idCu' and idCarrera='$idCa' and idMalla='$idMalla' and eliminado=0");

            if ($sql2->num_rows==0)
            {

                    $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_malla (idMalla,idCarrera,idCurso,ciclo,obligatoriedad,aol) VALUES ('$idMalla','$idCa','$idCu','$ciclo','$obligatorio','$aol')");

                       echo '
                        <script type = "text/javascript">
                        alert("El curso fue agregado satisfactoriamente.");
                        </script>';

           }

else {
                echo '
                    <script type = "text/javascript">
                        alert("El curso ya se encuentra registrado en nuestra Base de datos.");
                    </script>';
             }

           }



	$sql=$conn->query("select * from curso c, detalle_malla d where c.idCurso=d.idCurso and d.idMalla='".$idMalla."' ORDER BY d.ciclo,c.nombreCurso");
        if ($sql->num_rows>0) {
            ?>
<table id = "tablEditar" class = "table table-bordered table-hover" style="width:100%">
<thead class = "alert-info">
<tr class = "alert-info">
	<th class='text-center'>Curso</th>
	<th class='text-center'>Ciclo</th>
	<th class='text-center'>Obligatoriedad</th>
	<th class='text-center'>AOL</th>
  <th class='text-center' colspan="2">Opciones</th>
</tr>
</thead>
<tbody>
<?php
	while ($row=mysqli_fetch_array($sql))
	{
	$idMalla=$row["idMalla"];
        $idCa=$row["idCarrera"];
        $idCu=$row["idCurso"];
	$nombreCurso=$row['nombreCurso'];
	$ciclo=$row['ciclo'];
	$obligatorio=$row['obligatoriedad'];
	$aol=$row['aol'];

		?>



		<tr>
			<td class='text-center'><?php echo $nombreCurso;?></td>
			<td class='text-center'><input type="text" class="form-control" style="text-align:right" id="ciclo1_<?php echo $idCu; ?>"  value="<?php echo $ciclo;?>" required = "required">
                        </td>
			<td>
                        <select name = "obligatorio1_<?php echo $idCu; ?>" id = "obligatorio1_<?php echo $idCu; ?>" required = "required">
                        <?php if($obligatorio ==1){
								 echo "<option value = '1' selected = 'selected'>Obligatorio</option>";
                                                                    echo "<option value = '2'>Electivo</option>";
                                                                 }
                                                                 elseif($obligatorio ==2){
								 echo "<option value = '1'>Obligatorio</option>";
                                                                    echo "<option value = '2' selected = 'selected'>Electivo</option>";
                                                                 } ?>
                                                                 </select>
                                                                 </td>
			<td class='text-center'>
                        <select name = "aol1_<?php echo $idCu; ?>" id = "aol1_<?php echo $idCu; ?>" required = "required">

                        <?php if($aol ==1){
								 echo "<option value = '1' selected = 'selected'>Si</option>";
                                                                    echo "<option value = '0'>No</option>";
                                                                 }
                                                                 elseif($aol ==0){
								 echo "<option value = '1'>Si</option>";
                                                                    echo "<option value = '0' selected = 'selected'>No</option>";
                                                                 } ?>
                                                                 </select>
                                                                 </td>



                        <input type="hidden" id="idCa" name="idTmp" value="<?php echo $idCa;?>"/>
                        <input type="hidden" id="idMalla" name="idTmp" value="<?php echo $idMalla;?>"/>


				<td class='text-center'>
					<a href="#" title="Guardar cambio" class="editarDet" value="<?php echo $idCu;?>"><i class="btn btn-success btn-sm glyphicon glyphicon-edit"></i></a>
				</td>
        <td class='text-center'>
					<button class="btn btn-danger btn-sm glyphicon glyphicon-trash" type="button" name="button" title="Eliminar el registro" onclick="eliminarDet('<?php echo $idMalla ?>','<?php echo $idCa; ?>','<?php echo $idCu; ?>')"></button>
        <!-- <a href="#" ><i ></i></a> -->

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
                        var idMalla = $("#idMalla").val();
                        var idCa = $("#idCa").val();
                        var ciclo1 = $('#ciclo1_'+id).val();
                        var obligatorio1 = $('#obligatorio1_'+id).val();
                        var aol1 = $('#aol1_'+id).val();
                        $.ajax({
                        type: "GET",
                        url: "./ajax/agregar_facturacion2.php",
                        data: "idCa="+idCa+"&idCu="+id+"&idMalla="+idMalla+"&ciclo="+ciclo1+"&obligatorio="+obligatorio1+"&aol="+aol1+"&op=E",
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                        });
      });

</script>
