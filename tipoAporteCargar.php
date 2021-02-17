<?php
	require_once 'connect.php';

	$qedit_admin = $conn->query("SELECT idFacultad, idCarrera, idPerfilEgresado, fAprobacionMalla, fAprobacionPerfil, c.descripcion AS descCarrera, f.descripcion AS descFacultad, c.estado FROM perfilegresado LEFT JOIN carrera c USING (idCarrera) LEFT JOIN
  facultad f USING (idFacultad) WHERE c.estado='1' AND idPerfilEgresado='$_REQUEST[idPerfilEgresado]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
  <?php
    include("modal/ver_aporte4.php");
    include("modal/ver_aporte5.php");
  ?>

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
    <label>Fecha de Malla curricular:</label><br/>
      <input type = "date" name = "fAprobacion" id = "fAprobacionMalla" value="<?php echo $fedit_admin['fAprobacionMalla'];?>" disabled/>
  </div>

	<div class = "form-group">
    <label>Fecha de Perfil de egreso:</label><br/>
      <input type = "date" name = "fAprobacion" id = "fAprobacionPerfil" value="<?php echo $fedit_admin['fAprobacionPerfil'];?>" disabled/>
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
    <span class="glyphicon glyphicon-search"></span> Agregar cursos
  </button>


  <div id="resultados" style="margin-top:10px"></div><!-- Carga los datos ajax -->

  <div class = "form-group">
    <button class = "btn btn-warning" name = "edit_user" onclick="returnPrincipal();"><span class = "glyphicon glyphicon-edit"></span> Guardar</button>
  </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  var idPerfilEgresado= $("#idPerfilEgresado").val();

  $.ajax({
    type: "POST",
    url: "./ajax/agregar_tipoAporte2.php",
    data: "idPerfilEgresado="+idPerfilEgresado,

    success: function(datos){
      $("#resultados").html(datos);
    }
  });
});

function returnPrincipal(){
	alert("Registro guardado correctamente.");
	window.location = "tipoAporte.php";
}
</script>
