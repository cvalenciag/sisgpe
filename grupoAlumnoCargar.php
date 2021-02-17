<?php
	require_once 'connect.php';
	$qedit_admin = $conn->query("SELECT * FROM grupoAlumno WHERE idGrupoAl='$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
<div class = "col-lg-6">
	<!-- <form method = "POST" action = "grupoAlumnoEditar.php?admin_id=<?php echo $fedit_admin['idGrupoAl']?>" enctype = "multipart/form-data">
		<div class = "form-group">
								<label class = "titulo">Modificar información de un grupo de alumnos.</label>
								</div> -->
	<div class = "form-group">
		<label>Nombre del grupo:</label>
		<input type="text" name="descGrupo" value="<?php echo $fedit_admin['descripcion'] ?>" required="required" maxlength="50" name="descripcion" class = "form-control" id="descGrupo">
		<!-- <textarea required = "required" maxlength = "50" rows="1" name = "descripcion" class = "form-control"></textarea> -->
	</div>

	<div class="form-group">
		<label>Semestre:</label><br/>
		<select name="idSemestre" id="idSemestre" class="form-control">
			<?php
				$añoAct = date("Y");
				$añoAnt = date('Y', strtotime("$añoAct -1 year") );

				$idSemestre = $fedit_admin['semestre'];

				$selected = '';
				if($idSemestre == $añoAnt.'-1'){
				?>
					<option value="<?php echo $añoAnt.'-1' ?>" selected='selected'><?php echo $añoAnt.'-1' ?></option>
					<option value="<?php echo $añoAnt.'-2' ?>"><?php echo $añoAnt.'-2' ?></option>
					<option value="<?php echo $añoAct.'-1' ?>"><?php echo $añoAct.'-1' ?></option>
					<option value="<?php echo $añoAct.'-2' ?>"><?php echo $añoAct.'-2' ?></option>
				<?php
				}elseif($idSemestre == $añoAnt.'-2'){
				?>
				<option value="<?php echo $añoAnt.'-1' ?>"><?php echo $añoAnt.'-1' ?></option>
				<option value="<?php echo $añoAnt.'-2' ?>" selected='selected'><?php echo $añoAnt.'-2' ?></option>
				<option value="<?php echo $añoAct.'-1' ?>"><?php echo $añoAct.'-1' ?></option>
				<option value="<?php echo $añoAct.'-2' ?>"><?php echo $añoAct.'-2' ?></option>
				<?php
				}elseif ($fedit_admin['semestre'] == $añoAct.'-1') {
				?>
				<option value="<?php echo $añoAnt.'-1' ?>"><?php echo $añoAnt.'-1' ?></option>
				<option value="<?php echo $añoAnt.'-2' ?>"><?php echo $añoAnt.'-2' ?></option>
				<option value="<?php echo $añoAct.'-1' ?>" selected='selected'><?php echo $añoAct.'-1' ?></option>
				<option value="<?php echo $añoAct.'-2' ?>"><?php echo $añoAct.'-2' ?></option>
				<?php
				}elseif ($fedit_admin['semestre'] == $añoAct.'-2') {
				?>
				<option value="<?php echo $añoAnt.'-1' ?>"><?php echo $añoAnt.'-1' ?></option>
				<option value="<?php echo $añoAnt.'-2' ?>"><?php echo $añoAnt.'-2' ?></option>
				<option value="<?php echo $añoAct.'-1' ?>"><?php echo $añoAct.'-1' ?></option>
				<option value="<?php echo $añoAct.'-2' ?>" selected='selected'><?php echo $añoAct.'-2' ?></option>
				<?php
				}
			?>
			</select>
	</div>

	<div class = "form-group">
		<label>Curso:</label><br/>
		<select name="idCurso" id="idCurso" class="form-control">
			<?php
			// $qryCursos = $conn->query("SELECT * FROM curso WHERE estado=1") or die(mysqli_error($conn));
			$qryCursos = $conn->query("SELECT
    idCurso, nombreCurso
FROM
    detalle_malla
        LEFT JOIN
    curso USING (idCurso)
WHERE
    aol = 1 AND eliminado = 0
GROUP BY idCurso
ORDER BY nombreCurso ") or die(mysqli_error($conn));

			foreach ($qryCursos as $cursos)
			{
				$selected = '';
				if($fedit_admin['idCurso'] == $cursos['idTipoEval']){
          $selected = 'selected=selected';
        }
			?>
				<option value="<?php echo $cursos['idCurso'] ?>" <?php echo $selected ?> >
					<?php echo $cursos['nombreCurso'] ?>
				</option>
			<?php
			}
			?>
		</select>
	</div>

	<div class = "form-group">
		<label>Informe adjunto:</label>
		<input type="text" name="uploadFile" value="<?php echo $fedit_admin['infAdjunto'] ?>" id="uploadFile" class="form-control" disabled>
	</div>

	<div class="form-group">
		<button type="button" class="btn btn-md btn-warning" id="addAlumnos" onclick="showModalAlumnos(2, <?php echo $fedit_admin['idGrupoAl'] ?>);">
			<span class="glyphicon glyphicon-plus"></span> Agregar alumnos
		</button>
	</div>

	<div class="form-group">
		<label>Integrantes:</label><br/>
	</div>
	<div class="" id="resultAlumnos">
		<table class="table table-bordered" style="width:100%;">
			<thead>
				<tr class="alert-info">
					<th class="text-center">Nombre</th>
					<th class="text-center">Apellido</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$idGrupoAl = $fedit_admin['idGrupoAl'];

				$qryAlumnos = $conn->query("SELECT dga.idGrupoAl, dga.idalumno, nomAlumno, apeAlumno FROM detalle_grupoAlumno dga LEFT JOIN alumno a ON(a.idAlumno=dga.idalumno) WHERE dga.idGrupoAl='$idGrupoAl' AND dga.estado=1") or die(mysqli_error($conn));

				foreach ($qryAlumnos as $alumnos)
				{
				?>
					<tr>
						<td class="text-justify" style="width:45%"><?php echo $alumnos['nomAlumno'] ?></td>
						<td class="text-justify" style="width:45%"><?php echo $alumnos['apeAlumno'] ?></td>
						<td class="text-center" style="width:10%">
							<button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Alumno" onclick="deleteAlumno2(<?php echo $alumnos['idalumno'] ?>, <?php echo $idGrupoAl ?> );">
								<span class="glyphicon glyphicon-trash"></span>
							</button>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
	</div>


	<div id="resultados" class='col-md-12' style="margin-top:10px"></div>

	<div class = "form-group">
		<button class="btn btn-primary" name="edit_user" onclick="updateRegistro(<?php echo $fedit_admin['idGrupoAl'] ?>)">
			<span class = "glyphicon glyphicon-edit"></span> Guardar cambios
		</button>
	</div>
	<!-- </form>		 -->
</div>

<script type="text/javascript">
	function updateRegistro(idGpoAl){

		descGrupo		= $('#descGrupo').val();
		idSemestre	= $('#idSemestre').val();
		idCurso			= $('#idCurso').val();

		$.ajax({
	    type: 'POST',
	  	url: 'grupoAlumnoEditar.php',
	    data: "descGrupo="+descGrupo+'&idSemestre='+idSemestre+'&idCurso='+idCurso+'&idGpoAl='+idGpoAl,

	    beforeSend: function(objeto){
	      $("#resultados").html("Mensaje: Cargando...");
	    },

	    success: function(datos){
	      $("#resultados").html(datos);
	    }

	  }); //LLAVE AJAX
	}


	function deleteAlumno2(idAlumno, idGpoAl){

		$.ajax({
			type: 'POST',
			url: 'grupoAlumnoEliminar.php',
			data: '&xIdGrupoAl='+idGpoAl+'&xIdAlumno='+idAlumno+'&delDetalle=dd',

			beforeSend: function(objeto){
				$("#resultAlumnos").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultAlumnos").html(datos);
			}

		}); //LLAVE AJAX
	}
</script>
