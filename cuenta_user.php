<?php
                $qedit_admin = $conn->query("SELECT nombre,apellido FROM usuario WHERE idUsuario = '$_SESSION[admin_id]'") or die(mysqli_error($conn));
                $fedit_admin = $qedit_admin->fetch_array(); 
                    
?>

<div class = "container-fluid" align=middle>
            <a href="perfil.php?admin_id=<?php echo $_SESSION['admin_id']?>"><img src = "images/user_1.png" width = "100px" height = "100px"/></a>
			
					<br />
					<label class = "text-muted">Bienvenido(a)</label>
					<br />
            <label class = "text-muted"> <?php echo $fedit_admin['nombre']." ".$fedit_admin['apellido'];?></label>
            <div class = "form-group">
                <a href = "perfil.php?admin_id=<?php echo $_SESSION['admin_id']?>" class = "btn btn-warning btn-block">
                <i class = "glyphicon glyphicon-edit"></i> Perfil</a>
            </div>
</div>
                                