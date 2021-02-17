function volverInicio(){
  window.location = "home.php";
}


$(document).ready(function(){

  $('#botonesNivel').hide();
  $('#divReportes').hide();
  $('#pestanas').hide();

    $("#idCarreraNivel").on('change', function () {
      elegido = $(this).val();
      $.post("./ajax/agregar_reportesCursoNivel.php", { elegido: elegido }, function(data){
        $("#fechaMallaNivel").html(data);
      });
   });
});


$(document).ready(function(){
  $("#idTipoCompetenciaNivel").on('change', function () {
    elegido2 = $(this).val();
    elegido3 = $('#idCarreraNivel').val();
    $.post("./ajax/agregar_reportesCursoNivel.php", { elegido2: elegido2, elegido3: elegido3 }, function(data){
      $("#idCompetenciaNivel").html(data);
    });
  });
});


function verReporte(){

  $('#resultadosNivel').empty();
  $('#resumenNivel').empty();
  // $('#graficoNivel').empty();

  var xIdCarrera    = $('#idCarreraNivel').val();
  var xFechaMalla   =	$('#fechaMallaNivel').val();
	var xTipoComp     = $('#idTipoCompetenciaNivel').val();
	var xObligatorio  = $('#idObligaNivel').val();
	var xCompetencia  = $('#idCompetenciaNivel').val();

  var selected = '';
  $('input[type=checkbox]').each(function(){
    if (this.checked) {
      selected += $(this).val()+',';
    }
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  if(xIdCarrera=='' || xFechaMalla=='' || xTipoComp=='' || xObligatorio=='' || selected==''){
    alert('El reporte no se puede generar, favor de seleccionar todos los datos.');
    return false;
  }

  $('#botonesNivel').show();
  $('#resultadosNivel').show();
  $('#divReportes').show();
  $('#pestanas').show();


  $.ajax({
		type: 'POST',
		url: './ajax/agregar_reportesCursoNivel2.php',
		data: "idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&idTipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idCompetencia='+xCompetencia+'&tipoaporte='+selected,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resultadosNivel").html(datos);

      // $('#tablaResultado').DataTable( {
    	// 	"language": {
      //   	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
      //   },

    		// dom: 'Bfrtip',
    			// buttons: [
    			// {
    			// 	extend: 'pdf',
    			// 	text: '<img src="images/pdf.png" width=20 height=20/>',
    			// 	titleAttr: 'Exportar a pdf'
    			// },
    			// {
    			// 	extend: 'excel',
    			// 	text: '<img src="images/xls.png" width=20 height=20/>',
    			// 	titleAttr: 'Exportar a excel'
    			// },
    			// {
    			// 	extend: 'csv',
    			// 	text: '<img src="images/csv.png" width=20 height=20/>',
    			// 	titleAttr: 'Exportar a csv'
    			// },
    			// {
    			// 	extend: 'print',
    			// 	text: '<img src="images/print.png" width=20 height=20/>',
    			// 	titleAttr: 'Imprimir'
    			// }],
    		// 	columnDefs: [
        // 		{ width: "25%", targets: 0 },
        // 		{ width: "5%",  targets: 1 },
        // 		{ width: "20%", targets: 2 },
        // 		{ width: "35%", targets: 3 },
        // 		{ width: "15%", targets: 4 },
      	// 	],
      	// });

        if ( ($("#idResultadoNivel").val()) == 1){
          $('#botonesNivel').hide();
          $('#resumenNivel').hide();
          $('#graficoNivel').hide();
        }
    }
	});
}


function mostrarDatos(){

  $('#resultadosNivel').show();
  $('#pestanas').show();
  $('#resumenNivel').hide();
  $('#graficoNivel').hide();

}


// function mostrarGrafico(){
//
//   var xIdCarrera    = $('#idCarreraNivel').val();
//   var xFechaMalla   =	$('#fechaMallaNivel').val();
// 	var xTipoComp     = $('#idTipoCompetenciaNivel').val();
// 	var xObligatorio  = $('#idObligaNivel').val();
// 	var xCompetencia  = $('#idCompetenciaNivel').val();
//
//   var xContribuye   = ($('#contribuyeNivel').prop('checked')?1:'');
//   var xLogra        = ($('#lograNivel').prop('checked')?2:'');
//   var xSostiene     = ($('#sostieneNivel').prop('checked')?3:'');
//   var xNoAplica     = ($('#naNivel').prop('checked')?4:'');
//
//   var selected = '';
//   $('input[type=checkbox]').each(function(){
//     if (this.checked) {
//       selected += $(this).val()+',';
//     }
//   });
//
//   fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
//   selected = selected.substr( 0, fin );
//
//   $('#graficoNivel').show();
//   $('#graficoNivel').load('reportesCursoNivel2.php?idCarrera='+xIdCarrera+"&fechaMalla="+xFechaMalla+"&idTipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idCompetencia='+xCompetencia+'&tipoSostiene='+xSostiene+'&tipoLogra='+xLogra+'&tipoContribuye='+xContribuye+'&tipoNA='+xNoAplica+'&tipoaporte='+selected);
//   $('#resumenNivel').hide();
//   $('#resultadosNivel').hide();
//
// }

function mostrarResumen(){

  $('#divReportes').show();
  $('#pestanas').show();

  var xIdCarrera    = $('#idCarreraNivel').val();
  var xFechaMalla   =	$('#fechaMallaNivel').val();
	var xTipoComp     = $('#idTipoCompetenciaNivel').val();
	var xObligatorio  = $('#idObligaNivel').val();
	var xCompetencia  = $('#idCompetenciaNivel').val();

  var xContribuye   = ($('#contribuyeNivel').prop('checked')?1:'');
  var xLogra        = ($('#lograNivel').prop('checked')?2:'');
  var xSostiene     = ($('#sostieneNivel').prop('checked')?3:'');
  var xNoAplica     = ($('#naNivel').prop('checked')?4:'');


  var selected = '';
  $('input[type=checkbox]').each(function(){
    if (this.checked) {
      selected += $(this).val()+',';
    }
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  $('#resumenNivel').show();
  $('#resumenNivel').load('reportesCursoNivel3.php?idCarrera='+xIdCarrera+"&fechaMalla="+xFechaMalla+"&idTipoComp="+xTipoComp+"&idObliga="+xObligatorio+'&idCompetencia='+xCompetencia+'&tipoSostiene='+xSostiene+'&tipoLogra='+xLogra+'&tipoContribuye='+xContribuye+'&tipoNA='+xNoAplica+'&tipoaporte='+selected);
  $('#resultadosNivel').hide();
  // $('#graficoNivel').hide();

}

//FUNCIONES PARA REPORTES EN EXCEL Y PDF ====================================
function exportaExcel(){

  var xIdCarrera    = $('#idCarreraNivel').val();
  var xFechaMalla   =	$('#fechaMallaNivel').val();
	var xTipoComp     = $('#idTipoCompetenciaNivel').val();
	var xObligatorio  = $('#idObligaNivel').val();
	var xCompetencia  = $('#idCompetenciaNivel').val();

  var selected = '';
  $('input[type=checkbox]').each(function(){
    if (this.checked) {
      selected += $(this).val()+',';
    }
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  window.open("xlsNivelAporteObjAprendizaje.php?idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&tipoCompetencia="+xTipoComp+'&obligatorio='+xObligatorio+'&idCompetencia='+xCompetencia+'&nivelaporte='+selected);

}


function exportaPDF(){

  var xIdCarrera    = $('#idCarreraNivel').val();
  var xFechaMalla   =	$('#fechaMallaNivel').val();
	var xTipoComp     = $('#idTipoCompetenciaNivel').val();
	var xObligatorio  = $('#idObligaNivel').val();
	var xCompetencia  = $('#idCompetenciaNivel').val();

  var selected = '';
  $('input[type=checkbox]').each(function(){
    if (this.checked) {
      selected += $(this).val()+',';
    }
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  window.open("pdfReporteNivelObjAprendizaje.php?idCarrera="+xIdCarrera+"&fechaMalla="+xFechaMalla+"&tipoCompetencia="+xTipoComp+'&obligatorio='+xObligatorio+'&idCompetencia='+xCompetencia+'&nivelaporte='+selected);

}
