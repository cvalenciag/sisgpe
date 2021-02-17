<?php
	require_once 'valid.php';
	$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
	$fechaPerfil = (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';
	$idCurso = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
		$qfila = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera'") or die(mysqli_error($conn));
		$fcarre = $qfila->fetch_assoc();
		
		$qfila2 = $conn->query("SELECT c.nombreCurso, dm.ciclo FROM curso c, detalle_malla dm where c.idCurso=dm.idCurso and c.estado=1 and c.idCurso='$idCurso'") or die(mysqli_error($conn));
		$fcurso = $qfila2->fetch_assoc();
?>	
<!DOCTYPE html>
<html lang = "eng">
	<?php require("head.php"); ?>
		<div class = "container-fluid">
			<?php require("menu.php"); ?>
			<div class = "col-lg-1"></div>
			<div class = "col-lg-9 well" style = "margin-top:110px;background-color:#fefefe;">
				<div class = "alert alert-jcr">Por Carrera / Curso</div>
					<button id = "btnVolver" type = "button" style = "float:right;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button>
					<br />					
					 <div class = "form-group">	
                         Malla curricular de la Carrera: <label>  <?php echo $fcarre['descripcion'];?></label>           						
					</div>
					<div class = "form-group">
					Curso: <label><?php echo $fcurso['nombreCurso'];?></label><br/>
					Ciclo: <label><?php echo $fcurso['ciclo'];?></label>
						</div>
					<div class = "form-group">	
                     Fecha Perfil: <label><?php echo $fechaPerfil;?></label>           						
					</div>
					<br />
					
					<div id = "admin_table">
                                        <form id = "formPerfil" method = "POST" action = "perfilEgresadoGrabar.php" enctype = "multipart/form-data">	
                                                        <input type="hidden" name="idCarrera" value="<?php echo $idCarrera?>"/>
                                                        <input type="hidden" name="idCurso" value="<?php echo $idCurso?>"/>
                                                        <input type="hidden" name="fAprobacion" value="<?php echo $fechaPerfil?>"/>
						<table id = "tableReporte2" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>								
									<th width="10%">Tipo competencia</th>
									<th width="5%"></th>
									<th width="20%">Competencia</th>
									<th width="10%">Tipo de Objetivo de Aprendizaje</th>
									<th width="5%"></th>
									<th width="25%">Objetivos de aprendizaje</th>
									<th width="10%">Tipo de aporte</th>		
								</tr>
							</thead>
							<tbody>
							<?php
                                                        
/*							
SELECT cc.fAprobacion as fechaCC, dcc.idCarrera, dcc.idCompetencia
FROM carrera_competencia cc 
INNER JOIN detalle_carrera_competencia dcc
ON cc.idCarreraCompetencia=dcc.idCarreraCompetencia
fechaCC
idCarrera
idCompetencia
2019-01-13
19
40
2019-01-13
19
43
2019-01-13
19
49
2019-01-13
19
51
2019-01-13
19
53


SELECT cc.fAprobacion as fechaCO, dcc.idCarrera, dcc.idObjgeneral
FROM carrera_og cc 
INNER JOIN detalle_carrera_og dcc
ON cc.idCarreraOg=dcc.idCarreraOg


fechaCO
idCarrera
idObjgeneral
2019-01-10
19
66


SELECT cc.fAprobacion as fechaOG, dcc.idObjgeneral, dcc.idObjespecifico
FROM og_oe cc 
INNER JOIN detalle_og_oe dcc
ON cc.idOgOe=dcc.idOgOe

------------------------------------
$q_admin = $conn->query("SELECT c.idCurso as destico, c.nombreCurso as descom, c.idDepartamento as OGeneral, c.tipoCurso as OEspecifico FROM curso c, malla m, 
detalle_malla dm where m.idMalla = dm.idMalla and dm.idCurso = c.idCurso") or die(mysqli_error($conn));
*/
								
/*$q_admin = $conn->query("SELECT distinct tc.descripcion as destico, c.descripcion as descom, og.definicion as OGeneral, oe.definicion as OEspecifico FROM detalle_carrera_competencia dcc,
 competencia c, tipocompetencia tc, detalle_carrera_og dcog, objgeneral og, detalle_og_oe dge, objespecifico oe, carrera_competencia cc, carrera_og cog, og_oe ge where cc.idCarrera=dcc.idCarrera 
 and dcc.idCompetencia=c.idCompetencia and c.idtipo=tc.idtipo and dcog.idObjgeneral=og.idObjgeneral and dge.idObjespecifico=oe.idObjespecifico and cc.fAprobacion='$fechaPerfil' 
 and cog.fAprobacion='$fechaPerfil' and ge.fAprobacion='$fechaPerfil'order by tc.idTipo, c.descripcion, ogeneral, oespecifico") or die(mysqli_error($conn)); */
 
 
/*$q_admin = $conn->query("SELECT DISTINCT tc.descripcion as tipcom, dcc.ordenamiento as ordcom, c.descripcion as descom, dcog.ordenamiento as ordog, og.definicion as defog, 
dge.ordenamiento as ordoe, oe.definicion as defoe from carrera_competencia cc INNER JOIN detalle_carrera_competencia dcc INNER JOIN competencia c ON dcc.idCompetencia=c.idCompetencia 
INNER JOIN og_oe ge ON dcc.idCompetencia=ge.idCompetencia INNER JOIN detalle_og_oe dge ON ge.idObjgeneral=dge.idObjgeneral INNER JOIN detalle_carrera_og dcog ON dge.idobjgeneral=dcog.idobjgeneral 
INNER JOIN tipocompetencia tc ON c.idTipo=tc.idTipo INNER JOIN objgeneral og ON dge.idObjgeneral=og.idObjgeneral INNER JOIN objespecifico oe ON dge.idObjespecifico=oe.idObjespecifico, 
carrera_og cog WHERE (cc.fAprobacion='$fechaPerfil' and cog.fAprobacion='$fechaPerfil' and ge.fAprobacion='$fechaPerfil' and cc.idCarrera=$idCarrera)
") or die(mysqli_error($conn));*/



$q_admin = $conn->query("SELECT DISTINCT tc.idTipo, tc.descripcion as tipcom, dcc.ordenamiento as ordcom, c.idCompetencia, c.descripcion as descom from carrera_competencia cc 
INNER JOIN detalle_carrera_competencia dcc INNER JOIN competencia c ON dcc.idCompetencia=c.idCompetencia 
INNER JOIN tipocompetencia tc ON c.idTipo=tc.idTipo INNER JOIN og_oe ge ON ge.idCompetencia=c.idCompetencia 
INNER JOIN detalle_carrera_og dcog ON ge.idObjgeneral=dcog.idObjgeneral, carrera_og cog WHERE cc.fAprobacion='$fechaPerfil' and cog.fAprobacion='$fechaPerfil' 
and ge.fAprobacion='$fechaPerfil' AND cc.idCarrera='$idCarrera' order by ordcom") or die(mysqli_error($conn));

                                            
                                            while($f_admin = $q_admin->fetch_array()){ //inicio while1
                                                        
									
							?>	
								<tr class = "target">                                                               
									
									<td><?php echo $f_admin['tipcom']?>
                                                                        <input type="hidden" name="tipcom[]" value="<?php echo $f_admin['idTipo']?>"/></td>
									<td><?php echo $f_admin['ordcom']?></td>
									<td><?php echo $f_admin['descom']?>
                                                                        <input type="hidden" name="descom[]" value="<?php echo $f_admin['idCompetencia']?>"/></td>
        <?php
           $q_admin1 = $conn->query("SELECT DISTINCT dcog.ordenamiento as ordog, og.definicion as desog,dcog.idObjgeneral from carrera_competencia cc 
            INNER JOIN detalle_carrera_competencia dcc 
            INNER JOIN competencia c ON dcc.idCompetencia=c.idCompetencia 
            INNER JOIN tipocompetencia tc ON c.idTipo=tc.idTipo 
            INNER JOIN og_oe ge ON ge.idCompetencia=c.idCompetencia 
            INNER JOIN detalle_carrera_og dcog ON ge.idObjgeneral=dcog.idObjgeneral 
            INNER JOIN objgeneral og ON dcog.idObjgeneral=og.idObjgeneral, carrera_og cog 
            WHERE cc.fAprobacion='$fechaPerfil' and cog.fAprobacion='$fechaPerfil' and ge.fAprobacion='$fechaPerfil' AND cc.idCarrera='$idCarrera' order by dcc.ordenamiento, ordog") or die(mysqli_error($conn));
            while($f_admin1 = $q_admin1->fetch_array()){ //inicio while2
            
        ?>                                
																 <tr> 
                                                                        <td></td>
                                                                        <td></td>
																		<td></td>
																		<td>General</td>
																		<td><?php echo $f_admin1['ordog']?> </td>
																		<td><?php echo $f_admin1['desog']?>
                                                                                                                                                <input type="hidden" name="desog[]" value="<?php echo $f_admin1['idObjgeneral']?>"/> </td>
																		 <td>

																			<div class = "form-group">
			                                                
																				<select name = "aporte[]" id = "aporte" required = "required">
																				<option value = "" selected = "selected">Elige un tipo de aporte</option>						
																				<option value = "1">Contribuye</option>
																				<option value = "2">Logra</option>
																				<option value = "3">Sostiene</option>
																				<option value = "4">No aplica</option>
																				</select>
																			</div>															
																		</td>		
																																				
                                                                 </tr>       
          <?php
            
            $q_admin2 = $conn->query("SELECT DISTINCT dge.ordenamiento as ordoe, oe.definicion as desoe, oe.idObjespecifico from carrera_competencia cc 
            INNER JOIN detalle_carrera_competencia dcc 
            INNER JOIN competencia c ON dcc.idCompetencia=c.idCompetencia INNER JOIN tipocompetencia tc ON c.idTipo=tc.idTipo 
            INNER JOIN og_oe ge ON ge.idCompetencia=c.idCompetencia INNER JOIN detalle_carrera_og dcog ON ge.idObjgeneral=dcog.idObjgeneral 
            INNER JOIN objgeneral og ON dcog.idObjgeneral=og.idObjgeneral INNER JOIN detalle_og_oe dge ON dcog.idObjgeneral=dge.idObjgeneral 
            INNER JOIN objespecifico oe ON dge.idObjespecifico=oe.idObjespecifico, carrera_og cog 
            WHERE cc.fAprobacion='$fechaPerfil' and cog.fAprobacion='$fechaPerfil' and ge.fAprobacion='$fechaPerfil' AND cc.idCarrera='$idCarrera' and dcog.idObjgeneral=$f_admin1[idObjgeneral] order by dcc.ordenamiento, dcog.ordenamiento, ordoe") or die(mysqli_error($conn));
            $i = 0;
            while($f_admin2 = $q_admin2->fetch_array()){ //inicio while3*/
        ?>                                                              
                                                                        
                                                                        <tr>
                                                                        
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
									<td>Especifico</td>									
									<td><?php echo $f_admin2['ordoe']?></td>
									<td><?php echo $f_admin2['desoe']?>
                                                                        <input type="hidden" name="desoe[]" value="<?php echo $f_admin2['idObjespecifico']?>"/></td>									
									
									<td>

										<div class = "form-group">
									
                                                
											<select name = "aporte[]" id = "aporte" required = "required">
												<option value = "" selected = "selected">Elige un tipo de aporte</option>						
												<option value = "1">Contribuye</option>
												<option value = "2">Logra</option>
												<option value = "3">Sostiene</option>
												<option value = "4">No aplica</option>
											</select>
										</div>															
									</td>
                                                                        </tr>									
								
								
							<?php
                                                         $i = $i +1;
                                                        } //fin while2
                                                        
                                                        
								} //fin while3
                                                                ?>
                                                               
                                                                
                                                                </tr>
                                                                
                                                                <?php
                                                               
                                                                } //fin while1
							?>	
							</tbody>
						</table>
                                                <br/><br/>
                                                <div class = "form-group">	
                                                    <input type="submit" class = "btn btn-primary" value="Guardar" name = "save_user" />
                                                    <!--<span class = "glyphicon glyphicon-save"></span>-->
                                                </div>
                                                <input type="hidden" name="cont" value="<?php echo $i?>"/>
                                                </form>
					</div>
					
                                
				
			</div>
		</div>
		<br />
		<br />
		<br />
		<?php require("footer.php"); ?>
		
<script type = "text/javascript">
	$(document).ready(function() {
    $('#tableReporte2').DataTable( {
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
       { width: "10%", targets: 0 },
      { width: "20%", targets: 1 },
      { width: "10%", targets: 2 },
      { width: "25%", targets: 3 },
      { width: "25%", targets: 4 },
      { width: "10%", targets: 5 },
    ],
    });
	
	$('#btnVolver').click(function(){
		window.location = 'reporte.php';
	});
	
});
</script>
</html>