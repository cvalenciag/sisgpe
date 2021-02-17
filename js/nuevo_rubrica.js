//VALIDA QUE LA FECHA DE RUBRICA NO ESTE REGISTRADA ===================================
// function validaFecha()
// {
//   xIdCurso      = $('#idCurso').val();
//   xfAprobacion  = $('#fAprobacion').val();
//   xEstado       = $('#estado').val();
//
//   $.ajax({
//     type:'POST',
//     url: './ajax/validarRubrica.php',
//     data: 'idCurso='+xIdCurso+'&fAprobacion='+xfAprobacion+'&estado='+xEstado,
//     beforeSend: function(objeto){
//       $("#resultados").show();
//     },
//
//     success: function(datos){
//       if (datos==1){
//         alert("La fecha de aprobación para el curso seleccionado ya se encuentra registrado. Favor de modificar.");
//         $('#fAprobacion').css("border", "2px solid red");
//         $('#idCurso').css("border", "2px solid red");
//         $('#btnAddCriterios').attr("disabled", true);
//         $('#btnSaveRubrica').attr("disabled", true);
//         return false;
//       }else{
//         $('#btnSaveRubrica').attr("disabled", false);
//         $('#btnAddCriterios').attr("disabled", false);
//         $('#fAprobacion').css("border", "");
//         $('#idCurso').css("border", "");
//       }
//     }
//   });
// }


function showModalCriterios(edit, idRubrica){

  xIdCurso 		    = $('#idCurso').val();

  if(edit==2){
    urlModalNiveles = './modal/modalAddCriterios.php?idCurso='+xIdCurso+'&editar='+edit+'&idRubrica='+idRubrica;
  }else{
    urlModalNiveles = './modal/modalAddCriterios.php?idCurso='+xIdCurso;
  }

  $.get(urlModalNiveles, function(data){
    $('#modalAddCriterios').html(data).modal();
  })
}


function saveRubrica(){

	var xIdCurso            = $('#idCurso').val();
  var xfAprobacion        = $('#fAprobacion').val();
  var xEstado             = $('#estado').val();

	$.ajax({
		type: 'POST',
		url:  'rubricasGrabar.php',
		data: 'idCurso='+xIdCurso+'&fAprobacion='+xfAprobacion+'&estado='+xEstado+'&saveCabecera=sc',

		// beforeSend: function(objeto){
	  //   // $("#resultados").html("Mensaje: Cargando...");
		// },

		success: function(datos){
      $("#resultados").html(datos);
      if ( ($("#idResult").val()) == 0){
        alert("Los datos de la rubrica ya existen, favor de verificar.");
        window.location = "rubricas.php";
				// $("#idCurso").css("border", "3px solid red");
				// $("#fAprobacion").css("border", "3px solid red");
				// $("#resultados").show();
      }
	  }
	});
}
