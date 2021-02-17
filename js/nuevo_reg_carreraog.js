/*$(document).ready(function(){
    load(1);
})*/

function load(page){
            var q= $("#q").val();
            var carrera1= $("#carrera").val();
            var idCarreraOg= $("#idCarreraOg").val();
            var fAprobacion= $("#fAprobacion").val();
            $("#loader").fadeIn('slow');
            var elegido=$("#competencia").val();
            var tipo1=$("#tipo").val();
            $.ajax({
                url:'./ajax/og_carreraog.php?action=ajax&page='+page+'&q='+q+'&idCompetencia='+elegido+'&idCarrera='+carrera1+'&idTipo='+tipo1+'&idCarreraOg=' + idCarreraOg+'&fAprobacion=' + fAprobacion,
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
                        url: "carreraogEliminar1.php",
                        data: "id="+id+'&fAprobacion='+fAprobacion,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(datos){
                            $("#resultados").html(datos);
                            }
                    });
                    }
        }

       function eliminarDet (idCarreraOg,idCa,idOg,idCompetenciaOg)
		{
      // alert(idOg);

                var p = confirm("¿Está seguro de eliminar el registro?");
                if(p){
						$.ajax({
							type: "POST",
							url: "./ajax/agregar_carreraog2.php",
							data: "idCa="+idCa+"&idOg="+idOg+"&idCarreraOg="+idCarreraOg+"&idCompetencia="+idCompetenciaOg+"&op=D",
								beforeSend: function(objeto){
									$("#resultados").html("Mensaje: Cargando...");
								},
							success: function(datos){
								$("#resultados").html(datos);
								}
						});
                    }
       }

// FUNCION PARA LLENAR EL COMBO
$(document).ready(function(){
	$("#facultad").change(function () {
		$("#facultad option:selected").each(function () {
			idFacultad = $(this).val();
			$.post("./ajax/agregar_carreraog.php", { elegido: idFacultad }, function(data){
				$("#carrera").html(data);
			});
		});
	})
});


$(document).ready(function(){
	$("#tipo").change(function () {
		$("#tipo option:selected").each(function () {
			elegido2 = $(this).val();
			$.post("./ajax/agregar_carreraog.php", { elegido2: elegido2 }, function(data){
				$("#competencia").html(data);
			});
		});
	})
});


$(document).ready(function(){
  $("#btnEditarObj").click(function(){

    $("#facultad").change(function () {
  		$("#facultad option:selected").each(function () {
  			idFacultad = $(this).val();
  			$.post("./ajax/agregar_carreraog.php", { elegido: idFacultad }, function(data){
  				$("#carrera").html(data);
  			});
  		});
  	})

    $("#tipo").change(function () {
  		$("#tipo option:selected").each(function () {
  			elegido2 = $(this).val();
  			$.post("./ajax/agregar_carreraog.php", { elegido2: elegido2 }, function(data){
  				$("#competencia").html(data);
  			});
  		});
  	})

  });
});


// $(document).ready(function(){
//
//     $("#facultad").change(function () {
//         $("#facultad option:selected").each(function () {
//             elegido = $(this).val();
//             $.post("./ajax/agregar_carreraog.php", { elegido: elegido }, function(data){
//                 $("#carrera").html(data);
//             });
//         });
//    });
//
//    $("#tipo").change(function () {
//         $("#tipo option:selected").each(function () {
//             elegido2=$(this).val();
//             $.post("./ajax/agregar_carreraog.php", { elegido2: elegido2 }, function(data){
//                 $("#competencia").html(data);
//             });
//         });
//    });
//
//
//
//     $("#facultad").change(function () {
//         $("#facultad option:selected").each(function () {
//             elegido3=$(this).val();
//             $.post("./ajax/agregar_carreraog2.php", { elegido3: elegido3 }, function(data){
//                 $("#carrera").html(data);
//             });
//         });
//    });
//
//
//    $("#tipo").change(function () {
//         $("#tipo option:selected").each(function () {
//             elegido4=$(this).val();
//             $.post("./ajax/agregar_carreraog2.php", { elegido4: elegido4 }, function(data){
//                 $("#competencia").html(data);
//             });
//         });
//    });
//
// });

//
// $(document).ready(function(){
// 	$("#tipo").change(function () {
// 		$("#tipo option:selected").each(function () {
// 			elegido2 = $(this).val();
// 			$.post("./ajax/agregar_carreraog.php", { elegido2: elegido2 }, function(data){
// 				$("#competencia").html(data);
// 			});
// 		});
// 	})
// });
