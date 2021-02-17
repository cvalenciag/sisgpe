$(document).ready(function(){
	$error = $('<center><label class = "text-danger">Por favor debe ingresar las credenciales de acceso al sistema</label></center>');
	$error1 = $('<center><label class = "text-danger">Usuario o contrasena incorrecta</label></center>');
	$error2 = $('<center><label class = "text-danger">Usuario inactivo, contacte con el administrador del sistema.</label></center>');
	$loading = $('<center><img src = "images/378.gif" height = "10px"/></center>');
   
	$('#login').click(function(){
		$error.remove();
		$error1.remove();
		$('#username').focus(function(){	
			$('#username_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$('#password').focus(function(){	
			$('#password_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$username = $('#username').val();
		$password = $('#password').val();
		if($username == "" && $password == ""){
			$error.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('check_admin.php', {username: $username, password: $password},
					function(result){
						if(result == 'Success'){
							window.location  = 'home.php';
						
							
						}else if(result == 'estado'){
							$loading.remove();
							$error1.remove();
							$error2.appendTo('#result');
						
						
						}else{
							$loading.remove();
							$error2.remove();
							$error1.appendTo('#result');
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
		$('#username').focus(function(){	
			$('#username_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$('#password').focus(function(){	
			$('#password_warning').each(function(){
				$(this).removeClass('has-error has-feedback');
				$(this).find('span').remove();
			});
		});	
		$username = $('#username').val();
		$password = $('#password').val();
		if($username == "" && $password == ""){
			$error.appendTo('#result');
			$('#username_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#username_warning');
			$('#password_warning').addClass('has-error has-feedback');
			$('<span class = "glyphicon glyphicon-remove form-control-feedback"></span>').appendTo('#password_warning');
		}else{
			$loading.appendTo('#result');
			setTimeout(function(){	
				$.post('check_admin.php', {username: $username, password: $password},
					function(result){
						if(result == 'Success'){
							window.location  = 'home.php';
							
						}else if(result == 'estado'){
							$loading.remove();
							$error1.remove();
							$error2.appendTo('#result');
							
						}else{
							$loading.remove();
							$error2.remove();
							$error1.appendTo('#result');
						}
					}
				)
			}, 3000);	
		}
	
        
    }
});       
        
         
     
});