<?php
require_once '../valid.php';

// MUESTRA LAS CARRERAS ===================================================================================
if (isset($_POST['elegido']))
{
  $elegido = $_POST['elegido'];

  $qryRubrica = $conn->query("SELECT * FROM rubrica WHERE estado=1 AND idCurso='$elegido' GROUP BY fechaAprobacion") or die(mysqli_error($conn));

		echo '<option value="" selected="selected">Seleccione una opción</option>';

  foreach ($qryRubrica as $rubrica) {
    echo "<option value='".$rubrica['fechaAprobacion']."'>". $rubrica['fechaAprobacion'] . "</option>";
  }
} 
