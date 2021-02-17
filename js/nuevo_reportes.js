function returnHome(){
  window.location = "home.php";
}


$(document).ready(function(){

  $('#pestanas').hide();
  $('#grafico').hide();
  $('#resumen').hide();
  $('#divReportes').hide();

    $("#idCarrera").on('change', function () {
            elegido = $(this).val();
            $.post("./ajax/agregar_reportesMenuCurso.php", { elegido: elegido }, function(data){
                $("#fechaMalla").html(data);
            });
   });
});


// $(document).ready(function(){
//     $("#idCarrera").on('change', function () {
//             elegido2 = $(this).val();
//             $.post("./ajax/agregar_reportesMenuCurso.php", { elegido2: elegido2 }, function(data){
//                 $("#competencias").html(data);
//             });
//    });
// });


$(document).ready(function(){
    $("#idTipoCompetencia").on('change', function () {
            elegido3 = $(this).val();
            elegido4 = $('#idCarrera').val();
            $.post("./ajax/agregar_reportesMenuCurso.php", { elegido3: elegido3, elegido4: elegido4 }, function(data){
                $("#competencias").html(data);
            });
   });
});


// $(document).ready(function(){
//   $('#competencias').multiselect({
//     columns: 1,
//     placeholder: 'Seleccione una opción',
//     search: true
//   });
// });


function generaReporte(){

  // $('#resultados').empty();
  $('#resumen').empty();
  $('#grafico').empty();


  var xIdCarrera 			= $('#idCarrera').val();
	var xFechaMalla		  =	$('#fechaMalla').val();
	var xTipoComp			  = $('#idTipoCompetencia').val();
	var xObligatorio	  = $('#idObliga').val();

  var selected = "";
    $('#competencias option:selected').each(function(){
      selected += $(this).val() + ',';
    });

    fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
    selected = selected.substr( 0, fin );


  if(xIdCarrera=='' || xFechaMalla=='' || xTipoComp=='' || xObligatorio=='' || selected==''){
    alert('El reporte no se puede generar, favor de seleccionar todos los datos.');
    return false;
  }



  $('#pestanas').show();
  // $('#resultados').show();
  $('#resumen').show();
  $('#divReportes').show();

	$.ajax({
		type: 'POST',
		url: 'reportesMenuCurso3.php',
		// url: './ajax/agregar_reportesMenuCurso2.php',
		data: "&idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&tipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idComp='+selected,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resumen").html(datos);
			// $("#resultados").html(datos);

      // $('#tablaResult').DataTable( {
    	// 	"language": {
      //   	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
      //   },
      //
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
      //   		{ width: "35%", targets: 0 },
      //   		{ width: "15%", targets: 1 },
      //   		{ width: "15%", targets: 2 },
      //   		{ width: "10%", targets: 3 },
      //   		{ width: "25%", targets: 4 },
      // 		],
      // 	});

      // if ( ($("#idResult").val()) == 1){
      //   $('#pestanas').hide();
      //   $('#grafico').hide();
      // }
    }

	});

}


// function showDatos(){
//   $('#resultados').show();
//   $('#resumen').hide();
//   $('#grafico').hide();
// }


function showGrafico(){

  var xIdCarrera 			= $('#idCarrera').val();
  var xTipoComp			  = $('#idTipoCompetencia').val();
	var xObligatorio	  = $('#idObliga').val();

  var selected = "";
    $('#competencias option:selected').each(function(){
      selected += $(this).val() + ',';
    });

    fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
    selected = selected.substr( 0, fin );

  $('#pestanas').show();
  $('#grafico').show();
  $('#grafico').load('reportesMenuCurso2.php?idCarrera='+xIdCarrera+"&tipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idComp='+selected);
  // $('#resultados').hide();
  $('#resumen').hide();
}


function showResumen(){
  // var xIdCarrera 		= $('#idCarrera').val();
  // var xFechaPerfil  = $('#fechaPerfil').val();

  $('#resumen').show();
  // $('#resumen').load('reportesMenuCurso3.php?idCarrera='+xIdCarrera);
  // $('#resultados').hide();
  $('#grafico').hide();
}


function verCompetencias(idCarrera, idCurso){

  var fechaPerfil  = $('#fechaPerfil').val();
  var xObligatorio = $('#idObliga').val();
  var xTipoComp		 = $('#idTipoCompetencia').val();

  var selected = "";
    $('#competencias option:selected').each(function(){
      selected += $(this).val() + ',';
    });

    // alert(selected);

    fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
    selected = selected.substr( 0, fin );

  $("#loader").fadeIn('slow');


  $.ajax({
		type: 'POST',
		url: './ajax/agregar_reporteCompetencias.php',
		data: "&idCarrera="+idCarrera+"&idCurso="+idCurso+"&fechaPerfil="+fechaPerfil+'&idComps='+selected+'&xIdObliga='+xObligatorio+'&idTipoComp='+xTipoComp,

    beforeSend: function(objeto){
      $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
		},

		success: function(data){
      $(".resul_div").html(data).fadeIn('slow');
			$('#loader').html('');
    }

	});
}


function exportaExcel(){

  var xIdCarrera 			= $('#idCarrera').val();
	var xFechaMalla		  =	$('#fechaMalla').val();
	var xTipoComp			  = $('#idTipoCompetencia').val();
	var xObligatorio	  = $('#idObliga').val();

  var selected = "";
  $('#competencias option:selected').each(function(){
    selected += $(this).val() + ',';
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );


  window.open("xlsAporteALasCompetencias.php?idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&tipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idComp='+selected);

}


function exportaPDF(){

  var xIdCarrera 			= $('#idCarrera').val();
	var xFechaMalla		  =	$('#fechaMalla').val();
	var xTipoComp			  = $('#idTipoCompetencia').val();
	var xObligatorio	  = $('#idObliga').val();

  var selected = "";
  $('#competencias option:selected').each(function(){
    selected += $(this).val() + ',';
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  window.open("pdfReporteAporteCompetencias.php?idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&tipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idComp='+selected);

}
