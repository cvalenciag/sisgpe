<?php
	require_once 'connect.php';
	$session_id= $_SESSION['session_id'];
	$qedit_admin = $conn->query("SELECT o.idOgOe, c.idTipo, og.idObjgeneral ,c.idCompetencia ,o.fAprobacion,o.estado, d.idObjespecifico FROM og_oe o, objgeneral og ,competencia c, detalle_og_oe d where o.idOgOe=d.idOgOe AND o.idObjgeneral=og.idObjgeneral and c.idCompetencia=og.idCompetencia and o.estado='1' and o.idOgOe = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
 <?php
     include("modal/buscar_oe.php");
?>
	<form method = "POST" action = "ogoeEditar.php?idOgOe=<?php echo $fedit_admin['idOgOe']?>&idObjespecifico=<?php echo $fedit_admin['idObjespecifico'] ?>" enctype = "multipart/form-data">

          <div class = "form-group">
                                                <label>Tipo de competencia:</label><br/>
						<select name = "idTipoCompetencia" id = "tipocompetencia" required = "required">
							<?php
								$qborrow = $conn->query("SELECT idTipo,descripcion FROM tipocompetencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                     $selected="";
                                                                    if($fedit_admin['idTipo'] == $fborrow['idTipo'])
                                                                        $selected = "selected=selected";
							?>
								<option value = "<?php echo $fborrow['idTipo']?>" <?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
								</div>

        <div class = "form-group">
                                                <label>Competencia:</label><br/>
						<select name = "idCompetencia" id = "competencia" required = "required">
							<?php
								$qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                     $selected="";
                                                                    if($fedit_admin['idCompetencia'] == $fborrow['idCompetencia'])
                                                                        $selected = "selected=selected";
							?>
								<option value = "<?php echo $fborrow['idCompetencia']?>" <?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>

						</select>
        </div>

         <div class = "form-group">
                                                <label>Objetivo general:</label><br/>
						<select name = "idObjgeneral" id = "objgeneral" required = "required">
							<?php
								$qborrow = $conn->query("SELECT idObjgeneral,definicion FROM objgeneral where estado=1 ORDER BY definicion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                     $selected="";
                                                                    if($fedit_admin['idObjgeneral'] == $fborrow['idObjgeneral'])
                                                                        $selected = "selected=selected";
							?>
								<option value = "<?php echo $fborrow['idObjgeneral']?>" <?php echo $selected?>><?php echo substr($fborrow['definicion'],0,80).'...'?></option>
							<?php
								}
							?>

						</select>
        </div>

        <div id = "definicion"></div>

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

                           <input type="hidden" id="idOgOe" name="idOgOe" value="<?php echo $fedit_admin['idOgOe'];?>"/>
                          <button type="button" class="btn btn-info addOE" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Objetivos específicos
						</button>

                       <div id="resultados" style="margin-top:10px"></div><!-- Carga los datos ajax -->

		<div class = "form-group">
			<button class = "btn btn-warning" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar</button>
		</div>
	</form>
</div>
<script type="text/javascript" src="js/nuevo_reg_ogoe.js"></script>
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
			var objgeneral= $("#objgeneral").val();
			var idOgOe= $("#idOgOe").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/oe_ogoe_detalle.php?action=ajax&page='+page+'&q='+q+'&idObjgeneral=' + objgeneral +'&idOgOe=' + idOgOe,
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
		$('.addOE').click(function(){
            load(1);
        })
        })

		$(document).ready(function(){
			/*var objgeneral= $("#objgeneral").val();*/
			var ogoe= $("#idOgOe").val();
			$.ajax({
					type: "POST",
						url: "./ajax/agregar_ogoe2.php",
						data: "idOgOe="+ogoe,
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
