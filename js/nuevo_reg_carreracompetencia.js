

function load(page){
            var q= $("#q").val();
            var carrera1= $("#carrera").val();
            var idCarreraCompetencia= $("#idCarreraCompetencia").val();
            var fAprobacion= $("#fAprobacion").val();
            $("#loader").fadeIn('slow');
            var elegido=$("#tipo").val();

            $.ajax({
                url:'./ajax/competencia_carreracompetencia.php?action=ajax&page='+page+'&q='+q+'&idDpto='+elegido+'&idCarrera='+carrera1+'&idCarreraCompetencia=' + idCarreraCompetencia+'&fAprobacion=' + fAprobacion,
                 beforeSend: function(objeto){
                 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
              },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })

        }

   function eliminar (id)
		{
      var fAprobacion= $("#fAprobacion").val();

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
				$.ajax({
                        type: "GET",
                        url: "carreracompetenciaEliminar2.php",
                        data: "&id="+id+'&fAprobacion='+fAprobacion,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                    });
              }
        }

/*     function eliminar (id,idCarrera)
		{
		$.ajax({
        type: "GET",
        url: "./ajax/agregar_carreracompetencia.php",
        data: "id="+id+"&idCarrera="+idCarrera,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		}
		});
		}   */

           function eliminarDet (idCarreraCompetencia,idCa,idCo)
		{

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
						$.ajax({
							type: "GET",
							url: "./ajax/agregar_carreracompetencia2.php",
							data: "idCa="+idCa+"&idCo="+idCo+"&idCarreraCompetencia="+idCarreraCompetencia+"&op=D",
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
    $("#facultad").on('change', function () {
        $("#facultad option:selected").each(function () {
            elegido=$(this).val();
            $.post("./ajax/agregar_carreracompetencia.php", { elegido: elegido }, function(data){
                $("#carrera").html(data);
            });
        });
   });

     $("#facultad").on('change', function () {
        $("#facultad option:selected").each(function () {
            elegido1=$(this).val();
            $.post("./ajax/agregar_carreracompetencia2.php", { elegido1: elegido1 }, function(data){
                $("#carrera").html(data);
            });
        });
   });
});

/*$(document).ready(function(){
    $("#competencia").on('change', function () {
        $("#competencia option:selected").each(function () {
            elegido1=$(this).val();
            $.post("./ajax/agregar_ogoe.php", { elegido1: elegido1 }, function(data){
                $("#objgeneral").html(data);
            });
        });
   });
});*/
