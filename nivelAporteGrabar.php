<?php

require_once 'valid.php';
$session_id= $_SESSION['session_id'];

$idCurso        = $_POST['idCurso'];
$ciclo          = $_POST['ciclo'];
$aol            = $_POST['aol'];

$sqlTmp = $conn->query("SELECT * FROM tmp where idCurso='$idCurso' AND idSession='$session_id'");
if ($sqlTmp->num_rows==0)
{
  $insert = mysqli_query($conn, "INSERT INTO tmp (idCurso, ciclo, aol, idSession) VALUES
                                ('$idCurso','$ciclo','$aol','$session_id')");

  echo '<script type = "text/javascript">
        alert("El curso fue agregado satisfactoriamente.");
        </script>';
}else {
  echo '<script type = "text/javascript">
        alert("El curso ya se encuentra registrado en la base de datos.");
        </script>';
}


// MUESTRA LOS VALORES DE LA TABLA TEMPORAL
$sql = $conn->query("SELECT * FROM curso c, tmp t, departamento d WHERE c.idCurso=t.idCurso AND c.idDepartamento=d.idDepartamento AND t.idSession='".$session_id."'");
if ($sql->num_rows > 0)
{
?>
  <table id="tableCursos" class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class="text-center" style="width:30%;">Curso</th>
      <th class="text-center" style="width:10%;">Ciclo</th>
      <th class="text-center" style="width:25%;">Departamento <br> Académico</th>
      <th class="text-center" style="width:15%;">Tipo <br> Curso</th>
      <th class="text-center" style="width:10%;">AoL</th>
      <th class="text-center" style="width:10%;">Asociar Objetivos <br> de Aprendizaje</th>
      <th></th>
    </tr>
  <?php
    while ($row = mysqli_fetch_array($sql))
    {
      $id_tmp       = $row["idTmp"];
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
      <td class='text-center'><?php echo $ciclo; ?>
        <input type="hidden" name="" id="cicloObj" value="<?php echo $ciclo ?>">
      </td>
      <td class='text-center'><?php echo $descDepartamento; ?></td>
      <td class="text-center"><?php echo ($tipoCurso==1) ? "Académico" : "Para-Académico" ?></td>
      <td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-editar vadmin_id" onclick="validar(<?php echo $idCurso ?>);" data-toggle="modal" data-target="#miModal" value="<?php echo $idCurso ?>">
          <span></span>
            Objetivos de Aprendizaje
        </button>
      </td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash deladmin_id" value="<?php echo $id_tmp; ?>">
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
function validar(id){

  var idCarrera         = $("#idCarrera").val();

  $.ajax({
    url:'nivelAporte2_1.php?idcurso='+id+'&idcarrera='+idCarrera+'&nuevoRegistro=NR',
  });
}
 

$(document).ready(function(){
  $("#tableCursos").on("click", ".vadmin_id", function(){
    var admin_id          = $(this).attr('value');
    var idCarrera         = $("#idCarrera").val();
    var fAprobacionPerfil = $("#fechaPerfil").val();
    var cicloObj          = $("#cicloObj").val();

    $("#loader").fadeIn('slow');

    $.ajax({
      url:'nivelAporte2.php?idCurso='+admin_id+'&carrera='+idCarrera+'&fechaPerfil='+fAprobacionPerfil+'&cicloObj='+cicloObj,

      beforeSend: function(objeto){
        // $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
      },

      success:function(data){
        $(".resul_div2").html(data).fadeIn('slow');
        $('#loader').html('');
      }
    });
  });


  $("#tableCursos").on("click", ".deladmin_id", function(){
  	var admin_id = $(this).attr('value');
  	var p = confirm("¿Está seguro de eliminar el registro?");
  		if(p){

        $.ajax({
        type: "POST",
        url: "nivelAporteEliminarCurso.php",
        data: "&id="+admin_id,

          beforeSend: function(objeto){
            $("#resultados").html("Mensaje: Cargando...");
          },
          success: function(datos){
            $("#resultados").html(datos);
          }
        });
  		}
  });


});

</script>
