// function load(page)
// {
// 	var idDepto           = $("#deptoAcad").val();
// 	var obliga            = $('#obligatorio').val();
// 	var idCarrera         = $('#idCarrera').val();
// 	var fAprobacionMalla  = $('#fechaMalla').val();
//
// 	$("#loader").fadeIn('slow');
//
// 	$.ajax({
// 		url:'./ajax/cursos_aporte.php?action=ajax&page='+page+'&idDepto='+idDepto+'&obligatorio='+obliga+'&idCarrera='+idCarrera+'&fechaMalla='+fAprobacionMalla,
//
// 		beforeSend: function(objeto){
// 			$('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
// 		},
//
// 		success:function(data){
// 			$(".outer_div").html(data).fadeIn('slow');
// 			$('#loader').html('');
// 		}
// 	});
//
// }
//
//
// //FUNCION PARA ELIMINAR DETALLES DE APORTE
// function eliminarDet (idPerfilEgresado, idCurso)
// {
//   var p = confirm("¿Está seguro de eliminar el registro?");
// 		if(p){
// 			$.ajax({
// 				type: "POST",
// 				url: "./ajax/agregar_nivelAporte3.php",
// 				data: "xIdPerfil="+idPerfilEgresado+"&xIdCurso="+idCurso+"&op=D",
//
// 				beforeSend: function(objeto){
// 					$("#resultados").html("Mensaje: Cargando...");
// 				},
//
// 				success: function(datos){
// 					$("#resultados").html(datos);
// 				}
// 			});
// 		}
// }


// FUNCION PARA GENERAR REPORTE=====================================================
function reporteObj(id){

	var arr = id.split('_');
	var idPerfilEgresado	= arr[0];
	var fechaPerfil			 	= arr[1];
	var idCarrera			 		= arr[2];

	window.open('nivelAporteReporte.php?idPerfilEgresado='+idPerfilEgresado+'&fechaPerfil='+fechaPerfil+'&idCarrera='+idCarrera);
}
