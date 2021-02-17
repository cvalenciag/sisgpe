<?php
  require_once 'connect.php';

  $idEvaluacion = $_REQUEST['idEvaluacion'];

  $qryResultadosEval = $conn->query("SELECT idEvaluacion, e.idDpto, d.descripcion AS nomDepto, e.idCurso, nombreCurso, e.idTipoeval, te.descripcion AS nomTipoEval, e.idModal, e.fechaEvaluacion, idGrupoAlumno, semestre FROM evaluacion e
  -- LEFT JOIN carrera cc ON (cc.idCarrera=e.idCarrera)
  LEFT JOIN departamento d ON (d.idDepartamento = e.idDpto)
  LEFT JOIN curso c ON (c.idCurso = e.idCurso)
  LEFT JOIN tipo_evaluacion te ON (te.idTipoEval = e.idTipoeval) WHERE idEvaluacion='$idEvaluacion'") or die(mysqli_error($conn));
	$resQryREval = $qryResultadosEval->fetch_array();

  $idDepartamento = $resQryREval['idDpto'];
  $idCurso        = $resQryREval['idCurso'];
  // $idCarrera      = $resQryREval['idCarrera'];
?>

<div class="col-lg-2"></div>
<div class="col-lg-6">
  <!-- <div class="form-group">
    <label>Carrera:</label><br/>
    <select name="idCarrera" id="idCarrera" required = "required" disabled>
      <option value="" selected="selected">Seleccione una opción</option>
      <?php
      $qryCarreras = $conn->query("SELECT * FROM carrera WHERE estado=1 ORDER BY nombreCorto") or die(mysqli_error($conn));

      while ($resCarreras = $qryCarreras->fetch_array()) {
        $selected = '';
        if($resQryREval['idCarrera'] == $resCarreras['idCarrera']){
          $selected = 'selected=selected';
        }
      ?>
        <option value="<?php echo $resCarreras['idCarrera'] ?>" <?php echo $selected ?>>
          <?php echo $resCarreras['descripcion'] ?>
        </option>
      <?php
      }
      ?>
    </select>
  </div> -->

  <div class="form-group">
    <label>Departamento Académico:</label><br/>
    <select name="depAcad" id="idDepAcad" required = "required" disabled>
      <?php
      $qryDepAcad = $conn->query("SELECT * FROM departamento WHERE estado=1") or die(mysqli_error($conn));

      while ($resQryAcad = $qryDepAcad->fetch_array()) {
        $selected = '';
        if($resQryREval['idDpto'] == $resQryAcad['idDepartamento']){
          $selected = 'selected=selected';
        }

      ?>
        <option value="<?php echo $resQryAcad['idDepartamento'] ?>" <?php echo $selected ?> >
          <?php echo $resQryAcad['descripcion'] ?>
        </option>
      <?php
      }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label>Curso:</label><br/>
    <select name="idCurso" id="idCurso" required = "required" disabled>
      <?php
      $qryCourse = $conn->query("SELECT * FROM curso WHERE estado=1 AND idDepartamento='$idDepartamento' ") or die(mysqli_error($conn));

      while ($resQryCourse = $qryCourse->fetch_array()) {
        $selected = '';
        if($resQryREval['idCurso'] == $resQryCourse['idCurso']){
          $selected = 'selected=selected';
        }
      ?>
        <option value="<?php echo $resQryCourse['idCurso'] ?>" <?php echo $selected ?> >
          <?php echo $resQryCourse['nombreCurso'] ?>
        </option>
      <?php
      }
      ?>
    </select>
  </div>


  <div class="form-group">
    <label>Tipo de evaluación:</label><br/>
    <select name="idTipoEval" id="idTipoEval" required="required" disabled>
      <?php
      $qryTipoEv = $conn->query("SELECT * FROM tipo_evaluacion WHERE estado=1") or die(mysqli_error($conn));

      while ($resTipoEv = $qryTipoEv->fetch_array()) {
        $selected = '';
        if($resQryREval['idTipoeval'] == $resTipoEv['idTipoEval']){
          $selected = 'selected=selected';
        }
      ?>
        <option value="<?php echo $resTipoEv['idTipoEval'] ?>" <?php echo $selected ?> >
          <?php echo $resTipoEv['descripcion'] ?>
        </option>
      <?php
      }
      ?>
    </select>
  </div>


  <div class="form-group">
    <label>Modalidad:</label><br/>
    <select name="idModalidad" id="idModalidad" required="required" disabled>
      <?php
        if($resQryREval['idModal']==1) {
          echo '<option value="1" selected=selected>Escrito</option>';
          echo '<option value="2">Oral</option>';
        } else {
          echo '<option value="1">Escrito</option>';
          echo '<option value="2" selected = selected>Oral</option>';
        }
      ?>
    </select>
  </div>

  <div class="form-group">
    <label>Fecha de evaluación:</label><br/>
    <input type="date" name="fechaEval" id="fechaEval" value="<?php echo $resQryREval['fechaEvaluacion'] ?>" disabled/>
  </div>

  <div class="form-group">
    <label>Semestre:</label><br/>
    <select name="idSemestre" id="idSemestre">
      <?php
        $añoAct = date("Y");
        $añoAnt = date('Y', strtotime("$añoAct -1 year") );

        $an1 = $añoAnt.'-1';
        $an2 = $añoAnt.'-2';
        $ac1 = $añoAct.'-1';
        $ac2 = $añoAct.'-2';

        $semestre =  $resQryREval['semestre'];

        if($semestre == $an1){
      ?>
          <option value="<?php echo $an1 ?>" selected="selected"> <?php echo $an1 ?> </option>
          <option value="<?php echo $an2 ?>"><?php echo $an2 ?></option>
          <option value="<?php echo $ac1 ?>"><?php echo $ac1 ?></option>
          <option value="<?php echo $ac2 ?>"><?php echo $ac2 ?></option>
      <?php
        }else if($semestre == $an2){
      ?>
          <option value="<?php echo $an1 ?>"><?php echo $an1 ?> </option>
          <option value="<?php echo $an2 ?>" selected="selected"><?php echo $an2 ?></option>
          <option value="<?php echo $ac1 ?>"><?php echo $ac1 ?></option>
          <option value="<?php echo $ac2 ?>"><?php echo $ac2 ?></option>
      <?php
        }else if($semestre == $ac1){
      ?>
          <option value="<?php echo $an1 ?>"><?php echo $an1 ?> </option>
          <option value="<?php echo $an2 ?>"><?php echo $an2 ?></option>
          <option value="<?php echo $ac1 ?>" selected="selected"><?php echo $ac1 ?></option>
          <option value="<?php echo $ac2 ?>"><?php echo $ac2 ?></option>
      <?php
        }else {
      ?>
          <option value="<?php echo $an1 ?>"><?php echo $an1 ?> </option>
          <option value="<?php echo $an2 ?>"><?php echo $an2 ?></option>
          <option value="<?php echo $ac1 ?>"><?php echo $ac1 ?></option>
          <option value="<?php echo $ac2 ?>" selected="selected"><?php echo $ac2 ?></option>
      <?php
        }
      ?>


    </select>
  </div>

  <div class="form-group">
    <label>Nombre de proyecto:</label><br/>
    <select name="idGrupoAlum" id="idGrupoAlum">
      <?php
        $idGpoAlum = $resQryREval['idGrupoAlumno'];

        $qryGrupos = $conn->query("SELECT * FROM grupoAlumno WHERE estado=1") or die(mysqli_error($conn));

        foreach ($qryGrupos as $gpos)
        {
          $selected = '';
          if($resQryREval['idGrupoAlumno'] == $gpos['idGrupoAl']){
            $selected = 'selected=selected';
          }
        ?>
          <option value="<?php echo $gpos['idGrupoAl'] ?>" <?php echo $selected ?> >
            <?php echo $gpos['descripcion'] ?>
          </option>
        <?php
        }
      ?>
    </select>
  </div>

  <!-- Carga los datos ajax -->
  <div id="resultados" class='col-md-12' style="margin-top:10px"></div>

  <div class="form-group">
    <button id="btnRegistrar" class="btn btn-primary" name="" onclick="updateEval();">
      <span class="glyphicon glyphicon-save"></span> Guardar cambios
    </button>
  </div>
</div>
<div class="col-lg-2">
  <br><br><br>

  <div class="form-group">
    <label>Rúbrica:</label><br/>
    <select name="idRubrica" id="idRubrica" required="required">
      <?php
      $qryRubrica = $conn->query("SELECT * FROM rubrica WHERE estado=1 AND idCurso='$idCurso' GROUP BY idCurso, fechaAprobacion") or die(mysqli_error($conn));

      while ($resRubrica = $qryRubrica->fetch_array()) {
        $selected = '';
        if($resQryREval['idRubrica'] == $resRubrica['idRubrica']){
          $selected = 'selected=selected';
        }
      ?>
        <option value="<?php echo $resRubrica['fechaAprobacion'] ?>" <?php echo $selected ?> >
          <?php echo $resRubrica['fechaAprobacion'] ?>
        </option>
      <?php
      }
      ?>
    </select>
  </div>

  <br><br><br>
  <div class="form-group">
    <button type="button" class="btn btn-md btn-warning" id="editEvaluadores" value="1" onclick="showModalEval();">
      <span class="glyphicon glyphicon-plus"></span> Agregar Evaluadores
    </button>
  </div>

  <div id="resultEvaluadores" class='col-md-12' style="margin-top:10px">
    <?php
    $qryValores = $conn->query("SELECT * FROM detalle_evaluacion WHERE idEvaluacion='$idEvaluacion'") or die (mysqli_error($conn));

    if($qryValores->num_rows>0)
    {
    ?>
    <table class="table table-bordered" style="width:100%;">
      <thead>
        <tr class="alert-info">
          <th class="text-center">Nombre</th>
          <th class="text-center">Apellido</th>
          <th class="text-center"></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $qryEval = $conn->query("SELECT de.idEvaluador, nomEvaluador, apeEvaluador FROM detalle_evaluacion de
            LEFT JOIN evaluador e ON (e.idEvaluador=de.idEvaluador) WHERE idEvaluacion=$idEvaluacion
            GROUP BY de.idEvaluador") or die(mysqli_error($conn));

          foreach ($qryEval as $evals)
          {
        ?>
      <tr>
        <td><?php echo $evals['nomEvaluador'] ?></td>
        <td><?php echo $evals['apeEvaluador'] ?></td>
        <td class="text-center">
          <button type="button" name="button" class="btn btn-danger btn-sm" title="Elimina Evaluador" onclick="deleteEvaluador2(<?php echo $evals['idEvaluador'] ?>,<?php echo $idEvaluacion ?> );">
            <span class="glyphicon glyphicon-trash"></span>
          </button>
        </td>
      </tr>
        <?php
          }
        ?>
      </tbody>
    </table>
    <?php
    }
    ?>
  </div>

  <br><br><br><br>
  <div class="form-group">
    <button type="button" class="btn btn-md btn-success" id="showDetalles" onclick="showDetalles();">Ver Detalles</button>
  </div>
</div>

<input type="hidden" name="" value="<?php echo $idEvaluacion ?>" id="idEvaluacion">
<div class="modal fade" id="modalAddEvaluadores" role="dialog" tabindex="-2"></div>
<div class="modal fade" id="modalVerAlumnos" role="dialog" tabindex="-2"></div>


<script type="text/javascript">
  function updateEval(){

    idEvaluacionEdit = $('#idEvaluacion').val();
    semestreEdit  = $('#idSemestre').val();
    grupoEdit     = $('#idGrupoAlum').val();
    rubricaEdit   = $('#idRubrica').val();


    $.ajax({
      type: 'POST',
    	url: 'gEvaluacionGrabar.php',
    	data: 'idEvaluacionE='+idEvaluacionEdit+'&semestreE='+semestreEdit+'&idRubricaE='+rubricaEdit+'&idGrupoAlumE='+grupoEdit+'&updateEval=u',

    	beforeSend: function(objeto){
    	  $("#resultados").html("Mensaje: Cargando...");
    	},

    	success: function(datos){
    		$("#resultados").html(datos);
    	}
    });

  } 



  function deleteEvaluador2(idEvaluador, idEvaluacion){
		$.ajax({
			type: 'POST',
			url: 'gEvaluacionEliminar.php',
			data: '&idEvaluacionD='+idEvaluacion+'&idEvaluadorD='+idEvaluador+'&deleteEvalEdit=de',

			beforeSend: function(objeto){
				$("#resultEvaluadores").html("Mensaje: Cargando...");
			},

			success: function(datos){
				$("#resultEvaluadores").html(datos);
			}

		}); //LLAVE AJAX
	}
</script>
