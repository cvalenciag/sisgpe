<script src = "js/jquery.js"></script>
<script src = "js/bootstrap.js"></script>
<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
<?php
	require_once 'connect.php';
	if(ISSET($_POST['edit_user'])){	
			$conn->query("UPDATE criterio SET descripcion = '$_POST[descripcion]',definicion = '$_POST[definicion]', estado='$_POST[estado]' WHERE idCriterio = '$_REQUEST[admin_id]'") or die (mysqli_error($conn));
    
echo '
            <script type = "text/javascript">
					alert("Registro actualizado correctamente");
					window.location = "criterio.php";
				</script>
			';   
}
    