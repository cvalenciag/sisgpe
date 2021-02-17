$(document).ready(function(){
	$error = $('<center><label class = "text-danger">Por favor debe ingresar una contraseña para continuar</label></center>');
	$error1 = $('<center><label class = "text-danger">La contraseña debe tener minimo 6 caracteres</label></center>');
	$error2 = $('<center><label class = "text-danger">La contraseña no puede tener espacios en blanco</label></center>');
	$error3 = $('<center><label class = "text-danger">Las contraseñas no coinciden</label></center>');
	$error4 = $('<center><label class = "text-danger">No podemos reestablecer la contraseña, realice una nueva solicitud <a href="enviarPassword.php">Aqui</a></label></center>');
	$error5 = $('<center><label class = "text-danger">Usuario inactivo, contacte con el administrador del sistema.</label></center>');
	$loading = $('<center><img src = "images/378.gif" height = "10px"/></center>');
	$ok = $('<center><label class = "text-success">La contraseña de su cuenta se ha restablecido con éxito. Por favor inicie sesión con su nueva contraseña <a href="index.php">Aqui</a></label></center>');	
   
	$('#resetSubmit').click(function(){
		$error.remove();
		$error1.remove();
		$error2.remove();
		$error3.remove();
		$error4.remove();
		$error5.remove();
		$('#password').focus(function(){	
			$('#password_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$('#confirm_password').focus(function(){	
			$('#cpassword_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});
		
		var caract_invalido = " ";
		var caract_longitud = 6;
		$confirm_password = $('#confirm_password').val();
		$password = $('#password').val();
		$fp_code = $('#fp_code').val();
		$id_code = $('#id_code').val();
		if($confirm_password == "" || $password == ""){
			$error.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
			
		} else if ($password.length < caract_longitud) {
			$error1.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
      
	  } else if ($password.indexOf(caract_invalido) > -1) {
			$error2.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
		
		} else if ($password != $confirm_password) {
         $error3.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
			
		} else if ($fp_code == "" || $id_code == "") {
         $error4.appendTo('#result');		
			
		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('formmail.php', {fp_code: $fp_code, id_code: $id_code, password: $password, reiniciar: '1'},
					function(result){
						if(result == 'Success'){
							$loading.remove();
							$error4.remove();
							$error5.remove();
							$ok.appendTo('#result');
						
							
						}else if(result == 'estado'){
							$loading.remove();
							$error4.remove();
							$error5.appendTo('#result');
						
						
						}else{
							$loading.remove();
							$error5.remove();
							$error4.appendTo('#result');
						}
						
						
						
						
						
						
					}
				)
			}, 3000);	
		}
	});
        
        
        
        
    $(window).keypress(function(e) {
        if(e.keyCode == 13) {
		$error.remove();
		$error1.remove();
		$error2.remove();
		$error3.remove();
		$error4.remove();
		$error5.remove();
		$('#password').focus(function(){	
			$('#password_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$('#confirm_password').focus(function(){	
			$('#cpassword_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});
		
		var caract_invalido = " ";
		var caract_longitud = 6;
		$confirm_password = $('#confirm_password').val();
		$password = $('#password').val();
		$fp_code = $('#fp_code').val();
		$id_code = $('#id_code').val();
		if($confirm_password == "" || $password == ""){
			$error.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
			
		} else if ($password.length < caract_longitud) {
			$error1.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
      
	  } else if ($password.indexOf(caract_invalido) > -1) {
			$error2.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
		
		} else if ($password != $confirm_password) {
         $error3.appendTo('#result');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
			$('#cpassword_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#cpassword_warning');
			
		} else if ($fp_code == "" || $id_code == "") {
         $error4.appendTo('#result');
		 
		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('formmail.php', {fp_code: $fp_code, id_code: $id_code, password: $password, reiniciar: '1'},
					function(result){
						if(result == 'Success'){
							$loading.remove();
							$error4.remove();
							$error5.remove();
							$ok.appendTo('#result');
						
							
						}else if(result == 'estado'){
							$loading.remove();
							$error4.remove();
							$error5.appendTo('#result');
						
						
						}else{
							$loading.remove();
							$error5.remove();
							$error4.appendTo('#result');
						}
					}
				)
			}, 3000);	
		}
	
        
    }
});       
        
         
     
});