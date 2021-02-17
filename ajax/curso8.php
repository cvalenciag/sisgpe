<?php
require_once '../valid.php';
 ?>

<link rel = "stylesheet" type = "text/css" href = "../css/bootstrap.css" />
<link rel = "stylesheet" type = "text/css" href = "../css/jquery.dataTables.css" />
		
				
					
					<div id = "admin_table">
                                        
                                    
						<table id = "table" class = "table table-bordered table-hover">
							<thead class = "alert-info">
								<tr>
									<th >Curso</th>
                                                                        <th>Código UP</th>
                                                                        <th>Tipo curso</th>
									<th>Departamento académico</th>
									<th>Ciclo</th>
                                <th>Obligatoriedad</th>
                                <th>AoL</th>
                                                                    
                                                                        <th>Agregar</th>		
								</tr>
							</thead>
							<tbody>
							<?php
							 
								$q_admin = $conn->query("select * from curso where estado ='1' order by nombreCurso asc") or die(mysqli_error($conn));
								while($row = $q_admin->fetch_array()){
                                                                    $idCurso=$row['idCurso'];
                                                                    $codUpCurso=$row['codUpCurso'];
                                                                    $nombreCurso=$row['nombreCurso'];
                                                                    $tipoCurso=$row["tipoCurso"];
                                                                    $idDepartamento = $row["idDepartamento"];
                                                                    $sql=$conn->query("select * from tmp where idCurso= '" .$idCurso . "' and idCarrera= '" .$idCarrera . "' and idSession='".$session_id."'");
					$fila2 = $sql->fetch_assoc();
                                    
					if ($sql->num_rows>0){
						$var = "btn btn-danger";
						$ciclo = $fila2["ciclo"];
						$aol = $fila2["aol"];
						$obligatorio = $fila2["obligatorio"];
					} else {
						$var ="btn btn-success";
						$ciclo="";
						$aol="";
						$obligatorio="";
					}
                                                                $result = $conn->query("SELECT descripcion FROM departamento where idDepartamento = '" . $idDepartamento . "'");
                                                                $fila = $result->fetch_assoc();
							?>	
								<tr class = "target">
                                                                          <td><?php echo $nombreCurso?></td>                                                  
									<td><?php echo $codUpCurso?></td>
									<td><?php echo ($tipoCurso==1) ? "Académico" : "Para-académico"?></td>
									<td><?php echo $fila['descripcion']?></td>
									<td class='col-xs-1'>                           
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="ciclo_<?php echo $idCurso; ?>"  value="" >
						</div>
                                                </td>
                                                
                                                
						<td class='col-xs-2'>
						<div class="pull-right">
						<select name = "obligatorio_<?php echo $idCurso; ?>" id = "obligatorio_<?php echo $idCurso; ?>" required = "required">
						<option value = "" selected = "selected">Seleccione</option>
							<option value = "1">Obligatorio</option>
							<option value = "2">Electivo</option>
						</select>
						</div>
						</td>
                                                
                                                
                                                <td class='col-xs-1'>                           
						<div class="pull-right">
						<select name = "aol_<?php echo $idCurso; ?>" id = "aol_<?php echo $idCurso; ?>" required = "required">
						<option value = "" selected = "selected">Seleccione</option>
							<option value = "1">Si</option>
							<option value = "0">No</option>
						</select>
						</div>
						</td>
									
									<td>
                                                                      
	
                                                               <a id="agregaCurso_<?php echo $idCurso; ?>" class="<?php echo $var;?> href="#" onclick="agregar()"><i class="glyphicon glyphicon-plus"></i></a>
									
									</td>									
								
									                          
								
																	
								</tr>
							<?php
								}
							?>	
							</tbody>
						</table>
					</div>
					
		
		   <script src = "https://code.jquery.com/jquery-3.3.1.js"></script>
            <script src = "../js/bootstrap.js"></script>
            <script src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
            
	<script type = "text/javascript">
	$(document).ready(function() {
    $('#table').DataTable( {
	"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Bfrtip',
		lengthMenu: [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Mostrar todos' ]],
    } );
    
} );
</script>
                