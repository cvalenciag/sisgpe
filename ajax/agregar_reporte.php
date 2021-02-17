<?php
require_once '../valid.php';
$idCarrera = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$obligatorio = (isset($_REQUEST['obligatorio']) && !empty($_REQUEST['obligatorio']))?$_REQUEST['obligatorio']:'';
$idDpto = (isset($_REQUEST['idDpto']) && !empty($_REQUEST['idDpto']))?$_REQUEST['idDpto']:'';
$fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';

if (isset($_POST['elegido8']))//fechaMalla
	{
		$elegido8 = $_POST['elegido8'];
		$qborrow = $conn->query("SELECT fAprobacion FROM malla where estado=1 and eliminado=0 and idCarrera='$elegido8'") or die(mysqli_error($conn));
		echo "<option value = '' selected = 'selected'>Todos</option>";			
		while($fborrow = $qborrow->fetch_array()){							
			echo "<option value = '". $fborrow['fAprobacion'] ."'>". $fborrow['fAprobacion'] . "</option>";
			}
	}

	if (isset($_POST['elegido9']))//fechaPerfil
	{
		$elegido9 = $_POST['elegido9'];
		$qborrow = $conn->query("SELECT cc.fAprobacion from carrera_competencia cc INNER JOIN carrera_og cog ON cc.fAprobacion=cog.fAprobacion INNER JOIN og_oe oge ON cog.fAprobacion=oge.fAprobacion where cc.idCarrera='$elegido9'") or die(mysqli_error($conn));
		echo "<option value = '' selected = 'selected'>Todos</option>";		
		while($fborrow = $qborrow->fetch_array()){							
			echo "<option value = '". $fborrow['fAprobacion'] ."'>". $fborrow['fAprobacion'] . "</option>";
			}
	}

	
								
								$sWhere = "";
		
		
								if ( $idCarrera != ""  && $fechaMalla != "" && $obligatorio == '' && $idDpto == '')
								{
									$sWhere = "and m.idCarrera = '$idCarrera' and m.fAprobacion='$fechaMalla'";
									
								}
								
								elseif ( $idCarrera != ""  && $fechaMalla != "" && $obligatorio == '' && $idDpto != '')
								{
									$sWhere = "and m.idCarrera = '$idCarrera' and m.fAprobacion='$fechaMalla' and c.idDepartamento = '$idDpto'";
								}
								
								elseif ( $idCarrera != ""  && $fechaMalla != "" && $obligatorio != '' && $idDpto == '')
								{
									$sWhere = "and m.idCarrera = '$idCarrera' and m.fAprobacion='$fechaMalla' and dm.obligatoriedad = '$obligatorio'";
								}
								elseif ( $idCarrera != ""  && $fechaMalla != "" && $obligatorio != '' && $idDpto != '')
								{
									$sWhere = "and m.idCarrera = '$idCarrera' and m.fAprobacion='$fechaMalla' and dm.obligatoriedad = '$obligatorio' and c.idDepartamento = '$idDpto'";
								}
								else
								{
									$sWhere = " ";
								}
                

								$q_admin = $conn->query("SELECT c.idCurso, c.nombreCurso, dm.ciclo, c.idDepartamento, c.tipoCurso, dm.aol FROM curso c, malla m, detalle_malla dm where m.idMalla = dm.idMalla and dm.idCurso = c.idCurso $sWhere") or die(mysqli_error($conn));
								?>
								<div id = "admin_table">
						<table id = "tableReporte" class = "table table-bordered table-hover" style="width:100%">
							<thead class = "alert-info">
								<tr>
									
									<th width="25%">Curso</th>
									<th width="10%">Ciclo</th>
									<th width="15%">Departamento académico</th>
									<th width="15%">Tipo curso</th>
									<th width="15%">Aol</th>								
                                                                        <th width="20%">Asociar Objetivos</th>		
								</tr>
							</thead>
							<tbody>

								<?php
								while($f_admin = $q_admin->fetch_array()){
								 $result = $conn->query("SELECT descripcion FROM departamento where idDepartamento = '" . $f_admin['idDepartamento'] . "'");
                                 $fila = $result->fetch_assoc();
							?>	
								<tr class = "target">                                                               
									
									<td><?php echo $f_admin['nombreCurso']?></td>
									<td><?php echo $f_admin['ciclo']?></td>
									<td><?php echo $fila['descripcion']?></td>									
									<td><?php echo ($f_admin['tipoCurso']==1) ? "Académico" : "Para-académico"?></td>
									<td><?php echo ($f_admin['aol']==1) ? "Si" : "No"?></td>
									<td>

										<div style = "float:right;">
										
										 <a href = "#" class = "btn btn-editar eadmin_id" value = "<?php echo $f_admin['idCurso']?>">
										 Objetivos de aprendizaje </a>						
										</div>																		
									</td>									
								
								</tr>
							<?php
								}
							?>
								</tbody>
						</table>
					</div>

<script type = "text/javascript">
	$(document).ready(function() {
    $('#tableReporte').DataTable( {
	retrieve: true,
	"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Lfrtip',
                columnDefs: [
      { width: "25%", targets: 0 },
      { width: "10%", targets: 1 },
      { width: "15%", targets: 2 },
      { width: "15%", targets: 3 },
      { width: "15%", targets: 4 },
      { width: "20%", targets: 5 },
     
    ],
    
    
    } );
} );
</script>
<script type = "text/javascript">
$(document).ready(function(){
$("#tableReporte").on("click", ".eadmin_id", function(){
             var admin_id = $(this).attr('value');
             var idCarrera = $("#idCarrera").val();
             var fechaPerfil = $("#fechaPerfil").val();
			window.location = 'reporte2.php?idCurso=' + admin_id + '&idCarrera=' + idCarrera + '&fechaPerfil=' + fechaPerfil;               
            })
})
</script>