<?php
        require_once '../valid.php';
        $session_id= $_SESSION['session_id'];
        
	
		$idCarrera = $_POST['idCarrera'];
		$fAprobacion = $_POST['fAprobacion'];
                $fActualizacion = $_POST['fActualizacion'];

		$estado = $_POST['estado'];

/*		$idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
$fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';  
$estado = (isset($_REQUEST['estado']) && !empty($_REQUEST['estado']))?$_REQUEST['estado']:'';*/


	   $sql2=$conn->query("select * from malla where fAprobacion = '" . $fAprobacion. "' and fActualizacion='".$fActualizacion."' and idCarrera='".$idCarrera."' and eliminado=0");
		if ($sql2->num_rows > 0){ 
				 echo "1";
			}
                        
                        
                       /* 
                        echo '
				<script type = "text/javascript">
					alert("la carrera seleccionada ya se encuentra registrada en nuestro sistema. Cambie la fecha de actualizaciom");
					
				</script>
			';   
*/