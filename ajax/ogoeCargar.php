<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT o.idOgOe, c.idTipo, og.idObjgeneral ,c.idCompetencia ,o.fAprobacion,o.estado FROM og_oe o, objgeneral og ,competencia c where o.idObjgeneral=og.idObjgeneral and c.idCompetencia=og.idCompetencia and o.estado='1' and o.idOgOe = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-1"></div>
<div class = "col-lg-11">
 <?php
                                                    include("modal/buscar_oe.php");


                                                ?>
	<form method = "POST" action = "ogoeEditar.php?idOgOe=<?php echo $fedit_admin['idOgOe']?>" enctype = "multipart/form-data">

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
									<label>Fecha de aprobación:</label>
									<input type = "date" name = "fAprobacion"  required = "required" value="<?php echo $fedit_admin['fAprobacion'];?>" class = "form-control"/>
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



                                                                <button type="button" class="btn btn-default addOE" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Objetivos específicos
						</button>

                                                                <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->

		<div class = "form-group">
			<button class = "btn btn-warning" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar Cambios</button>
		</div>
	</form>
</div>
<!--<script type="text/javascript" src="js/nuevo_reg_ogoe.js"></script>-->

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
</script>
