<?php
require_once 'connect.php';
$qedit_admin = $conn->query("SELECT r.idRubrica, r.idCurso, c.nombreCurso, r.fechaAprobacion, r.estado
FROM rubrica r LEFT JOIN curso c USING (idCurso) WHERE r.estado=1 AND r.idRubrica='$_REQUEST[admin_id]'") or die(mysqli_error($conn));

$fedit_admin = $qedit_admin->fetch_array();
?>
<div class = "col-lg-3"></div>
  <div class = "col-lg-7">
		<div class="form-group">
      <label>Curso AoL:</label><br/>
			<select name="idCurso" id="idCurso" required="required">
        <option value="" selected="selected">Seleccione una opción</option>
			    <?php
				    $qryCursos = $conn->query("SELECT idCurso, nombreCurso FROM curso c LEFT JOIN detalle_malla dm USING(idCurso) WHERE c.estado=1 AND dm.AoL=1 AND dm.eliminado=0 GROUP BY idCurso ORDER BY nombreCurso") or die(mysqli_error($conn));

            foreach ($qryCursos as $cursos)
            {
              $selected="";
								if($cursos['idCurso'] == $fedit_admin['idCurso'])
									$selected = "selected=selected";
			    ?>
				      <option value="<?php echo $cursos['idCurso']?>" <?php echo $selected ?> ><?php echo $cursos['nombreCurso']?></option>
			    <?php
				    }
					?>
			</select>
		</div>

    <div class="form-group">
		  <label>Fecha de aprobación:</label><br/>
			<input onchange="validaFecha();" type="date" name="fAprobacion" id="fAprobacion" value="<?php echo $fedit_admin['fechaAprobacion']?>"/>
    </div>

    <div class = "form-group">
			<label>Estado:</label><br/>
				<select name="estado" id="estado">
 					<?php
						if($estado=='1') {
							echo '<option value =' . $fedit_admin['estado'] . 'selected=selected> Activo</option>';
							echo '<option value = "0">Inactivo</option>';
						} else {
							echo '<option value = "1">Activo</option>';
							echo '<option value =' . $fedit_admin['estado'] . 'selected=selected>Inactivo</option>';
						}
					?>
   			</select>
		</div>

    <!-- BOTON PARA MOSTRAR EL MODAL -->
    <div class="form-group">
      <button type="button" class="btn btn-default" id="btnAddCriterios" onclick="showModalCriterios(2, <?php echo $fedit_admin['idRubrica'] ?>);">
        <span class="glyphicon glyphicon-search"></span> Agregar Criterios
      </button>
    </div>

    <br>

    <div class="form-group" id="resultados">
      <table class="table table-bordered" style="width:100%;">
        <thead>
    			<tr class="alert-info">
    				<th class="text-center">Descripción del <br> Criterio</th>
    				<th class="text-center">Orden de <br> Criterio</th>
    				<th class="text-center">Tipo de <br> Competencia</th>
    				<th class="text-center">Competencia</th>
    				<th class="text-center">Objetivo General</th>
    				<th class="text-center"></th>
    			</tr>
    		</thead>
    		<tbody>
    			<?php
          $idRubrica = $fedit_admin['idRubrica'];
          $idCurso   = $fedit_admin['idCurso']; 

    			$qryDetRubrica = $conn->query("SELECT t.idRubrica, t.idCurso, t.idCriterio, c.descripcion AS desCriterio, t.idTipoCompetencia, tc.descripcion AS desTipo, t.idCompetencia, cc.descripcion AS desCompetencia, t.idObjetivoGeneral, obg.definicion AS desObjetivo, t.ordenamiento FROM detalle_rubrica t
          LEFT JOIN criterio c ON (c.idCriterio = t.idCriterio)
        	LEFT JOIN tipocompetencia tc ON (tc.idTipo = t.idTipoCompetencia)
          LEFT JOIN competencia cc ON (cc.idCompetencia = t.idCompetencia)
        	LEFT JOIN objgeneral obg ON (obg.idObjgeneral = t.idObjetivoGeneral)
    			WHERE idCurso='$idCurso' AND idRubrica='$idRubrica'") or die(mysqli_error($conn));

    			foreach ($qryDetRubrica as $detRubrica)
    			{
    			?>
    			<tr>
    				<td class="text-justify"><?php echo $detRubrica['desCriterio'] ?></td>
    				<td class="text-center"><?php echo $detRubrica['ordenamiento'] ?></td>
            <td class="text-center">
              <?php if ($detRubrica['idTipoCompetencia'] != '-1'){
    						echo $detRubrica['desTipo'];
    					}else{
    					?>
    						No aplica
    					<?php
              }
              ?>
            </td>
    				<td class="text-center">
    					<?php if ($detRubrica['idCompetencia'] != '-1'){
    						echo $detRubrica['desCompetencia'];
    					}else{
    					?>
    						No aplica
    					<?php
              }
              ?>
    				</td>
    				<td class="text-center">
    					<?php if ($detRubrica['idObjetivoGeneral'] != '-1'){
    						echo $detRubrica['desObjetivo'];
    					}else{
    					?>
    						No aplica
    					<?php
    					}
    					?>
    				</td>
    				<td class="text-center">
    					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $detRubrica['idRubrica'].'_'.$idCurso.'_'.$detRubrica['idCriterio'] ?>" title="Elimina Criterio" onclick="deleteCriterio2(this.id);">
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


    <!-- Carga los datos ajax -->
    <!-- <div id="resultados" class='col-md-12' style="margin-top:10px"></div> -->

    <div class="form-group">
      <button class="btn btn-primary" name="" id="btnSaveRubrica" onclick="window.location='rubricas.php'">
        <span class="glyphicon glyphicon-save"></span> Guardar
      </button>
    </div>
	</div>

  <div class="modal fade" id="modalAddCriterios" role="dialog" tabindex="-2"></div>
  <script type="text/javascript" src="js/nuevo_rubrica.js"></script>

  <script type="text/javascript">
  function deleteCriterio2(id){

    arr 				= id.split('_');
  	xIdRubrica  = arr[0];
  	xIdCurso		= arr[1];
  	xIdCriterio	= arr[2];

    $.ajax({
      type: 'POST',
    	url: 'rubricasEliminar.php',
      data: 'idRubrica='+xIdRubrica+'&idCriterio='+xIdCriterio+'&idCurso='+xIdCurso+'&deleteDet=dd',

      beforeSend: function(objeto){
        $("#resultados").html("Mensaje: Cargando...");
      },

      success: function(datos){
        $("#resultados").html(datos);
      }

    }); //LLAVE AJAX
  }
  </script>
