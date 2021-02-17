<?php
	require_once 'connect.php';
	$conn->query("update objespecifico set estado='$_REQUEST[estado]' WHERE `idObjespecifico` = '$_REQUEST[admin_id]'") or die(mysqli_error($conn));
	header('location: objespecifico.php');