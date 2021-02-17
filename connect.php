<?php
	
        // Datos de la base de datos localhost
	/*$usuario = "root";
	$password = "root";
	$servidor = "localhost";
	$basededatos = "db_ls";*/
        
      //atos de la base de datos Produccion
	$usuario = "id16176835_dbsiaap";
	$password = "!TA|ot\Ha2v/|WyG";
	$servidor = "localhost";
	$basededatos = "id16176835_siaap";
	
    
        
        
	// creación de la conexión a la base de datos con mysql_connect()
	$conn = mysqli_connect( $servidor, $usuario, $password ) or die ("No se ha podido conectar al servidor de Base de datos" . mysqli_error($conn));
	
	// Selección del a base de datos a utilizar
	mysqli_select_db( $conn, $basededatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos " . mysqli_error($conn));
    
	// Selección del utf8
	mysqli_query($conn, "SET NAMES 'utf8'");	
        