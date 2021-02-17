function volverInicio(){
  window.location = "home.php";
}


$(document).ready(function(){

  $('#pestanas').hide();
  $('#grafico').hide();
  $('#resumen').hide();
  $('#divReportesLogros').hide();

});


function generaReporte(){

  $('#resumen').empty();
  $('#grafico').empty();

  var xIdCarrera			= $('#idCarrera').val();
  var xIdSemestre1		= $('#idSemestre1').val();
	var xIdSemestre2	  =	$('#idSemestre2').val();

  if(xIdSemestre1 == xIdSemestre2){
    alert('El valor del Semestre 2 debe ser diferente, favor de verificar.');
    return false;
  }

  if(xIdCarrera=='' && xIdSemestre1=='' && xIdSemestre2==''){
    alert('El reporte no se puede generar, favor de seleccionar los datos.');
    return false;
  }


  $('#pestanas').show();
  $('#resumen').show();
  $('#divReportesLogros').show();


	$.ajax({
		type: 'POST',
		url: './ajax/agregar_reportesLogrosCarrera.php',
		data: "&idCarrera="+xIdCarrera+"&semestre1="+xIdSemestre1+'&semestre2='+xIdSemestre2,

		beforeSend: function(objeto){
		},

		success: function(datos){
			$("#resumen").html(datos);
    }
	});
}


function showGrafico(){
  $('#pestanas').show();
  $('#grafico').show();
  $('#resumen').hide();

  var xIdCarrera			= $('#idCarrera').val();
  var xIdSemestre1		= $('#idSemestre1').val();
	var xIdSemestre2	  =	$('#idSemestre2').val();

  $('#grafico').load('reportesLogroCarrera2.php?idCarrera='+xIdCarrera+"&semestre1="+xIdSemestre1+"&semestre2="+xIdSemestre2);
}


function showResumen(){
  $('#resumen').show();
  $('#grafico').hide();
}
