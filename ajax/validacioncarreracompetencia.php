<?php
        require_once '../valid.php';
        $session_id= $_SESSION['session_id'];


		$idCarrera = $_POST['idCarrera'];
		$fAprobacion = $_POST['fAprobacion'];
		$estado = $_POST['estado'];

/*		$idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
$estado = (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';*/


	   $sql2=$conn->query("SELECT * from carrera_competencia where fAprobacion='".$fAprobacion."' and idCarrera='".$idCarrera."' and eliminado=0");
		if ($sql2->num_rows > 0){
      echo "<input type='hidden' id='idResultC' value='1'/>";
				 /*echo '
				<script type = "text/javascript">
					alert("Fecha de aprobacion para la carrera seleccionada ya se encuentra registrada en nuestro sistema");
					window.location = "carreracompetencia.php";
				</script>
			';      */
			}
