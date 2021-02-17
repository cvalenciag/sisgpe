<?php
	require_once 'connect.php';

	$qedit_admin = $conn->query("SELECT idFacultad, idCarrera, idPerfilEgresado, fAprobacionMalla, fAprobacionPerfil, c.descripcion AS descCarrera, f.descripcion AS descFacultad, c.estado FROM perfilegresado LEFT JOIN carrera c USING (idCarrera) LEFT JOIN
  facultad f USING (idFacultad) WHERE c.estado='1' AND idPerfilEgresado='$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
  <?php
    include("modal/ver_aporte4.php");
    include("modal/ver_aporte5.php");
  ?>

<!-- <form method="POST" action="nivelAporteEditar.php?idPerfilEgresado=<php echo $fedit_admin['idPerfilEgresado']?>" enctype="multipart/form-data"> -->

  <div class="form-group">
    <label>Facultad:</label><br/>
    <select name="idFacultad" id="facultad" required = "required">
      <?php
        $qborrow = $conn->query("SELECT idFacultad, descripcion FROM facultad where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

        while($fborrow = $qborrow->fetch_array())
        {
          $selected="";
          if($fedit_admin['idFacultad'] == $fborrow['idFacultad'])
          $selected = "selected=selected";
      ?>

        <option value = "<?php echo $fborrow['idFacultad']?>" <?php echo $selected?>><?php echo $fborrow['descripcion']?></option>

      <?php
        }
      ?>
    </select>
  </div>

  <div class = "form-group">
    <label>Carrera:</label><br/>
    <select name = "idCarrera" id = "idCarrera" required = "required">
      <?php
        $qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

        while($fborrow = $qborrow->fetch_array())
        {
          $selected="";
          if($fedit_admin['idCarrera'] == $fborrow['idCarrera'])
            $selected = "selected=selected";
      ?>

        <option value = "<?php echo $fborrow['idCarrera']?>" <?php echo $selected?>><?php echo $fborrow['descripcion']?></option>

      <?php
        }
      ?>
    </select>
  </div>

	<div class = "form-group">
    <label>Fecha de Malla:</label><br/>
      <input type = "date" name = "fAprobacion" id = "fAprobacionMalla" value="<?php echo $fedit_admin['fAprobacionMalla'];?>"/>
  </div>

	<div class = "form-group">
    <label>Fecha de Perfil:</label><br/>
      <input type = "date" name = "fAprobacion" id = "fAprobacionPerfil" value="<?php echo $fedit_admin['fAprobacionPerfil'];?>"/>
  </div>

  <div class = "form-group">
    <label>Estado:</label><br/>
    <select name = "estado" id = "estado">
      <?php
        if($fedit_admin['estado']==1) {
          echo '<option value =' . $fedit_admin['estado'] . 'selected = selected> Activo</option>';
          echo '<option value = "0">Inactivo</option>';
        } else {
          echo '<option value = "1">Activo</option>';
          echo '<option value =' . $fedit_admin['estado'] . 'selected = selected>Inactivo</option>';
        }
      ?>
    </select>
  </div>

  <input type="hidden" id="idPerfilEgresado" name="idPerfilEgresado" value="<?php echo $fedit_admin['idPerfilEgresado'];?>"/>

  <button type="button" class="btn btn-info addCurosObj" data-toggle="modal" data-target="#miModalCursosEdit">
    <span class="glyphicon glyphicon-search"></span> Agregar Cursos
  </button>


  <div id="resultados" style="margin-top:10px"></div><!-- Carga los datos ajax -->

  <div class = "form-group">
    <button class = "btn btn-warning" name = "edit_user" onclick="returnPrincipal();"><span class = "glyphicon glyphicon-edit"></span> Guardar</button>
  </div>
<!-- </form> -->
</div>

<script type="text/javascript" src="js/nuevo_reg_aporte.js"></script>
<script type="text/javascript">

function load(page){

  var idDepto           = $("#deptoAcadEdit").val();
  var obliga            = $('#obligatorioEdit').val();
  var idCarrera         = $('#idCarrera').val();
  var fAprobacionMalla  = $('#fAprobacionMalla').val();
  var fAprobacionPerfil = $('#fAprobacionPerfil').val();
  var idPerfilEgresado  = $('#idPerfilEgresado').val();

  $("#loader").fadeIn('slow');

  $.ajax({
    url:'./ajax/cursos_aporte_detalle.php?action=ajax&page='+page+'&idDepto='+idDepto+'&obligatorio='+obliga+'&idCarrera='+idCarrera+'&fechaMalla='+fAprobacionMalla+'&fechaPerfil='+fAprobacionPerfil+'&idPerfilEgresado='+idPerfilEgresado,

    beforeSend: function(objeto){
      $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
    },

    success:function(data){
      $(".outer_div2").html(data).fadeIn('slow');
      $('#loader').html('');
    }
  });
}


$(document).ready(function(){
  $('.addCurosObj').click(function(){
    load(1); 
  });
});


$(document).ready(function(){
  var idPerfilEgresado= $("#idPerfilEgresado").val();

  $.ajax({
    type: "POST",
    url: "./ajax/agregar_nivelAporte2.php",
    data: "idPerfilEgresado="+idPerfilEgresado,

    success: function(datos){
      $("#resultados").html(datos);
    }
  });
});


function returnPrincipal(){
	alert("Registro guardado correctamente.");
	window.location = "nivelAporte.php";
}

</script>
