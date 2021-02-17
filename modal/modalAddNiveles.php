<?php
require_once '../valid.php';

$idCriterio = (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';

$qryCriterios = $conn->query("SELECT * FROM criterio WHERE idCriterio='$idCriterio' AND estado=1") or die(mysqli_error($conn));
$resCriterios = $qryCriterios->fetch_assoc();
$desCriterio  = $resCriterios['descripcion'];

?>

<div class="modal-dialog modal-md" style="width:80%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Agregar Descripción por Niveles</h4>
    </div>

    <div class="modal-body">

      <div class="admin_eval">
        <div class="form-group">
          <label>Criterio: </label> <?php echo $desCriterio ?>
        </div>


        <div class="form-group">
          <label>Nivel:</label><br>
          <select name="idNivel" id="idNivel" required="required">
            <option value="" selected="selected">Seleccione una opción</option>
              <?php
                $qryNiveles = $conn->query("SELECT * FROM nivel WHERE estado=1 ORDER BY idNivel") or die(mysqli_error($conn));

                foreach ($qryNiveles as $nivel) {
              ?>
                <option value="<?php echo $nivel['idNivel']?>"><?php echo $nivel['descripcion']?></option>
              <?php
                }
              ?>
          </select>
        </div>

        <br>

        <div class="form-group">
          <label>Descripción del Nivel:</label><br>
          <textarea id="descNivel" required="required" rows="3" name="descNivel" class="form-control"></textarea>
        </div>

        <br>

        <div class="form-group">
          <label>Puntaje:</label>
          <input type="radio" name="puntaje" id="fijo" value="1" onclick="valRadio();"> Fijo &nbsp;&nbsp;
          <input type="radio" name="puntaje" id="rango" value="2" onclick="valRadio();"> Por Rango
        </div>

        <div class="form-group">
          <label>Total:</label>
          <input type="text" name="" value="" style="width:10%;" id="puntajeTotal">

          &nbsp;&nbsp;

          <label>Mínimo:</label>
          <input type="text" name="" value="" style="width:10%;" id="puntajeMin">
          &nbsp;&nbsp;
          <label>Máximo:</label>
          <input type="text" name="" value="" style="width:10%;" id="puntajeMax">
        </div>

        <br>

        <div class="form-group">
          <label>Peso:</label>
          <input type="text" name="" value="" style="width:10%;" id="idPeso"> &nbsp; %
          <input type="hidden" name="" value="" id="idSubcriterio">
        </div>

        <br>

        <div class="form-group">
          <button class="btn btn-primary" name="" id="btnAddRegistro" onclick="saveRegistro(<?php echo $idCriterio ?>);">
            <span class="glyphicon glyphicon-save"></span> Guardar
          </button>
          <button class="btn btn-success" name="" id="btnEditRegistro" onclick="updateRegistro(<?php echo $idCriterio ?>);" disabled>
            <span class="glyphicon glyphicon-save"></span> Actualizar
          </button>
        </div>

        <br>

        <div id="resultCriterios" class="form-group">
        	<table class="table table-bordered" style="width:100%;">
        		<thead>
        			<tr class="alert-info">
        				<th class="text-center">Nivel</th>
        				<th class="text-center">Descripción <br> del Nivel</th>
        				<th class="text-center">Tipo de Puntaje</th>
        				<th class="text-center">Total</th>
        				<th class="text-center">Mínimo</th>
        				<th class="text-center">Máximo</th>
        				<th class="text-center">Peso</th>
        				<th class="text-center">Funciones</th>
        			</tr>
        		</thead>
        		<tbody>
        			<?php
        			$qrySubCri = $conn->query("SELECT sc.idSubcriterio, sc.idNivel, n.descripcion as descNivel, sc.rango, sc.total, sc.minimo, sc.maximo, sc.descripcion as descSubCri, sc.peso FROM subcriterio sc LEFT JOIN nivel n USING (idNivel) WHERE idCriterio='$idCriterio' AND sc.estado=1") or die(mysqli_error($conn));

        			foreach ($qrySubCri as $subcri)
        			{
        			?>
        			<tr>
        				<td class="text-center"><?php echo $subcri['descNivel'] ?></td>
        				<td class="text-justify"><?php echo $subcri['descSubCri'] ?></td>
        				<td class="text-center">
                  <?php if ($subcri['rango'] == 1){
                  ?>
                    Fijo
                  <?php
                    }elseif($subcri['rango'] == 2) {
                  ?>
                    Por rango
                  <?php
                    }
                  ?>
                </td>
        				<td class="text-center">
                  <?php if ($subcri['rango'] == 2){
                  ?>
                    --
                  <?php
                    }elseif($subcri['rango'] == 1) {
                      echo $subcri['total'];
                    }
                  ?>
                </td>
                <td class="text-center">
                  <?php if ($subcri['rango'] == 1){
                  ?>
                    --
                  <?php
                    }elseif($subcri['rango'] == 2) {
                      echo $subcri['minimo'];
                    }
                  ?>
                </td>
        				<td class="text-center">
                  <?php if ($subcri['rango'] == 1){
                  ?>
                    --
                  <?php
                    }elseif($subcri['rango'] == 2) {
                      echo $subcri['maximo'];
                    }
                  ?>
                </td>
        				<td class="text-center"><?php echo $subcri['peso'].'%' ?></td>
        				<td class="text-center">
        					<button type="button" name="button" class="btn btn-success btn-xs" id="<?php echo $idCriterio.'_'.$subcri['idSubcriterio'] ?>" title="Edita Subcriterio" onclick="editSubCri(this.id);">
        						<span class = "glyphicon glyphicon-edit"></span>
        					</button>
        					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $idCriterio.'_'.$subcri['idSubcriterio'] ?>" title="Elimina Subcriterio" onclick="deleteSubCri(this.id);">
        						<span class="glyphicon glyphicon-trash"></span>
        					</button>
        				</td>
        			</tr>
        			<?php
        			}
        			?>
        		</tbody>
        	</table>
        </div>

        <!-- <div id="resultCriterios" class="form-group"></div> -->
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>

<script type="text/javascript">
function valRadio(){
  xPuntaje    = $('input:radio[name=puntaje]:checked').val();

  // alert(xPuntaje);

  if(xPuntaje == '1'){
    $('#puntajeMin').prop('disabled', true);
    $('#puntajeMax').prop('disabled', true);
    $('#puntajeTotal').prop('disabled', false);
  }else {
    $('#puntajeTotal').prop('disabled', true);
    $('#puntajeMin').prop('disabled', false);
    $('#puntajeMax').prop('disabled', false);
  }
}

function saveRegistro(xCriterio){

  xIdNivel      = $('#idNivel').val();
  xDescripcion  = $('#descNivel').val();
  xIdPuntaje    = $('input:radio[name=puntaje]:checked').val();
  xPTotal       = ($('#puntajeTotal').val() != '' ? $('#puntajeTotal').val() : 0);
  xPMin         = ($('#puntajeMin').val() != '' ? $('#puntajeMin').val() : 0);
  xPMax         = ($('#puntajeMax').val() != '' ? $('#puntajeMax').val() : 0);
  xPeso         = $('#idPeso').val();


  $.ajax({
    type: 'POST',
  	url: './modal/modalAddNivelesGrabar.php',
    data: 'idNivel='+xIdNivel+'&descNivel='+xDescripcion+'&rango='+xIdPuntaje+'&punTotal='+xPTotal+'&punMin='+xPMin+'&punMax='+xPMax+'&peso='+xPeso+'&idCriterio='+xCriterio,
    // data: "idGrupoAl="+xMaxId+'&idalumno='+xIdAlumno+'&detalle=d',

    beforeSend: function(objeto){
      $("#resultCriterios").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultCriterios").html(datos);
      $('#idNivel').val('');
      $('#descNivel').val('');
      $('input:radio[name=puntaje]').attr('checked',false);
      // $('input[id=male]').attr('checked',false);
      $('#puntajeTotal').val('');
      $('#puntajeMin').val('');
      $('#puntajeMax').val('');
      $('#idPeso').val('');

      $('#puntajeTotal').prop('disabled', false);
      $('#puntajeMin').prop('disabled', false);
      $('#puntajeMax').prop('disabled', false);
    }

  }); //LLAVE AJAX

}


// FUNCION PARA EDITAR ===============================================================
function editSubCri(id){
  $('#btnAddRegistro').attr('disabled', true);
  $('#btnEditRegistro').attr('disabled', false);
  $('#idNivel').empty();

  arr         = id.split('_');
  xIdCriterio = arr[0];
  xIdSubCri   = arr[1];

  $.ajax({
    type: 'POST',
  	url: './modal/modalAddNivelesEdit.php',
    data: 'idCriterio='+xIdCriterio+'&idSubcriterio='+xIdSubCri,
    // data: "idGrupoAl="+xMaxId+'&idalumno='+xIdAlumno+'&detalle=d',

    success: function(data){
      var obj = JSON.parse(data);

      xIdNivel    = obj.idNivel;
      xIdSubCri   = obj.idSubcriterio;
      xDescSub    = obj.descSubCri;
      xRango      = obj.rango;
      xTotal      = obj.total;
      xMax        = obj.maximo;
      xMin        = obj.minimo;
      xPeso       = obj.peso;
      xNiveles    = obj.niveles;

      // alert(xRango);

      $.each(xNiveles, function (i, item) {
        var level = ((item.idNivel == xIdNivel) ? true:false);
          $('#idNivel').append($('<option >', {
              value: item.idNivel,
              text : item.descripcion,
              selected: level
          }));
      });


      $('#descNivel').val(xDescSub);
      // $('input:radio[name=puntaje]').val(xRango);

      if(xRango == '1'){
        $('#fijo').prop('checked', true);
        $('#puntajeTotal').val(xTotal);
        $('#puntajeMin').prop('disabled', true);
        $('#puntajeMax').prop('disabled', true);

      }else if(xRango == '2'){
        $('#rango').prop('checked', true);
        $('#puntajeMax').val(xMax);
        $('#puntajeMin').val(xMin);
        $('#puntajeTotal').prop('disabled', true);
      }

      $('#idPeso').val(xPeso);
      $('#idSubcriterio').val(xIdSubCri);

    }  //SUCCESS
      // $("#resultCriterios").html(datos);
  }); //LLAVE AJAX
}



// FUNCION PARA ELIMINAR ===============================================================
function deleteSubCri(id){

  arr         = id.split('_');
  xIdCriterio = arr[0];
  xIdSubCri   = arr[1];

  $.ajax({
    type: 'POST',
  	url: './modal/modalAddNivelesDelete.php',
    data: 'idCriterio='+xIdCriterio+'&idSubcriterio='+xIdSubCri,
    // data: "idGrupoAl="+xMaxId+'&idalumno='+xIdAlumno+'&detalle=d',

    beforeSend: function(objeto){
      $("#resultCriterios").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultCriterios").html(datos);

    }

  }); //LLAVE AJAX

}

function updateRegistro(xIdCriterio){

  xIdSubCri     = $('#idSubcriterio').val();
  xIdNivel      = $('#idNivel').val();
  xDescripcion  = $('#descNivel').val();
  xIdPuntaje    = $('input:radio[name=puntaje]:checked').val();
  xPTotal       = ($('#puntajeTotal').val() != '' ? $('#puntajeTotal').val() : 0);
  xPMin         = ($('#puntajeMin').val() != '' ? $('#puntajeMin').val() : 0);
  xPMax         = ($('#puntajeMax').val() != '' ? $('#puntajeMax').val() : 0);
  xPeso         = $('#idPeso').val();


  $.ajax({
    type: 'POST',
  	url: './modal/modalAddNivelesUpdate.php',
    data: 'idNivel='+xIdNivel+'&descNivel='+xDescripcion+'&rango='+xIdPuntaje+'&punTotal='+xPTotal+'&punMin='+xPMin+'&punMax='+xPMax+'&peso='+xPeso+'&idCriterio='+xIdCriterio+'&idSubcriterio='+xIdSubCri,
    // data: "idGrupoAl="+xMaxId+'&idalumno='+xIdAlumno+'&detalle=d',

    beforeSend: function(objeto){
      $("#resultCriterios").html("Mensaje: Cargando...");
    },

    success: function(datos){

      // if (datos == '1') {
      //   alert("El registro se actualizó correctamente.");
      //   $("#btnAddRegistro").attr("disabled", false);
      //   $("#btnEditRegistro").attr("disabled", true);
      // }

      $("#resultCriterios").html(datos);
      // $('#idNivel').val('');
      $('#idNivel').append('<option selected="selected">Seleccione una opción</option>');
      $('#descNivel').val('');
      $('input:radio[name=puntaje]').attr('checked', false);
      // $('input[id=male]').attr('checked',false);
      $('#puntajeTotal').val('');
      $('#puntajeMin').val('');
      $('#puntajeMax').val('');
      $('#idPeso').val('');
      $('#idSubcriterio').val('');

      $('#puntajeTotal').prop('disabled', false);
      $('#puntajeMin').prop('disabled', false);
      $('#puntajeMax').prop('disabled', false);
    }

  }); //LLAVE AJAX

}
</script>
