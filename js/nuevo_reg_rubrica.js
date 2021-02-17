
		function eliminar (idTempo)
		{
			var fAprobacion= $("#fAprobacion").val();

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
				$.ajax({
                        type: "POST",
                        url: "rubricaEliminar1.php",
                        data: "idTempo="+idTempo+"&fAprobacion="+fAprobacion,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                    });
                    }
        }

       function eliminarDet (idRubrica,idNivel, idSubcriterio, ordenNivel)
		{
      // alert(idRubrica+'_'+idNivel);
                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
						$.ajax({
							type: "GET",
							url: "./ajax/agregar_rubrica2.php",
							data: "idRubrica="+idRubrica+"&idNivel="+idNivel+"&idSubcriterio="+idSubcriterio+"&ordenNivel="+ordenNivel+"&op=D",
								beforeSend: function(objeto){
									$("#resultados").html("Mensaje: Cargando...");
								},
							success: function(datos){
								$("#resultados").html(datos);
								}
						});
                    }
       }



$(document).ready(function(){
    $("#tipocompetencia").on('change', function () {
            elegido=$(this).val();
            $.post("./ajax/agregar_rubrica.php", { elegido: elegido }, function(data){
                $("#competencia").html(data);
            });
   });
});

$(document).ready(function(){
    $("#competencia").on('change', function () {
            elegido1=$(this).val(); 
            $.post("./ajax/agregar_rubrica.php", { elegido1: elegido1 }, function(data){
                $("#objgeneral").html(data);
            });
        });
});

// CODIGO PARA QUE MUESTRE LOS TEXTAREA
$(document).ready(function(){
    $("#objgeneral").on('change', function () {
            elegido2=$(this).val();
            $.post("./ajax/agregar_rubrica3.php", { elegido2: elegido2 }, function(data){
                $("#definicionObj").html(data);
            });
   });
});

$(document).ready(function(){
    $("#idCriterio").on('change', function () {
            elegidoC=$(this).val();
            $.post("./ajax/agregar_rubrica3.php", { elegidoC: elegidoC }, function(data){
                $("#definicionCriterio").html(data);
            });
   });
});


function justNumbers(e)
{
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
  return true;

  return /\d/.test(String.fromCharCode(keynum));
}
