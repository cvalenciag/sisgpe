<?php
	 require_once 'valid.php';
     $session_id= $_SESSION['session_id'];
	if(ISSET($_POST['edit_user']))
	{
			$idOgOe = $_REQUEST['idOgOe'];
			$idObjgeneral = $_REQUEST['idObjgeneral'];
			$fAprobacion = $_POST['fAprobacion'];
			$idObjespecifico = $_REQUEST['idObjespecifico'];

			$conn->query("UPDATE og_oe SET fAprobacion = '$fAprobacion',idObjgeneral = '$idObjgeneral' WHERE idOgOe = '$idOgOe'") or die(mysqli_error($conn));


			$sql=mysqli_query($conn, "select * from detalle_og_oe where idObjgeneral='$idObjgeneral'");
				while ($row=mysqli_fetch_array($sql))
				{ // abre else

				$conn->query("update detalle_og_oe set idObjgeneral='$idObjgeneral' where idOgOe='$idOgOe' and idObjgeneral='$idObjgeneral' and idObjespecifico='$idObjespecifico'") or die (mysqli_error($conn));

				}  //cierra else
			echo '
				<script type = "text/javascript">
					alert("Registro actualizado correctamente.");
					window.location = "ogoe.php";
				</script>
			';

	} // cierre if post edit user
