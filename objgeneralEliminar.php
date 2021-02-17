<?php
	require_once 'connect.php';
	$conn->query("update objgeneral set estado='$_REQUEST[estado]' WHERE `idObjgeneral` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	header('location: objgeneral.php');