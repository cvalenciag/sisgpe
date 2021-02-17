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
				<div class = "alert alert-jcr">Diseño curricular / Objetivos de aprendizaje</div>
					<button id = "add_admin" type = "button" class = "btn btn-primary"><span class = "glyphicon glyphicon-plus"></span> Agregar nuevo</button>
					<button id = "show_admin" type = "button" style = "display:none;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />
					<br />
					
					<div id = "admin_table">
					<label>Descargar</label>
					<?php include("modal/ver_oe2.php"); ?>
						<table id = "table" class = "table table-bordered table-hover" style="100%">
							<thead class = "alert-info">
								<tr>									
																		
									<th>Objetivo general</th>
									<th>Competencia</th>
                                    <th>Fecha de aprobación</th>
									<th>Cantidad de objetivos especificos</th>
									<th>Estado</th>						
								</tr>
							</thead>
							<tbody>
							 <?php
							  if($_SESSION['rol_id']==1)
                                                        $rol="";
                                                        else
                                                        $rol=" and o.estado=1";
								$q_admin = $conn->query("SELECT o.idOgOe, og.definicion as definicion,c.descripcion as competencia,o.fAprobacion,o.estado FROM og_oe o, objgeneral og ,competencia c where o.idObjgeneral=og.idObjgeneral and c.idCompetencia=og.idCompetencia and o.eliminado='0'".$rol) or die(mysqli_error($conn));
								while($f_admin = $q_admin->fetch_array()){
									$idOgOe = $f_admin['idOgOe'];
									$result = $conn->query("SELECT COUNT(*) total FROM detalle_og_oe where idOgOe = '" . $idOgOe . "' and eliminado='0'");
									$numReg = $result->fetch_assoc();
							?>	
								<tr class = "target">
									<td><?php echo $f_admin['definicion']?></td>
									<td><?php echo $f_admin['competencia']?></td>
									<td><?php echo $f_admin['fAprobacion']?></td>
									<td><?php echo $numReg['total'];?></td>
									<div style = "float:left;">
									<td><?php if ($f_admin['estado']==1){
									echo "Activo";
									$btnclas="btn-danger";
                                    $title="Desactivar registro";
									$estado=0;
									} 
									else {
									echo "Inactivo";
									$btnclas="btn-success";
                                    $title="Activar registro";
									$estado=1;
									}
									?>		
									</div>
									<div style = "float:right;">
									
									<a href = "#" class = "btn btn-success vadmin_id" data-toggle="modal" data-target="#veroe2" value = "<?php echo $f_admin['idOgOe']?>">
                                    <span class="glyphicon glyphicon-search" title="Ver registro"></span> </a>
									<a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idOgOe']?>">
                                    <span class = "glyphicon glyphicon-edit" title="Editar registro"></span> </a>
									<a href = "#" class = "btn <?php echo $btnclas?> deladmin_id" value = "<?php echo $f_admin['idOgOe'].'&estado='.$estado?>">
                                    <span class = "glyphicon glyphicon-off" title="<?php echo $title?>"></span> </a> 
									</div>
									</td>		 
								</tr>
							<?php
								}
							?>	
							</tbody>
						</table>
					</div>
					<div id = "edit_form"></div>
					<div id = "admin_form" style = "display:none;">
						<div class = "col-lg-3"></div>
						<div class = "col-lg-6">
                                                <?php 
                                                    include("modal/buscar_oe.php");
			
                                                ?>
							<form id = "formogoe" method = "POST" action = "ogoeGrabar.php" enctype = "multipart/form-data">	
							<div class = "form-group">	
                            <label>Tipo de competencia:</label><br/>                
						    <select name = "idTipoCompetencia" id = "tipocompetencia" required = "required">
							<option value = "" selected = "selected">Seleccione una opción</option>
							<?php
								$qborrow = $conn->query("SELECT idTipo,descripcion FROM tipocompetencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
							?>
								<option value = "<?php echo $fborrow['idTipo']?>"><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>
								</div>    
								
								 <div class = "form-group">	
                        <label>Competencia:</label><br/>                
						<select name = "idCompetencia" id = "competencia" required = "required">
							<option value = "" selected = "selected">Seleccione una opción</option>
						</select>
								</div>  
								
								 <div class = "form-group">	
                                                <label>Objetivo general:</label><br/>                
						<select name = "idObjgeneral" id = "objgeneral" required = "required">
							<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
						</select>
								</div>  



								<!-- <div class = "form-group">
									<label>Objetivo general completo:</label> -->
									<div id = "definicion"></div>
								<!-- </div> -->	
                                          
                                                                
                                                                <div class = "form-group">	
									<label>Fecha de aprobación:</label>
									<input type = "date" name = "fAprobacion"  required = "required" value="<?php echo date("Y-m-d");?>" class = "form-control"/>
                                                                    </div>
                                                                                                                                                                                                                                                                                                                                               
                                        
								<div class = "form-group">
									<label>Estado:</label><br/>
									<select name = "estado" id = "estado">                                      
							<option value = "1" selected = "selected">Activo</option>
							<option value = "0" >Inactivo</option>
						</select>			
								</div>
                                                                <input type="hidden" id="idTmp" name="idTmp" value=""/>
                                                                <button type="button" class="btn btn-default addOE" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search"></span> Agregar Objetivos específicos
						</button>
                                                                
                                                                <div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
								
								<div class = "form-group">	
									<button class = "btn btn-primary" name = "save_user"><span class = "glyphicon glyphicon-save"></span> Registrar</button>
								</div>
							</form>	
						</div>	
					</div>
			</div>
		</div>
		<br />
		<br />
		<br />

		<?php require("footer.php"); ?>
                                <script type="text/javascript" src="js/nuevo_reg_ogoe.js"></script>

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
    } );
} );
	</script>






	<script type = "text/javascript">
		$(document).ready(function(){
			$('#add_admin').click(function(){
				$(this).hide();
				$('#show_admin').show();
				$('#admin_table').slideUp();
				$('#admin_form').slideDown();
				$('#show_admin').click(function(){
				$(this).hide();
				$('#add_admin').show();
				$('#admin_table').slideDown();
				$('#formogoe')[0].reset();
				/*$('#competencia').empty();*/
				/*$('#objgeneral').empty();*/
				$('#admin_form').slideUp();
				window.location = 'ogoe.php';
				});
			});
		});
	</script>
        
	<script type = "text/javascript">
                
	$(document).ready(function(){
            
                    $('.addOE').attr("disabled", true);
                    $("#competencia").on('change', function () {
        $("#competencia option:selected").each(function () {
                        var elegido=$(this).val();
            if(elegido == "")
                    $('.addOE').attr("disabled", true);
            else
                    $('.addOE').attr("disabled", false);

            
            });
            });
            
            function load(page){
			var q= $("#q").val();
			var objgeneral= $("#objgeneral").val();
			var idOgOe= $("#idOgOe").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/oe_ogoe.php?action=ajax&page='+page+'&q='+q+'&idObjgeneral=' + objgeneral +'&idOgOe=' + idOgOe,
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
            
            
            

			//$result = $('<center><label>Activando/Desactivando registro...</label></center>');
			$("#table").on("click", ".deladmin_id", function(){
                                $admin_id = $(this).attr('value');

                                alertify.confirm("Confirmación de registro!!!", "Estás seguro que deseas eliminar el registro?",
            function(){
               alertify.success('Registro eliminado correctamente!!');
				//$(this).parents('td').empty().append($result);
				//$('.deladmin_id').attr('disabled', 'disabled');
				//$('.eadmin_id').attr('disabled', 'disabled');
				//setTimeout(function(){
					window.location = 'ogoeEliminar.php?admin_id=' + $admin_id;
				//}, 1000);
               
               
       },
       function(){
           alertify.error('Opción cancelada!!');
       }
      );
				
			});
                        
                        
			$("#table").on("click", ".vadmin_id", function(){
		    var admin_id = $(this).attr('value');
			$("#loader").fadeIn('slow');
			$.ajax({
			url:'./ajax/listaoeOg.php?idOgOe='+admin_id,
		    beforeSend: function(objeto){
			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			},
		    success:function(data){
			$(".resul_div2").html(data).fadeIn('slow');
			$('#loader').html('');	
			}
			})
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
			$('#edit_form').load('ogoeCargar.php?admin_id=' + $admin_id);
			});
		});
	</script>







</html>