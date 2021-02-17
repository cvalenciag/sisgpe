<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT o.idCarreraCompetencia, c.idCarrera ,f.idFacultad ,o.fAprobacion,o.estado FROM carrera_competencia o, carrera c ,facultad f where o.idCarrera=c.idCarrera and c.idFacultad=f.idFacultad and o.estado='1' and o.idCarreraCompetencia = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
 <?php
                                                    include("modal/buscar_competencia.php");
                                                    /*include("modal/ver_competencia.php");*/


                                                ?>
	<form method= "POST" action = "carreracompetenciaEditar.php?idCarreraCompetencia=<?php echo $fedit_admin['idCarreraCompetencia']?>&idCarrera=<?php echo $fedit_admin['idCarrera'] ?>" enctype = "multipart/form-data">

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
									<input type = "text" name = "fAprobacion" id = "fAprobacion" readonly value="<?php echo date("Y-m-d");?>"/>
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

                                                                <input type="hidden" id="idCarreraCompetencia" name="idCarreraCompetencia" value="<?php echo $fedit_admin['idCarreraCompetencia'];?>"/>

                                                            <!--   <button type="button" class="btn btn-default" data-toggle="modal" data-target="#vercompetencia">
						 <span class="glyphicon glyphicon-search"></span> Ver Competencias
						</button> -->

                                                                <button type="button" class="btn btn-info addCC" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Competencias
						</button>

                                                               <div id="resultados" style="margin-top:10px"></div><!-- Carga los datos ajax -->

		<div class = "form-group">
			<button class = "btn btn-warning" name = "edit_user">
				<span class = "glyphicon glyphicon-edit"></span> Guardar</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="js/nuevo_reg_carreracompetencia.js"></script>
<script type="text/javascript">
  $( function() {
    $( "#fAprobacion" ).datepicker({
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
			var idCarreraCompetencia= $("#idCarreraCompetencia").val();
			var elegido=$("#tipo").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/competencia_carreracompetencia_detalle.php?action=ajax&page='+page+'&q='+q+'&idCarrera=' + carrera +'&idCarreraCompetencia=' + idCarreraCompetencia+'&idTipo='+elegido,
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
		$('.addCC').click(function(){
            load(1);
        })
        })

		$(document).ready(function(){
			var carreracompetencia= $("#idCarreraCompetencia").val();
			$.ajax({
					type: "POST",
						url: "./ajax/agregar_carreracompetencia2.php",
						data: "idCarreraCompetencia="+carreracompetencia,
						success: function(datos){
						$("#resultados").html(datos);
						}
					})
			})
</script>



<script type = "text/javascript">
$('#myModal').on('hidden.bs.modal', function(){
		$(this).find('form')[0].reset(); //para borrar todos los datos que tenga los input, textareas, select.
		/*$("label.error").remove(); */ //lo utilice para borrar la etiqueta de error del jquery validate
	});
</script>

<!-- <script type="text/javascript">
	function editCompetencia(idCarrera,idCarreraCompetencia,fAprobacion){
		// alert('entra');

		fAprobacion = $("#fAprobacion").val();

		$.ajax({
			type: 'POST',
			url: 'carreracompetenciaEditar.php',
			data:"&idCarrera="+idCarrera+"&idCarreraCompetencia="+idCarreraCompetencia+'&fAprobacion='+fAprobacion,
		});

		if ( ($("#idResultC").val()) == 2){
			alert("Registro actualizado correctamente.");
			window.location = "carreraog.php";
		}
	}
</script> -->
