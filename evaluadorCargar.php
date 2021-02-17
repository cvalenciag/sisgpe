<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT e.idEvaluador, e.dniEvaluador,e.rucEvaluador,e.nomEvaluador,e.apeEvaluador,e.relUpEvaluador,e.catEvaluador,e.idSector,e.orgaEvaluador,e.idCargo,e.descEvaluador,e.celEvaluador,e.dirEvaluador,e.correo1,e.correo2,e.nomAsistente,e.correoAsistente,e.sumillaEval,e.comentEvaluador,e.ultimaCapacitacion,e.idusuario,e.estado FROM evaluador e WHERE e.idEvaluador = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>

<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<form method = "POST" action = "evaluadorEditar.php?idEvaluador=<?php echo $fedit_admin['idEvaluador']?>" enctype = "multipart/form-data">

		<div class = "form-group">
									<label>DNI:</label>
									<input type = "text" value = "<?php echo $fedit_admin['dniEvaluador']?>" disabled="disabled" name = "dni" maxlength = "8" class = "form-control" onkeypress="return validar(event)"/>
								</div>

	<div class = "form-group">
									<label>RUC:</label>
									<input type = "text" value = "<?php echo $fedit_admin['rucEvaluador']?>" name = "ruc" maxlength = "11" class = "form-control" onkeypress="return validar(event)"/>
								</div>

								<div class = "form-group">
									<label>Nombres:</label>
									<input type = "text" value = "<?php echo $fedit_admin['nomEvaluador']?>" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "nombres" maxlength = "50"  class = "form-control" />
									</div>

									<div class = "form-group">
									<label>Apellidos:</label>
									<input type = "text" value = "<?php echo $fedit_admin['apeEvaluador']?>" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "apellidos" maxlength = "50"  class = "form-control" />
									</div>


		<div class = "form-group">
			<label>Relación con UP:</label><br/>
		 <select name = "tipoRelacion" required = "required" id = "tipoRelacion">
                         <?php
                            if($fedit_admin['relUpEvaluador']==1) {
                                echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Colaborador</option>';
                                echo '<option value = "2">Externo</option>';

                            } else {
                                 echo '<option value = "1">Colaborador</option>';
                                 echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Externo</option>';
                                  }
                            ?>
		 </select>
		</div>

		<div class = "form-group">
			<label>Categoría del evaluador:</label><br/>
		 <select name = "categoriaEval" required = "required" id = "categoriaEval">
                         <?php
                            if($fedit_admin['catEvaluador']==1) {
                                echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Docente</option>';
                                echo '<option value = "2">Especialista</option>';

                            } else {
                                 echo '<option value = "1">Docente</option>';
                                 echo '<option value =' . $fedit_admin['aol'] . 'selected = selected>Especialista</option>';
                                  }
                            ?>
		 </select>
		</div>

			<div class = "form-group">
			<label>Sector en el que labora:</label><br/>

                        <select name = "idSector" id = "sector">
							<?php
								$qborrow = $conn->query("SELECT * FROM sector ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idSector'] == $fborrow['idSector'])
                                                                        $selected = "selected=selected";

							?>
								<option value = "<?php echo $fborrow['idSector']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>

		</div>

									<div class = "form-group">
									<label>Organización actual:</label>
									<input type = "text"  value = "<?php echo $fedit_admin['orgaEvaluador']?>" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "organizacion" maxlength = "50"  class = "form-control" />
									</div>

								<div class = "form-group">
			<label>Cargo actual:</label><br/>

                        <select name = "idCargo" id = "cargo">
							<?php
								$qborrow = $conn->query("SELECT * FROM cargo ORDER BY descripcion") or die(mysqli_error($conn));
								while($fborrow = $qborrow->fetch_array()){
                                                                    $selected="";
                                                                    if($fedit_admin['idCargo'] == $fborrow['idCargo'])
                                                                        $selected = "selected=selected";

							?>
								<option value = "<?php echo $fborrow['idCargo']?>"<?php echo $selected?>><?php echo $fborrow['descripcion']?></option>
							<?php
								}
							?>
						</select>

		</div>

									<div class = "form-group">
									<label>Descripción del cargo:</label>
									<input type = "text" value = "<?php echo $fedit_admin['descEvaluador']?>" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "descripcion" rows="3" maxlength = "50"  class = "form-control" />
									</div>

									<div class = "form-group">
									<label>Celular:</label>
									<input type = "text" name = "celular" value = "<?php echo $fedit_admin['celEvaluador']?>" maxlength = "9" class = "form-control" onkeypress="return validar(event)"/>
								</div>

								<div class = "form-group">
									<label>Dirección:</label>
									<textarea rows="3" name = "direccion" class = "form-control" maxlength = "100" ><?php echo $fedit_admin['dirEvaluador']?></textarea>
									</div>

									<div class = "form-group">
									<label>Correo principal:</label>
									<input type="email" name = "correo1" value = "<?php echo $fedit_admin['correo1']?>" required ="required" class = "form-control" maxlength = "50"/>
								</div>

								<div class = "form-group">
									<label>Correo secundario:</label>
									<input type="email" name = "correo2" value = "<?php echo $fedit_admin['correo2']?>" class = "form-control" maxlength = "50"/>
								</div>

								<div class = "form-group">
									<label>Asistente:</label>
									<input type = "text" value = "<?php echo $fedit_admin['nomAsistente']?>"  onKeyUp="this.value=this.value.toUpperCase();" name = "asistente" maxlength = "50"  class = "form-control" />
									</div>

									<div class = "form-group">
									<label>Correo asistente:</label>
									<input type="email" name = "correo3" value = "<?php echo $fedit_admin['correoAsistente']?>"  class = "form-control" maxlength = "50"/>
								</div>

								<div class = "form-group">
									<label>Sumilla del evaluador:</label>
									<textarea required = "required" rows="3" name = "sumilla" class = "form-control" maxlength = "500" ><?php echo $fedit_admin['sumillaEval']?></textarea>
									</div>

									<div class = "form-group">
									<label>Comentarios sobre el evaluador:</label>
									<textarea rows="3" name = "comentarios" class = "form-control" maxlength = "500" ><?php echo $fedit_admin['comentEvaluador']?></textarea>
									</div>

									 <div class = "form-group">
									<label>Última capacitación:</label>
									<input type = "date" name = "fcapacitacion" id = "fcapacitacion" value = "<?php echo $fedit_admin['ultimaCapacitacion']?>" class = "form-control"/>
                                                                    </div>

                                                                    <div class = "form-group">
									<label>Usuario:</label><br>
									<select name = "usuario" id = "usuario" required = "required">
										<!-- <option value = "">Seleccione una opción</option> -->
										<?php
											$qborrow = $conn->query("SELECT * FROM usuario WHERE idRol=5 ") or die(mysqli_error($conn));
											while($fborrow = $qborrow->fetch_array()){

												$selected="";
												if($fedit_admin['idusuario'] == $fborrow['idUsuario'])
														$selected = "selected=selected";
										?>
											<option value = "<?php echo $fborrow['idUsuario']?>" <?php echo $selected ?>><?php echo $fborrow['username']?></option>
										<?php
											}
										?>
									</select>
									<!-- <input type = "text" value = "<?php echo $fedit_admin['user']?>" required = "required" onKeyUp="this.value=this.value.toUpperCase();" name = "usuario" maxlength = "20"  class = "form-control" /> -->
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

		<div class = "form-group">
			<button class = "btn btn-warning" name = "edit_user"><span class = "glyphicon glyphicon-edit"></span> Guardar Cambios</button>
		</div>
	</form>
</div>

<script type = "text/javascript">
function validar(e){
var expresion=/[\d\b]/;
return expresion.test(String.fromCharCode(e.which));
}
</script>
