<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT c.idMalla, c.idCarrera, b.idFacultad, c.fAprobacion,c.fActualizacion, b.idFacultad, c.estado, d.idCurso FROM malla c, carrera b, detalle_malla d WHERE c.idCarrera=b.idCarrera and c.idMalla=d.idMalla and c.estado='1' and c.idMalla = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-7">
 <?php
                                                    include("modal/buscar_cursos.php");
                                                   /* include("modal/ver_cursos.php");*/


                                                ?>
	<form method = "POST" action = "mallaEditar.php?idMalla=<?php echo $fedit_admin['idMalla']?>&idCurso=<?php echo $fedit_admin['idCurso'] ?>" enctype = "multipart/form-data">

          <div class = "form-group">
                                                <label>Facultad:</label><br/>
						<select name = "idFacultad" id = "facultad" required = "required">
							<?php
								$qborrow = $conn->query("SELECT idFacultad,descripcion FROM facultad where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
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
						<select name = "idCarrera" id = "carrera" required = "required">
							<?php
								$qborrow = $conn->query("SELECT idCarrera,descripcion FROM carrera where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
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
									<label>Fecha de aprobación:</label><br/>
									<input type = "text" name = "fAprobacion"  id = "fAprobacion" readonly value="<?php echo $fedit_admin['fAprobacion'];?>" onblur="compare();"/>
                                                                    </div>

                                                                   <div class = "form-group">
									<label>Fecha de actualización:</label><br/>
									<input type = "text" name = "fActualizacion"  id = "fActualizacion" readonly value="<?php echo $fedit_admin['fActualizacion'];?>" onblur="compare();"/>
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

                                                                <input type="hidden" id="idMalla" name="idMalla" value="<?php echo $fedit_admin['idMalla'];?>"/>
                                                                <input type="hidden" id="idCurso" name="idCurso" value="<?php echo $fedit_admin['idCurso'];?>"/>

                                                              <!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#vercursos">
						 <span class="glyphicon glyphicon-search"></span> Ver Cursos
						</button> -->

                                                                <button type="button" class="btn btn-info addcurso" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Cursos
						</button>

                                                                <div id="resultados" style="margin-top:10px"></div><!-- Carga los datos ajax -->

		<div class = "form-group">
			<button class = "btn btn-warning" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="js/nueva_factura.js"></script>

<script type="text/javascript">
  $( function() {
    $( "#fAprobacion" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendario.png",
      buttonImageOnly: true,
      dateFormat: 'yy-mm-dd',
      buttonText: "Select date"
    });

    $( "#fActualizacion" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendario.png",
      buttonImageOnly: true,
      dateFormat: 'yy-mm-dd',
      buttonText: "Select date"
    });

  } );
</script>

<script>
function load(page){
			var q= $("#q").val();
			var carrera= $("#carrera").val();
			var idMalla= $("#idMalla").val();
			var elegido=$("#dpto").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/cursos_malla_detalle.php?action=ajax&page='+page+'&q='+q+'&idCarrera=' + carrera +'&idMalla=' + idMalla+'&idDepartamento='+elegido,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
				}
			})

		}

  $(document).ready(function(){
		$('.addcurso').click(function(){
            load(1);
        })
        })

		$(document).ready(function(){
			var malla= $("#idMalla").val();
			var curso= $("#idCurso").val();
			$.ajax({
					type: "POST",
						url: "./ajax/agregar_facturacion2.php",
						data: "idMalla="+malla+"&idCurso="+curso,
						success: function(datos){
						$("#resultados").html(datos);
						}
					})
			})
</script>




<script type="text/javascript">
                                		  function compare()
{
    var startDt = document.getElementById("fAprobacion").value;
    var endDt = document.getElementById("fActualizacion").value;

    if( (new Date(startDt).getTime() > new Date(endDt).getTime()))
    {
       alert('La fecha de actualización debe ser igual o posterior a la fecha de aprobación');
       $('#fActualizacion').css("border", "3px solid red");
       return false;
    }else {
    	 $('#fActualizacion').css("border", "");
    }
}
</script>

<script type = "text/javascript">
$('#myModal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
		/*$("label.error").remove(); */ //lo utilice para borrar la etiqueta de error del jquery validate
	});
</script>
