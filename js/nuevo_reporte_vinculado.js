function returnHome(){
  window.location = "home.php";
}


$(document).ready(function(){

  $('#divReportesVinculo').hide();

  $("#idFacultadV").on('change', function () {
    elegido = $(this).val();
    	$.post("./ajax/agregar_reporteVinculado.php", { elegido: elegido }, function(data){
    		$("#idCarreraV").html(data);
      });
   });
});


$(document).ready(function(){
  $("#idCarreraV").on('change', function () {
    elegido2 = $(this).val();
      $.post("./ajax/agregar_reporteVinculado.php", { elegido2: elegido2 }, function(data){
        $("#fechaMallaV").html(data);
      });
   });
});


$("#fechaMallaV").on('change', function () {
  $("#idCarreraV option:selected").each(function () {
    var elegido3 =	$(this).val();
    $.post("./ajax/agregar_reporteVinculado.php", { elegido3: elegido3 }, function(data){
      $("#fechaPerfilV").html(data);
    });
  });
});



function generaReporteVinculado(){

  idFacultad  = $('#idFacultadV').val();
  idCarrera   = $('#idCarreraV').val();
  fechaMalla  = $('#fechaMallaV').val(); 
  fechaPerfil = $('#fechaPerfilV').val();

  if(idFacultad=='' || idCarrera=='' || fechaMalla=='' || fechaPerfil==''){
    alert('Es necesario capturar todos los valores, antes de generar el reporte.');
    return false;
  }

  $('#divReportesVinculo').show();
}

function exportaExcelVin(){

  idFacultad  = $('#idFacultadV').val();
  idCarrera   = $('#idCarreraV').val();
  fechaMalla  = $('#fechaMallaV').val();
  fechaPerfil = $('#fechaPerfilV').val();

  window.open("xlsReporteVinculado.php?idFacultad="+idFacultad+"&idCarrera="+idCarrera+"&fechaMalla="+fechaMalla+'&fechaPerfil='+fechaPerfil);

}
