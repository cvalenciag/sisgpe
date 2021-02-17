
		function eliminar (id,idObjgeneral)
		{
			var fAprobacion= $("#fAprobacion").val();

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
				$.ajax({
                        type: "POST",
                        url: "ogoeEliminar1.php",
                        data: "id="+id+"&idObjgeneral="+idObjgeneral+"&fAprobacion="+fAprobacion,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                    });
                    }
        }

       function eliminarDet (idOgOe,idOg,idOe)
		{

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
						$.ajax({
							type: "GET",
							url: "./ajax/agregar_ogoe2.php",
							data: "idOg="+idOg+"&idOe="+idOe+"&idOgOe="+idOgOe+"&op=D",
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
            $.post("./ajax/agregar_ogoe.php", { elegido: elegido }, function(data){
                $("#competencia").html(data);
            });
   });
});

$(document).ready(function(){
    $("#competencia").on('change', function () {
            elegido1=$(this).val();
            $.post("./ajax/agregar_ogoe.php", { elegido1: elegido1 }, function(data){
                $("#objgeneral").html(data);
            });
        });
});


$(document).ready(function(){
    $("#objgeneral").on('change', function () {
            elegido2=$(this).val();
            $.post("./ajax/agregar_ogoe1.php", { elegido2: elegido2 }, function(data){
                $("#definicion").html(data);
            });
   });
});
