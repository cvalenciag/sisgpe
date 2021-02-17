function updatePuntajeEscrito(id){

  arr           = id.split('_');
  xIdRubrica    = arr[1];
  xIdCriterio   = arr[2];

  xValuePuntaje = $('#alumno_'+xIdRubrica+'_'+xIdCriterio).val();
  idEvaluador   = $('#isEvaluador').val();
  idEvaluacion  = $('#idEvaluacion').val();

  $.ajax({
      type: "POST",
      url: "gIniciarEvaluacionGrabar.php",
      data: 'idRubrica='+xIdRubrica+'&idCriterio='+xIdCriterio+'&puntaje='+xValuePuntaje+'&option=upEscrito'+'&idEvaluador='+idEvaluador+'&idEvaluacion='+idEvaluacion,

      success: function(data){
        if(data == 1){
          alert("El registro se actualizó correctamente.");
          $('#alumno_'+xIdRubrica+'_'+xIdCriterio).css("border", "");
        }else {
          alert("Valor fuera de rango, favor de verificar.");
          $('#alumno_'+xIdRubrica+'_'+xIdCriterio).css("border", "2px solid red");
          return false;
        }
      }
  });
}


function updatePuntajeOral(id){

  arr           = id.split('_');
  xIdRubrica    = arr[1];
  xIdCriterio   = arr[2];
  xIdAlumno     = arr[3];

  xValuePuntaje = $('#alumno_'+xIdRubrica+'_'+xIdCriterio+'_'+xIdAlumno).val();
  idEvaluador   = $('#isEvaluador').val();
  idEvaluacion  = $('#idEvaluacion').val();

  $.ajax({
      type: "POST",
      url: "gIniciarEvaluacionGrabar.php",
      data: 'idAlumno='+xIdAlumno+'&idRubrica='+xIdRubrica+'&idCriterio='+xIdCriterio+'&puntaje='+xValuePuntaje+'&option=upOral'+'&idEvaluador='+idEvaluador+'&idEvaluacion='+idEvaluacion,

      success: function(data){

        // var obj = JSON.parse(data); 
        // if(obj.estado == 1){
        if(data == 1){
          alert("El registro se actualizó correctamente.");
          $('#alumno_'+xIdRubrica+'_'+xIdCriterio+'_'+xIdAlumno).css("border", "");
          // xIdAlumno   = obj.idAlumno;
          // xTotalAlum  = obj.totalPuntaje;
          // $('#alm_'+xIdAlumno).html(xTotalAlum);

        // }else if(obj.estado == 0){
        }else{

          alert("Valor fuera de rango, favor de verificar.");
          $('#alumno_'+xIdRubrica+'_'+xIdCriterio+'_'+xIdAlumno).css("border", "2px solid red");
          // xIdAlumno   = obj.idAlumno;
          // xTotalAlum  = obj.totalPuntaje;
          // $('#alm_'+xIdAlumno).html(xTotalAlum);

          return false;
        }
      }
  });
}



function updateObservacion(id){

  arr         = id.split('_');
  xIdRubrica  = arr[1];
  xIdCriterio = arr[2];

  idEvaluacion  = $('#idEvaluacion').val();
  idEvaluador   = $('#isEvaluador').val();
  xValue        = $('#obs_'+xIdRubrica+'_'+xIdCriterio).val();
  // option        = 'upObs';

  // alert(xValue);

  if ($.trim(xValue).length <= 0) {
    alert('Es necesario capturar una observación, favor de verificar');
    return false;
  }

  $.ajax({
      type: "POST",
      url: "gIniciarEvaluacionGrabar.php",
      data: 'idRubrica='+xIdRubrica+'&idCriterio='+xIdCriterio+'&observa='+xValue+'&option=upObs'+'&idEvaluador='+idEvaluador+'&idEvaluacion='+idEvaluacion,

  }).done(function(respuesta){
      if (respuesta == '1') {
        alert("El registro se actualizó correctamente.");
      }
  });
}


function updateComentarios(){

  idEvaluacion  = $('#idEvaluacion').val();
  idEvaluador   = $('#isEvaluador').val();
  comentario    = $('#comentarioEval').val();
  option        = 'upComs';

  $.ajax({
      type: "POST",
      url: "gIniciarEvaluacionGrabar.php",
      data: '&option='+option+'&idEvaluador='+idEvaluador+'&idEvaluacion='+idEvaluacion+'&comentario='+comentario,

  }).done(function(respuesta){
      if (respuesta == '1') {
        alert("El registro se actualizó correctamente.");
      }
  });
}

function finalizarEvaluacion() {
  window.open('','_parent','');
  window.close();
  // window.opener.location.reload();

  $.ajax({
    type: 'POST',
    url: 'gIniciarEvaluacionGrabar.php',
   	data: '&idEvaluacion='+idEvaluacion+'&idEvaluador='+idEvaluador+'&option=ee',

  });
}



//ExPORTAR REPORTES ====================
function exportPDF(idEval, idUs){
  window.open("pdfReporteEvaluacion.php?idEvaluacion="+idEval+'&idUsuario='+idUs);
}
