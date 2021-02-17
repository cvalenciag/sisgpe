<?php
require_once 'valid.php';
$session_id = $_SESSION['session_id'];

if (isset($_POST['saveCabecera']) == 'sc')
{
  $idCurso        = $_POST['idCurso'];
  $fAprobacion    = $_POST['fAprobacion'];
  $estado         = $_POST['estado'];

  $sql = $conn->query("SELECT * FROM criterio, tmp WHERE criterio.idCriterio=tmp.idCriterio AND tmp.idCurso='".$idCurso."' AND tmp.idSession='".$session_id."'");

  if ($sql->num_rows>0)
  {
  	 $qryRubrica = $conn->query("SELECT * FROM rubrica WHERE idCurso='".$idCurso."' AND fechaAprobacion='".$fAprobacion."' AND estado=1");

    if ($qryRubrica->num_rows==0)
    {
      $conn->query("INSERT INTO rubrica (idCurso, fechaAprobacion, estado)
      VALUES('$idCurso', '$fAprobacion', '$estado')") or die (mysqli_error($conn));

      if ($conn->affected_rows==1)
      {
        $idRubrica = $conn->insert_id;

        while ($row=mysqli_fetch_array($sql))
    	  {
          $idRubrica   = $conn->insert_id;
          $qryDetalles = $conn->query("SELECT * FROM tmp WHERE idCurso='$idCurso' AND idSession='".$session_id."'");

          while ($row = mysqli_fetch_array($qryDetalles))
          {
            $idTmp          = $row['idTmp'];
            $idCriterio     = $row['idCriterio'];
            $idTipoComp     = $row['obligatorio'];
            $idCompetencia  = $row['idCompetencia'];
            $idObjGral      = $row['idObjgeneral'];
            $ordenamiento   = $row['ordenamiento'];

            $conn->query("INSERT INTO detalle_rubrica (idRubrica, idCurso, idCriterio, idTipoCompetencia, idCompetencia, idObjetivoGeneral, ordenamiento, eliminado) VALUES('$idRubrica', '$idCurso', '$idCriterio', '$idTipoComp', '$idCompetencia', '$idObjGral', '$ordenamiento', 1)") or die (mysqli_error($conn));

            if($conn->affected_rows==1){
              $delete = mysqli_query($conn, "DELETE FROM tmp WHERE idTmp='$idTmp' and idSession='".$session_id."'");
            }
          }
    	}

      echo '<script type = "text/javascript">
            alert("Registro agregado correctamente.");
            window.location = "rubricas.php";
            </script>';

      }

  	}else {
      echo "<input type='hidden' id='idResult' value='0'/>";
      // echo '<script type = "text/javascript">
      //         alert("Los datos de la rubrica ya existen, favor de verificar.");
  		// 				$("#idCurso").css("border", "3px solid red");
  		// 				$("#fAprobacion").css("border", "3px solid red");
      //         $("#resultados").show();
      //       </script>';
  	}

  }else{

    echo '<script type = "text/javascript">
  				  alert("Debe registrar el detalle de rubricas antes de grabar el registro.");
  			  </script>';
  }
}




// AGREGA EL REGISTRO EN TEMPORAL ==============================================================================================
if (isset($_POST['save']) == 's')
{
		$idCurso		= $_POST['idCurso'];
		$idCriterio	= $_POST['idCriterio'];
		$ordena	  	= $_POST['orden'];
		$tipoComp	  = $_POST['tipoComp'];
		$idCompe	  = $_POST['competencia'];
		$idObjGral  = $_POST['objgral'];

		// OBLIGATORIO = VA A GUARDAR INFORMACION DE ID TIPO COMPETENCIA

		$qryDetalle = $conn->query("SELECT * FROM tmp WHERE idCurso='$idCurso' AND ordenamiento='$ordena' AND idSession='".$session_id."'");

		if ($qryDetalle->num_rows==0){

			$conn->query("INSERT INTO tmp (idCurso, idCriterio, obligatorio, idCompetencia, idObjgeneral, ordenamiento, idSession) VALUES('$idCurso', '$idCriterio', '$tipoComp', '$idCompe', '$idObjGral', '$ordena', '$session_id')") or die(mysqli_error($conn));

			echo '<script type = "text/javascript">
						alert("El registro se agregó correctamente.");
						$("#bntSave_'.$idCurso."_".$idCriterio.'").addClass("btn btn-danger btn-sm glyphicon glyphicon-ok");
						$("#ordenamiento_'.$idCriterio.'").css("border", "");
			</script>';

		}else {

			echo '<script type = "text/javascript">
						alert("El número de orden ya existe.");
						$("#ordenamiento_'.$idCriterio.'").css("border", "3px solid red");
			</script>';
		}

?>

<!-- <div class="form-group"> -->
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
			$qryDetRubrica = $conn->query("SELECT t.idTmp, t.idCriterio, c.descripcion AS desCriterio, t.obligatorio, tc.descripcion AS desTipo, t.idCompetencia, cc.descripcion AS desCompetencia, t.idObjgeneral, obg.definicion AS desObjetivo, t.ordenamiento FROM tmp t
      LEFT JOIN criterio c ON (c.idCriterio = t.idCriterio)
    	LEFT JOIN tipocompetencia tc ON (tc.idTipo = t.obligatorio)
      LEFT JOIN competencia cc ON (cc.idCompetencia = t.idCompetencia)
    	LEFT JOIN objgeneral obg ON (obg.idObjgeneral = t.idObjgeneral)
			WHERE t.idCurso='$idCurso' AND t.idSession='".$session_id."'") or die(mysqli_error($conn));

			foreach ($qryDetRubrica as $detRubrica)
			{
			?>
			<tr>
				<td class="text-justify"><?php echo $detRubrica['desCriterio'] ?></td>
				<td class="text-center"><?php echo $detRubrica['ordenamiento'] ?></td>
        <td class="text-center">
          <?php if ($detRubrica['obligatorio'] != '-1'){
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
					<?php if ($detRubrica['idObjgeneral'] != '-1'){
						echo $detRubrica['desObjetivo'];
					}else{
					?>
						No aplica
					<?php
					}
					?>
				</td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $detRubrica['idTmp'].'_'.$idCurso ?>" title="Elimina Criterio" onclick="deleteCriterio(this.id);">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
<!-- </div> -->

<?php
} //LLAVE INSERT TMP



// AGREGA EL REGISTRO DETALLE RUBRICA ==============================================================================
if (isset($_POST['saveDetalle']) == 'sd')
{
		$idCurso		= $_POST['idCurso'];
		$idCriterio	= $_POST['idCriterio'];
		$ordena	  	= $_POST['orden'];
		$tipoComp	  = $_POST['tipoComp'];
		$idCompe	  = $_POST['competencia'];
		$idObjGral  = $_POST['objgral'];
		$idRubrica  = $_POST['idRubrica'];

		// OBLIGATORIO = VA A GUARDAR INFORMACION DE ID TIPO COMPETENCIA

		$qryDetalle = $conn->query("SELECT * FROM detalle_rubrica WHERE idRubrica='$idRubrica' AND idCurso='$idCurso' AND idCriterio='$idCriterio'") or die(mysqli_error($conn));

		if ($qryDetalle->num_rows==0){

			$conn->query("INSERT INTO detalle_rubrica (idRubrica, idCurso, idCriterio, idTipoCompetencia, idCompetencia, idObjetivoGeneral, ordenamiento, eliminado) VALUES('$idRubrica', '$idCurso', '$idCriterio', '$tipoComp', '$idCompe', '$idObjGral', '$ordena', 1)") or die(mysqli_error($conn));

			echo '<script type = "text/javascript">
						alert("El registro se agregó correctamente.");
						$("#bntSave_'.$idCurso."_".$idCriterio.'").addClass("btn btn-danger btn-sm glyphicon glyphicon-ok");
						$("#ordenamiento_'.$idCriterio.'").css("border", "");
			</script>';

		}else {

			echo '<script type = "text/javascript">
						alert("El criterio ya se encuentra registrado.");
						$("#ordenamiento_'.$idCriterio.'").css("border", "3px solid red");
			</script>';
		}

?>

<!-- <div class="form-group"> -->
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
			$qryDetRubrica = $conn->query("SELECT t.idRubrica, t.idCriterio, c.descripcion AS desCriterio, t.idTipoCompetencia, tc.descripcion AS desTipo, t.idCompetencia, cc.descripcion AS desCompetencia, t.idObjetivoGeneral, obg.definicion AS desObjetivo, t.ordenamiento FROM detalle_rubrica t
      LEFT JOIN criterio c ON (c.idCriterio = t.idCriterio)
    	LEFT JOIN tipocompetencia tc ON (tc.idTipo = t.idTipoCompetencia)
      LEFT JOIN competencia cc ON (cc.idCompetencia = t.idCompetencia)
    	LEFT JOIN objgeneral obg ON (obg.idObjgeneral = t.idObjetivoGeneral)
			WHERE idCurso='$idCurso' AND idRubrica='$idRubrica' AND t.eliminado=1") or die(mysqli_error($conn));

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
<!-- </div> -->

<?php
} //LLAVE INSERT DETALLE
?>
<!-- fin de registro de datos en tabla detalle -->


<script type="text/javascript">
function deleteCriterio(id){

  arr 				= id.split('_');
  xIdTempo		= arr[0];
  xIdCurso		= arr[1];
  // xIdCriterio	= arr[2];

  $.ajax({
    type: 'POST',
    url: 'rubricasEliminar.php',
    data: 'idTempo='+xIdTempo+'&idCurso='+xIdCurso+'&deleteTmp=dt',

    beforeSend: function(objeto){
      $("#resultados").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultados").html(datos);
    }

  }); //LLAVE AJAX
}


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
