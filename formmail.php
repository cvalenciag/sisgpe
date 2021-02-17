<?php
require_once 'connect.php';
if(isset($_POST['envio'])){
			$result = $conn->query("SELECT idUsuario,nombre,apellido,email,estado FROM usuario WHERE email = '$_POST[email]'") or die (mysqli_error($conn));
             if($result->num_rows==1){
				$f_admin = $result->fetch_array();
				
				if($f_admin['estado']==1){
				$token = md5(uniqid(mt_rand()));;
       
				$resetPassLink = $_SERVER["SERVER_NAME"].'/reiniciarPassword.php?fp_code='.$token.'&id_code='.$f_admin["idUsuario"];
                            
				//send reset password email
				$to = $_POST["email"];
                $conn->query("UPDATE usuario SET token = '$token' WHERE email = '$to' and estado=1") or die(mysqli_error($conn));			
                              
				$subject = "Solicitud de actualización de contraseña";
				$mailContent = 'Estimado '.$f_admin["nombre"] .' '. $f_admin["apellido"] . '
				<br/>Recientemente se envió una solicitud para restablecer una contraseña para su cuenta. Si esto fue un error, simplemente ignore este correo electrónico.
				<br/>Para restablecer su contraseña, visite el siguiente enlace: <a href="'.$resetPassLink.'">'.$resetPassLink.'</a>
				<br/><br/>Saludos,
				<br/>Benyamin Store';
				//set content-type header for sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				//additional headers
				$headers .= 'From: Benyamin Store<admin@benyaminstore.com>' . "\r\n";
				//send email
				mail($to,$subject,$mailContent,$headers);
				echo 'Success';
			 } else 
				echo 'estado';
                        
            } else 
				echo 'email';


}elseif(isset($_POST['reiniciar'])){
	
            $token = $_POST["fp_code"];
            $idUsuario = $_POST["id_code"];
            $password=$_POST["password"];
			$result = $conn->query("SELECT idUsuario,estado FROM usuario WHERE idUsuario = '$idUsuario' and token='$token'") or die (mysqli_error($conn));
			 if($result->num_rows==1){
					$f_admin = $result->fetch_array();
					if($f_admin['estado']==1){
						$conn->query("UPDATE usuario SET password = '$password' WHERE idUsuario='$idUsuario'") or die(mysqli_error($conn));
            
						if($conn->affected_rows==1)
                        $conn->query("UPDATE usuario SET token = '' WHERE idUsuario='$idUsuario'") or die(mysqli_error($conn));
						             
                        echo "Success";
						
                    } else           
                        echo "estado";                  
              } else
                   echo "noUser";     
}
?>
