<?php
        require_once '../valid.php';
        $session_id= $_SESSION['session_id'];
        
	
		$idObjgeneral = $_POST['idObjgeneral'];
		$fAprobacion = $_POST['fAprobacion'];
		$estado = $_POST['estado'];

/*		$idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';  
$estado = (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';*/


	    $sql2=$conn->query("select * from og_oe where fAprobacion = '" . $fAprobacion. "' and idObjgeneral='".$idObjgeneral."' and eliminado=0");
		if ($sql2->num_rows > 0){ 
                    echo "1";
				/* echo '
				<script type = "text/javascript">
					alert("Fecha de aprobacion para el objetivo general seleccionado ya se encuentra registrada en nuestro sistema");
					window.location = "ogoe.php";
				</script>
			';    */  
			} 

