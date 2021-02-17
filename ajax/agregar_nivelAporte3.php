<?php
require_once 'connect.php';

$idCursoE       = (isset($_REQUEST['xIdCurso']) && !empty($_REQUEST['xIdCurso']))?$_REQUEST['xIdCurso']:'';
$idCarreraE     = (isset($_REQUEST['xCarrera']) && !empty($_REQUEST['xCarrera']))?$_REQUEST['xCarrera']:'';
$idDateMallaE   = (isset($_REQUEST['xFechaMalla']) && !empty($_REQUEST['xFechaMalla']))?$_REQUEST['xFechaMalla']:'';
$idDatePerfilE  = (isset($_REQUEST['xFechaPerfil']) && !empty($_REQUEST['xFechaPerfil']))?$_REQUEST['xFechaPerfil']:'';
$idPerfilE      = (isset($_REQUEST['xIdPerfil']) && !empty($_REQUEST['xIdPerfil']))?$_REQUEST['xIdPerfil']:'';

if ($_REQUEST['op']=='E')
{
  $sql3=$conn->query("SELECT * FROM detalle_perfilegresado_curso WHERE idPerfilEgresado='$idPerfilE' AND idCurso='$idCursoE'");

  if ($sql3->num_rows==0)
  {
    $conn->query("INSERT INTO detalle_perfilegresado_curso (idPerfilEgresado, idCarrera, idCurso, fAprobacionMalla, fAprobacionPerfil, eliminado) VALUES('$idPerfilE', '$idCarreraE', '$idCursoE', '$idDateMallaE', '$idDatePerfilE', 0)") or die (mysqli_error($conn));

    echo '<script type = "text/javascript">
          alert("El curso fue agregado satisfactoriamente.");
          </script>';
  }else {
    echo '<script type = "text/javascript">
          alert("El curso ya se encuentra registrado en la base de datos.");
          </script>';
 }
}

// INSTRUCCIONES PARA ELIMINAR DETALLE
if ($_REQUEST['op']=='D')
{
	$sql		= "DELETE FROM detalle_perfilegresado_curso WHERE idPerfilEgresado='$idPerfilE' AND idCurso='$idCursoE'";
	$query	= mysqli_query($conn,$sql);

	if ($conn->affected_rows==1){
		$conn->query("DELETE FROM detalle_curso_nivelaporte WHERE idCurso='$idCursoE'") or die(mysqli_error($conn));
	}

	echo '<script type = "text/javascript">
				alert("El curso se elimino satisfactoriamente.");
				</script>';

}



// CONSULTA QUE MUESTRA LOS RESULTADOS =====================================================================================================
$sql = $conn->query("SELECT * FROM curso c, detalle_perfilegresado_curso t, departamento d, detalle_malla dm WHERE c.idCurso=t.idCurso AND c.idDepartamento=d.idDepartamento AND dm.idCurso=t.idCurso AND idPerfilEgresado='$idPerfilE'");

if ($sql->num_rows > 0)
{
?>
  <table id="tableCursos" class="table table-bordered" style="width:100%;">
    <tr class="alert-info">
      <th class="text-center" style="width:30%;">Curso</th>
      <th class="text-center" style="width:10%;">Ciclo</th>
      <th class="text-center" style="width:25%;">Departamento <br> Académico</th>
      <th class="text-center" style="width:15%;">Tipo <br> Curso</th>
      <th class="text-center" style="width:10%;">AoL</th>
      <th class="text-center" style="width:10%;">Asocial Objetivos <br> de Aprendizaje</th>
      <th></th>
    </tr>
  <?php
    while ($row = mysqli_fetch_array($sql))
    {
      $idPerfil     = $row["idPerfilEgresado"];
      $nombreCurso  = $row['nombreCurso'];
      $idCurso      = $row['idCurso'];
      $ciclo        = $row['ciclo'];
      $aol          = $row['aol'];
      $tipoCurso    = $row['tipoCurso'];
      $idDepartamento   = $row['idDepartamento'];
      $descDepartamento = $row['descripcion'];
  ?>
    <tr>
      <td class='text-center'><?php echo $nombreCurso; ?></td>
      <td class='text-center'><?php echo $ciclo; ?></td>
      <td class='text-center'><?php echo $descDepartamento; ?></td>
      <td class="text-center"><?php echo ($tipoCurso==1) ? "Académico" : "Para-Académico" ?></td>
      <td class='text-center'><?php echo ($aol==1) ? "Si" : "No"?></td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-editar vadmin_id2" data-toggle="modal" data-target="#miModalObjEdit" onclick="enviaModal(<?php echo $idCurso?>, <?php echo $ciclo ?>)"> 
          <span></span>
            Objetivos de Aprendizaje
        </button>
      </td>
      <td class='text-center'>
        <button type="button" name="button" class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="eliminarDet('<?php echo $idPerfil ?>','<?php echo $idCurso; ?>')">
        </button>
      </td>
    </tr>
  <?php
    }
  ?>
  </table>
<?php
  }
?>
