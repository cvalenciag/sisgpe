function volverInicio(){
  window.location = "home.php";
}


$(document).ready(function(){
  $('#divReportesRubricaC').hide();

  $("#idCursoRC").on('change', function () {
    elegido = $(this).val();
    	$.post("./ajax/agregar_reportesRubricaCarrera3.php", { elegido: elegido }, function(data){
    		$("#fechaAprobacionRC").html(data);
      });
   });
});


function generaReporte(){

  $('#resultadosRubricaC').empty();

  var xIdCurso			  = $('#idCursoRC').val();
  var xIdModalidad		= $('#idModalidadRC').val();
	var xFechaRubrica	  =	$('#fechaAprobacionRC').val();


  if(xIdCurso=='' && xIdModalidad=='' && xFechaRubrica==''){
    alert('El reporte no se puede generar, favor de seleccionar los datos.');
    return false;
  }

  // $('#botones').show();
  $('#resultadosRubricaC').show();
  $('#divReportesRubricaC').show();

  if(xIdModalidad==1){
    file = './ajax/agregar_reportesRubricaCarrera.php';
  }else {
    file = './ajax/agregar_reportesRubricaCarrera2.php';
  }


	$.ajax({
		type: 'POST',
		url:  file,
		data: "&idCurso="+xIdCurso+'&fechaRubC='+xFechaRubrica,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resultadosRubricaC").html(datos);

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
  

function exportaExcelRubC(){

  var xIdCurso			  = $('#idCursoRC').val();
  var xIdModalidad		= $('#idModalidadRC').val();
	var xFechaRubrica	  =	$('#fechaAprobacionRC').val();

  window.open("xlsReporteRubricaCarrera.php?idCurso="+xIdCurso+"&modalidad="+xIdModalidad+"&fechaRubC="+xFechaRubrica);
}


function exportaPDFRubC(){

  var xIdCurso			  = $('#idCursoRC').val();
  var xIdModalidad		= $('#idModalidadRC').val();
  var xFechaRubrica	  =	$('#fechaAprobacionRC').val();

  window.open("pdfReporteRubricaCarrera.php?idCurso="+xIdCurso+"&modalidad="+xIdModalidad+"&fechaRubC="+xFechaRubrica);
}
