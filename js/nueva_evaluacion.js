$(document).ready(function(){
  $('#tableEval').DataTable( {
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },

    dom: 'Bfrtip',
      buttons: [
      {
        extend: 'pdf',
        text: '<img src="images/pdf.png" width=20 height=20/>',
        titleAttr: 'Exportar a pdf'
      },
      {
        extend: 'excel',
        text: '<img src="images/xls.png" width=20 height=20/>',
        titleAttr: 'Exportar a excel'
      },
      {
        extend: 'csv',
        text: '<img src="images/csv.png" width=20 height=20/>',
        titleAttr: 'Exportar a csv'
      },
      {
        extend: 'print',
        text: '<img src="images/print.png" width=20 height=20/>',
        titleAttr: 'Imprimir'
      }],
      columnDefs: [
        { width: "20%", targets: 0 },
        { width: "10%", targets: 1 },
        { width: "20%", targets: 2 },
        { width: "10%", targets: 3 },
        { width: "10%", targets: 4 },
        { width: "30%", targets: 5 },
      ],
    });
});


$(document).ready(function(){
  $('#btnRegistrar').attr("disabled", true);
  $('#addEvaluadores').attr("disabled", true);
  $('#showDetalles').attr("disabled", true);

  $('#addNew').click(function(){
    $(this).hide();
		  $('#returnNew').show();
      $('#admin_table').slideUp();
      $('#admin_form').slideDown();
    $('#returnNew').click(function(){
      $(this).hide();
        $('#addNew').show();
				$('#admin_table').slideDown();
				$('#admin_form').slideUp();
				window.location = 'gEvaluacion.php';
		});
	});
});

//SELECCIONAR CURSOS POR DEPARTAMENTO ============================================
$(document).ready(function(){
  $("#idDepAcad").on('change', function () {
    deptoAcad = $(this).val();
    $.post("./ajax/agregar_gEvaluacion.php", { deptoAcad: deptoAcad }, function(data){
      $("#idCurso").html(data);
    });
  });
});


//SELECCIONAR RUBIRCAS CONFORME A CURSO
$(document).ready(function(){
  $("#idCurso").on('change', function () {
    idCurso = $(this).val();
    $.post("./ajax/agregar_gEvaluacion.php", { idCurso: idCurso }, function(data){
      $("#idRubrica").html(data);
    });
  });
});



//MOSTRAR MODAL EVALUADORES ====================================================
function showModalEval(){
  idCurso       = $('#idCurso').val();
  idTipoEval    = $('#idTipoEval').val();
  idModalidad   = $('#idModalidad').val();
  idRubrica     = $('#idRubrica').val();
  idGrupoAlum   = $('#idGrupoAlum').val();

  editaEval     = $('#editEvaluadores').val();
  idEvaluacion  = $('#idEvaluacion').val();

  if(editaEval!=1){
    urlModalEval = './modal/modalAddEvaluadores.php?idCurso='+idCurso+'&idTipoEval='+idTipoEval+'&idModalidad='+idModalidad+'&idRubrica='+idRubrica+'&idGrupoAlum='+idGrupoAlum;
  }else {
    urlModalEval = './modal/modalAddEvaluadores.php?idCurso='+idCurso+'&idTipoEval='+idTipoEval+'&idModalidad='+idModalidad+'&editaEval='+editaEval+'&idEvaluacion='+idEvaluacion+'&idRubrica='+idRubrica+'&idGrupoAlum='+idGrupoAlum;
  }

  $.get(urlModalEval, function(data){
    $('#modalAddEvaluadores').html(data).modal();
  })
}


//FUNCION PARA MOSTRAR LOS DETALLES DEL GRUPO
function showDetalles(){

  idGrupoAlum   = $('#idGrupoAlum').val();

  urlModalEval = './modal/modalVerAlumnos.php?idGrupoAlum='+idGrupoAlum;

  $.get(urlModalEval, function(data){
    $('#modalVerAlumnos').html(data).modal();
  })
}


//MUESTRA LA EVALUACION REGISTRADA
function showRegistro(idEvaluacion){

  urlModalEval = './modal/modalVerRegistroEval.php?idEvaluacion='+idEvaluacion;

  $.get(urlModalEval, function(data){
    $('#modalVerRegistroEval').html(data).modal();
  })
}


function validaCampos(){

  xIdCarrera    = $('#idCarrera').val();
  xIdDepto      = $('#idDepAcad').val();
  xIdCurso      = $('#idCurso').val();
  xIdTipoEval   = $('#idTipoEval').val();
  xIdModalidad  = $('#idModalidad').val();
  xFechaEval    = $('#fechaEval').val();
  xSemestre     = $('#idSemestre').val();
  xIdRubrica    = $('#idRubrica').val();
  xIdGrupoAlum  = $('#idGrupoAlum').val();

  if(xIdCarrera=='' || xIdDepto=='' || xIdCurso=='' || xIdTipoEval=='' || xIdModalidad=='' || xFechaEval=='' || xSemestre=='' || xIdRubrica=='' || xIdGrupoAlum==''){
    $('#btnRegistrar').attr("disabled", true);
    $('#addEvaluadores').attr("disabled", true);
  }else {
    $('#btnRegistrar').attr("disabled", false);
    $('#addEvaluadores').attr("disabled", false);
  }


  if(xIdGrupoAlum == ''){
    $('#showDetalles').attr("disabled", true);
  }else {
    $('#showDetalles').attr("disabled", false);
  }

}


// FUNCION PARA GUARDAR LOS REGISTROS ==========================================
function saveEvaluacion(){

  // xIdCarrera    = $('#idCarrera').val();
  xIdDepto      = $('#idDepAcad').val();
  xIdCurso      = $('#idCurso').val();
  xIdTipoEval   = $('#idTipoEval').val();
  xIdModalidad  = $('#idModalidad').val();
  xFechaEval    = $('#fechaEval').val();
  xSemestre     = $('#idSemestre').val();
  xIdRubrica    = $('#idRubrica').val();
  xIdGrupoAlum  = $('#idGrupoAlum').val();

  if(xIdDepto=='' || xIdCurso=='' || xIdTipoEval=='' || xIdModalidad=='' || xFechaEval=='' || xSemestre=='' || xIdRubrica=='' || xIdGrupoAlum==''){
    $('#btnRegistrar').attr("disabled", true);
  }else {
    $('#btnRegistrar').attr("disabled", false);
  }


  if(xIdDepto==''){
    alert('Favor de capturar el Departamento Académico.');
    $('#idDepAcad').css("border", "2px solid red");
    return false;
  }else{
    $('#idDepAcad').css("border", "");
  }

  if(xIdCurso==''){
    alert('Favor de capturar el curso.');
    $('#idCurso').css("border", "2px solid red");
    return false;
  }else{
    $('#idCurso').css("border", "");
  }

  if(xIdTipoEval==''){
    alert('Favor de capturar el Tipo de evaluación.');
    $('#idTipoEval').css("border", "2px solid red");
    return false;
  }else{
    $('#idTipoEval').css("border", "");
  }

  if(xIdModalidad==''){
    alert('Favor de capturar la Modalidad.');
    $('#idModalidad').css("border", "2px solid red");
    return false;
  }else{
    $('#idModalidad').css("border", "");
  }

  if(xSemestre==''){
    alert('Favor de capturar el Semestre.');
    $('#idSemestre').css("border", "2px solid red");
    return false;
  }else{
    $('#idSemestre').css("border", "");
  }

  if(xIdRubrica==''){
    alert('Favor de capturar la Rúbrica.');
    $('#idRubrica').css("border", "2px solid red");
    return false;
  }else{
    $('#idRubrica').css("border", "");
  }
 
  if(xIdGrupoAlum==''){
    alert('Favor de capturar el Nombre de proyecto.');
    $('#idGrupoAlum').css("border", "2px solid red");
    return false;
  }else{
    $('#idGrupoAlum').css("border", "");
  }


  $.ajax({
    type: 'POST',
  	url: 'gEvaluacionGrabar.php',
  	data:"deptoAcad="+xIdDepto+"&idCurso="+xIdCurso+"&tipoEval="+xIdTipoEval+"&modalidad="+xIdModalidad+'&fechaEval='+xFechaEval+'&semestre='+xSemestre+'&idRubrica='+xIdRubrica+'&idGrupoAlum='+xIdGrupoAlum+'&cabecera=c',

  	beforeSend: function(objeto){
  	  $("#resultados").html("Mensaje: Cargando...");
  	},

  	success: function(datos){
  		$("#resultados").html(datos);

  		// if ( ($("#idResult").val()) == 2){
      //   alert("Debe registrar el detalle de cursos antes de grabar la malla.");
  		// 	$('#btnRegistrar').attr("disabled", true);
      //
  		// }else{
  		// 	$('#btnRegistrar').attr("disabled", false);
  		// }
  	}
  });
}



//FUNCION PARA MODIFICAR LA EVALUACION =========================================
function editEvaluacion(id){

  $('#returnNew').show();
  $('#returnNew').click(function(){
    $(this).hide();
    $('#edit_form').empty();
    $('#admin_table').show();
    $('#addNew').show();
  });

  $('#admin_table').fadeOut();
  $('#addNew').hide();
  $('#edit_form').load('gEvaluacionCargar.php?idEvaluacion='+id);
}

//FUNCION PARA INICIAR LA EVALUACION ===========================================
function iniciarEvaluacion(id){
    window.open('gIniciarEvaluacion.php?idEvaluacion='+id);
}




//FUNCION PARA REALIZAR CALCULOS ===============================================
function genCalculos(){
  $.ajax({
    type: 'POST',
  	url: 'generaCalculos.php',
  });
}
