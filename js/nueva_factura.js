
function load(page){
            var q= $("#q").val();
            var carrera= $("#carrera").val();
            var idMalla= $("#idMalla").val();
            var fAprobacion= $("#fAprobacion").val();
            $("#loader").fadeIn('slow');
            var elegido=$("#dpto").val();
            $.ajax({
                url:'./ajax/cursos_malla.php?action=ajax&page='+page+'&q='+q+'&idDpto='+elegido+'&idCarrera='+carrera+'&idMalla=' + idMalla+'&fAprobacion=' + fAprobacion,
                 beforeSend: function(objeto){
                 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
              },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    $('#loader').html('');
                }
            })

        }


function eliminarCurso(id)
{

  var fAprobacion= $("#fAprobacion").val();

  var p = confirm("¿Está seguro de eliminar el registro?");
    if(p)
    {
      $.ajax({
        type: "POST",
        url: "mallaEliminaCurso.php",
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


  function eliminarDet (idMalla,idCa,idCu)
		{

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
						$.ajax({
							type: "GET",
							url: "./ajax/agregar_facturacion2.php",
							data: "idCa="+idCa+"&idCu="+idCu+"&idMalla="+idMalla+"&op=D",
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
	$("#facultad").change(function () {
		$("#facultad option:selected").each(function () {
			idFacultad = $(this).val();
			$.post("./ajax/agregar_facturacion.php", { elegido: idFacultad }, function(data){
				$("#carrera").html(data);
			});
		});
	})
});
