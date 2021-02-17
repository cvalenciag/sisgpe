$(document).ready(function(){
	$error = $('<center><label class = "text-danger">Por favor debe ingresar su email valido para continuar.</label></center>');
	$error1 = $('<center><label class = "text-danger">Email no se encuentra registrado en nuestra base de datos.</label></center>');
	$error2 = $('<center><label class = "text-danger">Usuario inactivo, contacte con el administrador del sistema.</label></center>');
	$error3 = $('<center><label class = "text-danger">Formato de email incorrecto.</label></center>');
	$loading = $('<center><img src = "images/378.gif" height = "10px"/></center>');
    $ok = $('<center><label class = "text-success">Se envio un mensaje a su email con las instrucciones necesarias para recuperar su contraseña.</label></center>');
        
	$('#forgotSubmit').click(function(){
		$error.remove();
		$error1.remove();
		$error2.remove();
		$error3.remove();
		$('#email').focus(function(){	
			$('#username_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		
		$email = $('#email').val();
		var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
		if($email == ""){
			$error.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');
		}else if (caract.test($email) == false){
			$error3.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');

		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('formmail.php', {email: $email, envio: '1'},
					function(result){
						if(result == 'Success'){
							$loading.remove();
							$error2.remove();
							$error1.remove();
							$ok.appendTo('#result');
							
						}else if(result == 'email'){
							$loading.remove();
							$error2.remove();
							$error1.appendTo('#result');
							
						}else if(result == 'estado'){
							$loading.remove();
							$error1.remove();
							$error2.appendTo('#result');
						
						}else{
							$loading.remove();
							$error1.remove();
							$error.appendTo('#result');
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
		$('#email').focus(function(){	
			$('#username_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		
		$email = $('#email').val();
		var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
		if($email == ""){
			$error.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');
		}else if (caract.test($email) == false){
			$error3.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');
			
		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('formmail.php', {email: $email, envio: '1'},
					function(result){
						if(result == 'Success'){
							$loading.remove();
							$error2.remove();
							$error1.remove();
							$ok.appendTo('#result');
							
						}else if(result == 'email'){
							$loading.remove();
							$error2.remove();
							$error1.appendTo('#result');
							
						}else if(result == 'estado'){
							$loading.remove();
							$error1.remove();
							$error2.appendTo('#result');
						
						}else{
							$loading.remove();
							$error1.remove();
							$error.appendTo('#result');
						}
						
						
						
						
					}
				)
			}, 3000);	
		}
	
        
    }
});       
        
         
     
});