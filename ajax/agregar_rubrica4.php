<?php
require_once '../valid.php';

$session_id= $_SESSION['session_id'];

// $idRubrica      = (isset($_REQUEST['idRubrica']) && !empty($_REQUEST['idRubrica']))?$_REQUEST['idRubrica']:'';
// $idNivel        = (isset($_REQUEST['idNivel']) && !empty($_REQUEST['idNivel']))?$_REQUEST['idNivel']:'';
// $ordenNivel     = (isset($_REQUEST['ordenNivel']) && !empty($_REQUEST['ordenNivel']))?$_REQUEST['ordenNivel']:'';
// $idSubcriterio  = (isset($_REQUEST['idSubcriterio']) && !empty($_REQUEST['idSubcriterio']))?$_REQUEST['idSubcriterio']:'';
// $puntaje        = (isset($_REQUEST['puntaje']) && !empty($_REQUEST['puntaje']))?$_REQUEST['puntaje']:'';

$xIdRubrica = $_POST['IdRubrica'];
$xIdNivel   = $_POST['IdNivel'];
$xOrdNivel  = $_POST['OrdenNivel'];
$xSubCri    = $_POST['IdSubcriterio'];
$xPuntaje   = $_POST['Puntaje'];

// echo $xPuntaje;
 
$varEditar = (isset($_REQUEST['op']) && !empty($_REQUEST['op']))?$_REQUEST['op']:'';
if ($varEditar == 'i')  //
{
  $sql2=$conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica='$xIdRubrica' AND ordNivel='$xOrdNivel'") or die (mysqli_error($conn));

  if ($sql2->num_rows==0)
  {

    $insert_tmp = mysqli_query($conn,"INSERT INTO detalle_rubrica (idRubrica, idNivel, ordNivel, idSubcri, puntajeRango, eliminado) VALUES ('$xIdRubrica', '$xIdNivel', '$xOrdNivel', '$xSubCri', '$xPuntaje', 1)");

    echo '<script type = "text/javascript">
            alert("El subcriterio fue agregado satisfactoriamente.");
          </script>';
  }else {
    echo '<script type = "text/javascript">
            alert("El valor ya existe. Favor de verificar.");
          </script>';

    echo '<input type="hidden" name="" value="1" id="idWarning">';
  }

}

$sql=$conn->query("SELECT
  d.idRubrica,
  d.idNivel,
  n.descripcion AS descNivel,
  d.ordNivel,
  d.idSubcri,
  s.descripcion AS descSubcri,
  d.puntajeRango
FROM
  detalle_rubrica d
      LEFT JOIN
  subcriterio s ON (s.idSubcriterio = d.idSubcri)
      LEFT JOIN
  nivel n ON (n.idNivel = d.idNivel) WHERE d.idRubrica='".$xIdRubrica."' ");

  if ($sql->num_rows>0)
  {
?>

<table id = "tableEditar2" class = "table table-bordered table-hover" style="width:100%;">
  <thead class = "alert-info">
    <tr class = "alert-info">
	    <th class='text-center'>Descripción de Nivel</th>
	    <th class='text-center'>Orden de Nivel</th>
	    <th class='text-center'>Rotulo de Nivel</th>
	    <th class='text-center'>Puntaje</th>
	    <th class='text-center' colspan="2">Opciones</th>
    </tr>
  </thead>
  <tbody>
    <?php
      foreach ($sql as $sql1)
      {
        $idRubrica        = $sql1["idRubrica"];
        $idNivel          = $sql1["idNivel"];
        $ordenNivel       = $sql1["ordNivel"];
        $idSubcriterio    = $sql1["idSubcri"];
        $definicion       = $sql1['descSubcri'];
        $definicionNivel  = $sql1['descNivel'];
        $puntaje          = $sql1['puntajeRango'];
    ?>
    <tr>
      <td class='text-justify'><?php echo $definicion ?></td>
      <td class='text-center'>
        <input type="text" onkeypress="return justNumbers(event);" class="form-control" style="text-align:right" id="ordenNivel_<?php echo $idSubcriterio ?>" value ="<?php echo $ordenNivel?>" required = "required">
      </td>
      <td class="text-center"><?php echo $definicionNivel ?></td>
      <td class="text-center">
        <input type="text" onkeypress="return justNumbers(event);" class="form-control" style="text-align:right" id="puntaje_<?php echo $idSubcriterio ?>" value ="<?php echo $puntaje?>" required = "required">
      </td>


      <input type="hidden" id="idRubrica" name="idTmp" value="<?php echo $idRubrica ?>"/>
      <input type="hidden" id="idNivel" name="idTmp" value="<?php echo $idNivel ?>"/>
      <input type="hidden" id="idSubcriterio" name="idTmp" value="<?php echo $idSubcriterio ?>"/>

      <td class='text-center'>
                        <a href="#" title="Grabar Cambio" class="editarDet" value="<?php echo $idRubrica?>','<?php echo $idNivel ?>"><i class="btn btn-sm btn-success glyphicon glyphicon-edit"></i></a>
                        </td>
                        <td class='text-center'>
                        <a href="#" title="Eliminar Registro" onclick="eliminarDet('<?php echo $idRubrica  ?>', '<?php echo $idNivel ?>', '<?php echo $idSubcriterio ?>', '<?php echo $ordenNivel ?>')"><i class="btn btn-sm btn-danger glyphicon glyphicon-trash"></i></a>

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

$("#tableEditar2").on("click", ".editarDet", function(){
                        // var id = $(this).attr('value');
                        var idRubrica     = $("#idRubrica").val();
                        var idNivel       = $("#idNivel").val();
                        var idSubcriterio = $("#idSubcriterio").val();
						var ordenNivel = $('#ordenNivel_'+idSubcriterio).val();
						var puntaje = $('#puntaje_'+idSubcriterio).val();
			$.ajax({
                        type: "GET",
                        url: "./ajax/agregar_rubrica2.php",
                        // data: "idOg="+idOg+"&idOe="+id+"&idOgOe="+idOgOe+"&ordenamiento="+orden+"&op=E",
                        data: "idRubrica="+idRubrica+"&idNivel="+idNivel+"&idSubcriterio="+idSubcriterio+'&ordenNivel='+ordenNivel+'&puntaje='+puntaje+"&op=E",
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                        });
			});


      function justNumbers(e)
      {
        var keynum = window.event ? window.event.keyCode : e.which;
        if ((keynum == 8) || (keynum == 46))
        return true;

        return /\d/.test(String.fromCharCode(keynum));
      }
</script>
