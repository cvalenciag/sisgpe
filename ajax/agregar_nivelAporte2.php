<?php
require_once 'connect.php';

$idPerfil = $_POST['idPerfilEgresado'];

// CONSULTA QUE MUESTRA LOS RESULTADOS =====================================================================================================
$sql = $conn->query("SELECT * FROM curso c, detalle_perfilegresado_curso t, departamento d, detalle_malla dm WHERE c.idCurso=t.idCurso AND c.idDepartamento=d.idDepartamento AND dm.idCurso=t.idCurso AND idPerfilEgresado='$idPerfil'");

if ($sql->num_rows > 0)
{
?>
  <table id="tableCursos2" class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class="text-center" style="width:30%;">Curso</th>
      <th class="text-center" style="width:10%;">Ciclo</th>
      <th class="text-center" style="width:25%;">Departamento <br> Académico</th>
      <th class="text-center" style="width:15%;">Tipo <br> Curso</th>
      <th class="text-center" style="width:10%;">AoL</th>
      <th class="text-center" style="width:10%;">Asocial Objetivos <br> de Aprendizaje</th>
      <th></th>
    </tr>
  <?php
    while ($row = mysqli_fetch_array($sql))
    {
      $idPerfil     = $row["idPerfilEgresado"];
      $nombreCurso  = $row['nombreCurso'];
      $idCurso      = $row['idCurso'];
      $ciclo        = $row['ciclo'];
      $aol          = $row['aol'];
      $tipoCurso    = $row['tipoCurso'];
      $idDepartamento   = $row['idDepartamento'];
      $descDepartamento = $row['descripcion'];
  ?>
    <tr>
      <td class='text-center'><?php echo $nombreCurso; ?></td>
      <td class='text-center'><?php echo $ciclo; ?></td>
      <td class='text-center'><?php echo $descDepartamento; ?></td>
      <td class="text-center"><?php echo ($tipoCurso==1) ? "Académico" : "Para-Académico" ?></td>
      <td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-editar vadmin_id2" data-toggle="modal" data-target="#miModalObjEdit" onclick="enviaModal(<?php echo $idCurso?>, <?php echo $ciclo ?>)">
          <span></span>
            Objetivos de Aprendizaje
        </button>
      </td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="eliminarDet('<?php echo $idPerfil ?>','<?php echo $idCurso; ?>')">
        </button>
      </td>
    </tr>
  <?php
    }
  ?>
  </table>
<?php
  }
?>

 
<script type="text/javascript">
function enviaModal(id, ciclo){

  var admin_id          = id;
  var idCarrera         = $("#idCarrera").val();
  var fAprobacionPerfil = $("#fAprobacionPerfil").val();

  $("#loader").fadeIn('slow');

  $.ajax({
    url:'nivelAporte3.php?idCurso='+admin_id+'&carrera='+idCarrera+'&fechaPerfil='+fAprobacionPerfil+'&ciclo='+ciclo,

    beforeSend: function(objeto){
      // $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
    },

    success:function(data){
      $(".resul_div2").html(data).fadeIn('slow');
      $('#loader').html('');
    }
  });

}

</script>
