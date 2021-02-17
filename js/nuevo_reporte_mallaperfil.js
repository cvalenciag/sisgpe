function volverInicio(){
  window.location = "home.php";
}

$(document).ready(function(){

  $('#divReportesMalla').hide();

  $("#idFacultadMP").on('change', function () {
    elegido = $(this).val();
    	$.post("./ajax/agregar_reportesMallaPerfil.php", { elegido: elegido }, function(data){
    		$("#idCarreraMP").html(data);
      });
   });
});


$(document).ready(function(){
  $("#idCarreraMP").on('change', function () {
    elegido2 = $(this).val();
      $.post("./ajax/agregar_reportesMallaPerfil.php", { elegido2: elegido2 }, function(data){
        $("#fechaMP").html(data);
      });
   });
});


function generaReporte(){

  $('#resultadosMP').empty();

  var xIdFacultad			= $('#idFacultadMP').val();
  var xIdCarrera 			= $('#idCarreraMP').val();
	var xFechaMalla		  =	$('#fechaMP').val();
	var xObliga		  		=	$('#idObligaMP').val();


  if(xIdCarrera=='' && xFechaMalla=='' && xIdFacultad=='' && xObliga==''){
    alert('El reporte no se puede generar, favor de seleccionar los datos.');
    return false;
  }

  // $('#botones').show();
  $('#resultadosMP').show();
  $('#divReportesMalla').show();

	$.ajax({
		type: 'POST',
		url: './ajax/agregar_reportesMallaPerfil2.php',
		data: "&idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+'&obligaCurso='+xObliga,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resultadosMP").html(datos);

      // $('#tablaResultMP').DataTable( {
    	// 	"language": {
      //   	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
      //   },
			// 	ordering	: false,
    	// 	dom: 'Bfrtip',
    	// 		buttons: [
    	// 		{
    	// 			extend: 'pdf',
    	// 			text: '<img src="images/pdf.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a pdf'
    	// 		},
    	// 		{
    	// 			extend: 'excel',
    	// 			text: '<img src="images/xls.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a excel'
    	// 		},
    	// 		{
    	// 			extend: 'csv',
    	// 			text: '<img src="images/csv.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a csv'
    	// 		},
    	// 		{
    	// 			extend: 'print',
    	// 			text: '<img src="images/print.png" width=20 height=20/>',
    	// 			titleAttr: 'Imprimir'
    	// 		}],
    	// 		columnDefs: [
      //   		{ width: "5%",  targets: 0 },
      //   		{ width: "10%", targets: 1 },
      //   		{ width: "45%", targets: 2 },
      //   		{ width: "10%", targets: 3 },
      //   		{ width: "10%", targets: 4 },
      //   		{ width: "10%", targets: 5 },
      //   		{ width: "10%", targets: 6 },
      // 		],
      // 	});

      // if ( ($("#idResult").val()) == 1){
      // }
    }

	});

}


function exportaExcelMalla(){

  var xIdFacultad			= $('#idFacultadMP').val();
  var xIdCarrera 			= $('#idCarreraMP').val();
	var xFechaMalla		  =	$('#fechaMP').val();
	var xObliga		  		=	$('#idObligaMP').val();

  window.open("xlsReporteMallaCurricular.php?idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+'&obligatorio='+xObliga);
}


function exportaPDFMalla(){

  var xIdFacultad			= $('#idFacultadMP').val();
  var xIdCarrera 			= $('#idCarreraMP').val();
	var xFechaMalla		  =	$('#fechaMP').val();
	var xObliga		  		=	$('#idObligaMP').val();

  window.open("pdfReporteMallaCurricular.php?idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+'&obligatorio='+xObliga);
}




// =================================================================================================================
// SEGUNDO REPORTE =================================================================================================
$(document).ready(function(){
  $('#divReportes').hide();
  $("#idFacultadPerfil").on('change', function () {
    elegidop1 = $(this).val();
    	$.post("./ajax/agregar_reportesMallaPerfil.php", { elegidop1: elegidop1 }, function(data){
    		$("#idCarreraPerfil").html(data);
      });
   });
});


$(document).ready(function(){
  $("#idCarreraPerfil").on('change', function () {
    elegidop2 = $(this).val();
      $.post("./ajax/agregar_reportesMallaPerfil.php", { elegidop2: elegidop2 }, function(data){
        $("#fechaPerfil").html(data);
      });
   });
});



function generaReportePerfil(){

  $('#resultadosPerfil').empty();

  var xIdFacultad			= $('#idFacultadPerfil').val();
  var xIdCarrera 			= $('#idCarreraPerfil').val();
	var xFechaPerfil	  =	$('#fechaPerfil').val();


  if(xIdCarrera=='' && xFechaPerfil=='' && xIdFacultad==''){
    alert('El reporte no se puede generar, favor de seleccionar los datos.');
    return false;
  }

  // $('#botones').show();
  $('#resultadosPerfil').show();
  $('#divReportes').show();

	$.ajax({
		type: 'POST',
		url: './ajax/agregar_reportesMallaPerfil3.php',
		data: "&idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaMalla="+xFechaPerfil,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resultadosPerfil").html(datos);

      // $('#tablaResultPerfil').DataTable( {
    	// 	"language": {
      //   	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
      //   },
			// 	ordering	: false,
    	// 	dom: 'Bfrtip',
    	// 		buttons: [
    	// 		{
    	// 			extend: 'pdf',
    	// 			text: '<img src="images/pdf.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a pdf'
    	// 		},
    	// 		{
    	// 			extend: 'excel',
    	// 			text: '<img src="images/xls.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a excel'
    	// 		},
    	// 		{
    	// 			extend: 'csv',
    	// 			text: '<img src="images/csv.png" width=20 height=20/>',
    	// 			titleAttr: 'Exportar a csv'
    	// 		},
    	// 		{
    	// 			extend: 'print',
    	// 			text: '<img src="images/print.png" width=20 height=20/>',
    	// 			titleAttr: 'Imprimir'
    	// 		}],
    	// 		columnDefs: [
      //   		{ width: "5%",  targets: 0 },
      //   		{ width: "10%", targets: 1 },
      //   		{ width: "45%", targets: 2 },
      //   		{ width: "10%", targets: 3 },
      //   		{ width: "10%", targets: 4 },
      //   		{ width: "10%", targets: 5 },
      //   		{ width: "10%", targets: 6 },
      // 		],
      // 	});

      // if ( ($("#idResult").val()) == 1){
      // }
    }

	});

}



// FUNCION DE REPORTES =========================================================
function exportaExcel(){
  var xIdFacultad			= $('#idFacultadPerfil').val();
  var xIdCarrera 			= $('#idCarreraPerfil').val();
	var xFechaPerfil	  =	$('#fechaPerfil').val();

  window.open("xlsPerfilEgresado.php?idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaPerfil="+xFechaPerfil);
}


function exportaPDF(){
  var xIdFacultad			= $('#idFacultadPerfil').val();
  var xIdCarrera 			= $('#idCarreraPerfil').val();
	var xFechaPerfil	  =	$('#fechaPerfil').val();

  window.open("pdfReportePerfilMalla.php?idFacultad="+xIdFacultad+"&idCarrera="+xIdCarrera+"&fechaPerfil="+xFechaPerfil);
}
