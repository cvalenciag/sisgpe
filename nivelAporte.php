<?php
	require_once 'valid.php';
?>

<!DOCTYPE html>
<html lang = "eng">
  <?php require("head.php"); ?>
	 <div class = "container-fluid">
    <?php require("menu.php"); ?>
      <div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Diseño curricular / Nivel de Aporte</div>
        <button id="add_admin" type="button" class="btn btn-primary"><span class = "glyphicon glyphicon-plus">
          </span> Agregar nuevo</button>
        <button id="show_admin" type="button" style="display:none;" class="btn btn-primary">
          <span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>

        <br><br>

        <?php
          $sqlTempo = $conn->query("SELECT * FROM tmp") or die(mysqli_error($conn));
          if ($sqlTempo->num_rows>0){
            $delete=mysqli_query($conn, "DELETE FROM tmp");
          }
        ?>
				<?php include('modal/ver_aporte.php'); ?>
				<?php include('modal/ver_aporte2.php'); ?>
				<?php include('modal/ver_aporte3.php'); ?>
        <div id="admin_table">
        <label>Descargar</label>
          <table id="table" class="table table-bordered table-hover" style="width: 100%;">
            <thead class="alert-info">
              <tr>
                <th class="text-center">Carrera</th>
                <th class="text-center">Fecha Malla</th>
                <th class="text-center">Fecha Perfil</th>
                <th class="text-center">Cursos</th>
                <th class="text-center">Estado</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if($_SESSION['rol_id']==1)
                $rol="";
              else
                $rol=" and m.estado=1";

              $q_admin = $conn->query("SELECT p.idPerfilEgresado, p.idCarrera, p.fAprobacionMalla, p.fAprobacionPerfil, p.eliminado, c.descripcion FROM perfilegresado p, carrera c WHERE p.idCarrera=c.idCarrera AND p.eliminado='0'") or die(mysqli_error($conn));

              while($f_admin = $q_admin->fetch_array())
              {

                $idPerfil 	= $f_admin['idPerfilEgresado'];
                $idCarrera	= $f_admin['idCarrera'];

                $result = $conn->query("SELECT COUNT(*) total FROM detalle_perfilegresado_curso where idPerfilEgresado='".$idPerfil."' AND eliminado='0'");
                $numReg = $result->fetch_assoc();
            ?>
              <tr class="target">
                <td class="text-left"><?php echo $f_admin['descripcion']?></td>
                <td class="text-center"><?php echo $f_admin['fAprobacionMalla']?></td>
                <td class="text-center"><?php echo $f_admin['fAprobacionPerfil']?></td>
                <td class="text-center"><?php echo $numReg['total'];?></td>

                <div style = "float:left;">
                  <td>
                    <?php if ($f_admin['eliminado']==0){
                        echo "Activo";
                        $btnclas="btn-danger btn-sm";
                        $title="Desactivar Registro";
                        $estado=0;
                      }else {
                        echo "Inactivo";
                        $btnclas="btn-success btn-sm";
                        $title="Activar registro";
                        $estado=1;
                      }
                    ?>
                </div>

                <div style = "float:right;">
                  <button type="button" name="button" class="btn btn-success btn-sm vadmin_id" data-toggle="modal" data-target="#miModal2" value="<?php echo $f_admin['idPerfilEgresado']?>">
                    <span class="glyphicon glyphicon-search" title="Ver Registro"></span>
                  </button>

                  <button type="button" name="button" class="btn btn-editar btn-sm eadmin_id" value="<?php echo $f_admin['idPerfilEgresado']?>">
                    <span class = "glyphicon glyphicon-edit" title="Editar Registro"></span>
                  </button>

                  <button type="button" name="button" class="btn <?php echo $btnclas?> deladmin_id" value="<?php echo $f_admin['idPerfilEgresado']?>">
                    <span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span>
                  </button>

									<a href="#" id="<?php echo $f_admin['idPerfilEgresado']; ?>_<?php echo $f_admin['fAprobacionPerfil']; ?>_<?php echo $f_admin['idCarrera']; ?>" onclick="reporteObj(this.id);"><img src="images/xls.png" alt=""></a>

                </div>
              </td>
            </tr> 
          <?php
            }
          ?>
        </tbody>
      </table>
    </div>

    <div id="edit_form"></div>
    <div id="admin_form" style = "display:none;">
      <div class="col-lg-3"></div>
      <div class="col-lg-6">
			<div class = "form-group">
				<label>Facultad: </label><br>
					<select name="idFacultad" id="idFacultad" required="required">
						<option value="" selected="selected">Seleccione una opción</option>

						<?php
							$qborrow = $conn->query("SELECT idFacultad, descripcion FROM facultad where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

							while($fborrow = $qborrow->fetch_array())
							{
						?>
							<option value = "<?php echo $fborrow['idFacultad']?>"><?php echo $fborrow['descripcion']?></option>
						<?php
							}
						?>
					</select>
			</div>


        <div class = "form-group">
          <label>Carrera: </label><br>
            <select name="idCarrera" id="idCarrera" required="required">
              <option value="" selected="selected">Seleccione una opción</option>
            </select>
        </div>

        <div class = "form-group">
          <label>Fecha de Malla: </label><br>
            <select name="fechaMalla" id="fechaMalla" required="required">
              <option value="" selected="selected">Seleccione una opción</option>
            </select>
        </div>

        <div class = "form-group">
          <label>Fecha de Perfil: </label><br>
            <select name="fechaPerfil" id="fechaPerfil" required="required">
              <option value="" selected="selected">Seleccione una opción</option>
            </select>
        </div>

				<div class="form-group">
					<label>Estado: </label><br>
					<select name="estado" id="estado">
						<option value="1" selected="selected">Activo</option>
						<option value="0">Inactivo</option>
					</select>
				</div>

				<button type="button" id="btnAddCurso" class="btn btn-default addcurso" data-toggle="modal" data-target="#miModalCursos">
					<span class="glyphicon glyphicon-search"></span> Agregar Cursos
				</button>

        <div id="resultados" style="margin-top:15px"></div>

				<div class="form-group">
					<button id="btnRegistrar" class="btn btn-primary" name="" onclick="saveNivelAporte();">
						<span class="glyphicon glyphicon-save"></span> Registrar
					</button>
				</div>

      </div>
    </div>
  </div>
</div>

<br><br><br>
<?php require("footer.php"); ?>


<script type="text/javascript" src="js/nuevo_reg_aporte.js"></script>
<script type = "text/javascript">
$(document).ready(function() {
  $('#table').DataTable( {
		"language": {
    	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },

		dom: 'Bfrtip',
			buttons: [
			{
				extend: 'pdf',
				text: '<img src="images/pdf.png" width=20 height=20/>',
				titleAttr: 'Exportar a pdf'
			},
			{
				extend: 'excel',
				text: '<img src="images/xls.png" width=20 height=20/>',
				titleAttr: 'Exportar a excel'
			},
			{
				extend: 'csv',
				text: '<img src="images/csv.png" width=20 height=20/>',
				titleAttr: 'Exportar a csv'
			},
			{
				extend: 'print',
				text: '<img src="images/print.png" width=20 height=20/>',
				titleAttr: 'Imprimir'
			}],
			columnDefs: [
    		{ width: "35%", targets: 0 },
    		{ width: "15%", targets: 1 },
    		{ width: "15%", targets: 2 },
    		{ width: "10%", targets: 3 },
    		{ width: "25%", targets: 4 },
  		],
	});
});

// =========================================================================================================
$(document).ready(function (){
  $('#add_admin').click(function(){
    $(this).hide();
    $('#admin_table').slideUp(); //OCULTA TABLA DE RESULTADOS
    $('#show_admin').show(); // MUESTRA BOTON VOVLER
    $('#admin_form').slideDown(); //MUESTRA DATOS A AGREGAR
  });


  $('#show_admin').click(function(){
    $(this).hide();
    $('#admin_table').slideDown();
    $('#add_admin').show();
    $('#admin_form').slideUp();
    window.location = 'nivelAporte.php';
  });
});

// =========================================================================================================

$(document).ready(function(){
	$('#idCarrera').prop("disabled", true);
	$('#fechaMalla').prop("disabled", true);
	$('#fechaPerfil').prop("disabled", true);
	$('#estado').prop("disabled", true);
	$('#btnAddCurso').prop("disabled", true);
	$('#btnRegistrar').prop("disabled", true);


  $("#idFacultad").on('change', function () {
    $("#idFacultad option:selected").each(function () {
      xFacultad	=	$(this).val();

        if(xFacultad == ""){
						$('#idCarrera').prop("disabled", true);
						$('#fechaMalla').prop("disabled", true);
						$('#fechaPerfil').prop("disabled", true);
						$('#estado').prop("disabled", true);
						$('#btnAddCurso').prop("disabled", true);
						$('#btnRegistrar').prop("disabled", true);
				} else {
						$('#idCarrera').prop("disabled", false);
						$('#fechaMalla').prop("disabled", false);
						$('#fechaPerfil').prop("disabled", false);
						$('#estado').prop("disabled", false);
						$('#btnAddCurso').prop("disabled", false);
						$('#btnRegistrar').prop("disabled", false);
				}

        $.post("./ajax/agregar_nivelAporte.php", { idFacultad: xFacultad }, function(data){
          $("#idCarrera").html(data);
        });

		});

  });


  $("#idCarrera").on('change', function () {
    $("#idCarrera option:selected").each(function () {
      var xCarrera =	$(this).val();

			$.post("./ajax/agregar_nivelAporte.php", { idCarrera: xCarrera }, function(data){
				$("#fechaMalla").html(data);
			});
    });
  });


	$("#fechaMalla").on('change', function () {
    $("#idCarrera option:selected").each(function () {
      // var xFechaMalla =	$(this).val();
			var xCarrera =	$(this).val();

			// $.post("./ajax/agregar_nivelAporte.php", { fechaMalla: xFechaMalla }, function(data){
			$.post("./ajax/agregar_nivelAporte.php", { idCarrera2: xCarrera }, function(data){
				$("#fechaPerfil").html(data);
			});
    });
  });

});

function saveNivelAporte(){

	var idCarrera 				= $('#idCarrera').val();
	var fAprobacionMalla	= $('#fechaMalla').val();
	var fAprobacionPerfil	= $('#fechaPerfil').val();

	$.ajax({
		type: 'POST',
		url: 'nivelAporteGrabar3.php',
		data:"&idCarrera="+idCarrera+"&fAprobacionMalla="+fAprobacionMalla+"&fAprobacionPerfil="+fAprobacionPerfil,

		beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		},

		success: function(datos){
			$("#resultados").html(datos);
	  }

	});

}


$(document).ready(function(){
	$("#table").on("click", ".deladmin_id", function(){
		var admin_id = $(this).attr('value');
		var p = confirm("¿Está seguro de eliminar el registro?");
			if(p){
				window.location = 'nivelAporteEliminar.php?admin_id='+admin_id;
			 }
	})
});

</script>


<script type="text/javascript">

$(document).ready(function(){
  function load(page)
  {
    var idDepto           = $("#deptoAcad").val();
    var obliga            = $('#obligatorio').val();
    var idCarrera         = $('#idCarrera').val();
    var fAprobacionMalla  = $('#fechaMalla').val();

    $("#loader").fadeIn('slow');

    $.ajax({
      url:'./ajax/cursos_aporte.php?action=ajax&page='+page+'&idDepto='+idDepto+'&obligatorio='+obliga+'&idCarrera='+idCarrera+'&fechaMalla='+fAprobacionMalla,

      beforeSend: function(objeto){
        $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
      },

      success:function(data){
        $(".outer_div").html(data).fadeIn('slow');
        $('#loader').html('');
      }
    });

  }


  $('.addcurso').click(function(){
    load(1);
  })

});


$(document).ready(function(){

	$("#table").on("click", ".vadmin_id", function(){
		var admin_id = $(this).attr('value');

		$("#loader").fadeIn('slow');

		$.ajax({
			url:'./ajax/listaNivelAporte.php?idPerfilEgresado='+admin_id,

			beforeSend: function(objeto){
				$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},

			success:function(data){
				$(".resul_div2").html(data).fadeIn('slow');
				$('#loader').html('');
			}
		});
	});



	$("#table").on("click", ".eadmin_id", function(){
		$admin_id = $(this).attr('value');

		$('#show_admin').show();
		$('#show_admin').click(function(){
			$(this).hide();

			$('#edit_form').empty();
			$('#admin_table').show();
			$('#add_admin').show();
		});

		$('#admin_table').fadeOut();
		$('#add_admin').hide();
		$('#edit_form').load('nivelAporteCargar.php?admin_id='+$admin_id);
	});

});

</script>

</html>
