<?php
        require_once 'valid.php';
        $session_id= $_SESSION['session_id'];
        
	
		$idCarrera = $_POST['idCarrera'];
		$fAprobacion = $_POST['fAprobacion'];
		$cont = $_POST['cont'];
		$idCurso = $_POST['idCurso'];
		
       

                    
        $conn->query("INSERT INTO perfilegresado (idCarrera,idCurso,fAprobacion) VALUES('$idCarrera','$idCurso','$fAprobacion')") or die (mysqli_error($conn));
			
                        
	if ($conn->affected_rows==1)
	{ // inicio affected_rows 
		
	$idPerfil = $conn->insert_id; 
        
        
        for ($i = 0; $i < $cont; $i++){
         $idTipo =  $_POST['tipcom'][$i];
         $idCompetencia =  $_POST['descom'][$i];
         $idObjgeneral =  $_POST['desog'][$i];
         $idObjespecifico =  $_POST['desoe'][$i];
         $aporte =  $_POST['aporte'][$i];  
	$conn->query("INSERT INTO detalle_perfilegresado (idPerfilEgresado,idTipo,idCompetencia,idObjgeneral,idObjespecifico,tipoaporte) 
        VALUES('$idPerfil','$idTipo','$idCompetencia', '$idObjgeneral','$idObjespecifico','$aporte')") or die (mysqli_error($conn));
        }
	
        /*
	while ($row=mysqli_fetch_array($sql))
	{ 
        $idTmp=$row['idTmp'];
	$idCurso=$row['idCurso'];
	$ciclo=$row['ciclo'];
	$obligatorio=$row['obligatorio'];
	$aol=$row['aol'];
	} 
        */
                
              
          echo '
				<script type = "text/javascript">
					alert("Registro guardado correctamente!!");
					window.location = "reporte.php";
				</script>
			';      
                
	} // cierra if affected_rows
	
    