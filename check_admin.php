<?php
session_start();
	require_once 'connect.php';       
	$username = $_POST['username'];
	$password = $_POST['password'];
	$q_admin = $conn->query("SELECT idUsuario,idRol,estado FROM usuario WHERE username = '$username' && password = '$password'") or die (mysqli_error($conn));   
	$v_admin = $q_admin->num_rows;
	if($v_admin > 0){
            	$f_admin = $q_admin->fetch_array();					
                /*$_SESSION['nombre'] = $f_admin['nombre'];
                $_SESSION['apellido'] = $f_admin['apellido'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (15*60);*/
		if($f_admin['estado']==1){
		$_SESSION['admin_id'] = $f_admin['idUsuario'];
                $_SESSION['session_id'] = session_id ();
                $_SESSION['rol_id'] = $f_admin['idRol'];
		echo 'Success';
		} else
			echo 'estado';
	}else
		echo 'Error: Username o password incorrectos';