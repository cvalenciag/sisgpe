<?php
require_once 'connect.php';

$idCarrera    = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
$idTipoComp = (isset($_REQUEST['idTipoComp']) && !empty($_REQUEST['idTipoComp']))?$_REQUEST['idTipoComp']:'';
$idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';
$idComp     = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
$tipoaporte = (isset($_REQUEST['tipoaporte']) && !empty($_REQUEST['tipoaporte']))?$_REQUEST['tipoaporte']:'';



$tipoContribuye = (isset($_REQUEST['tipoContribuye']) && !empty($_REQUEST['tipoContribuye']))?$_REQUEST['tipoContribuye']:'';
$tipoLogra = (isset($_REQUEST['tipoLogra']) && !empty($_REQUEST['tipoLogra']))?$_REQUEST['tipoLogra']:'';
$tipoSostiene = (isset($_REQUEST['tipoSostiene']) && !empty($_REQUEST['tipoSostiene']))?$_REQUEST['tipoSostiene']:'';
$tipoNA = (isset($_REQUEST['tipoNA']) && !empty($_REQUEST['tipoNA']))?$_REQUEST['tipoNA']:'';


$sWhere     = "";
$otroWhere  = "";
if($idObliga==3){
  $sWhere = "AND dcn.idTipo='$idTipoComp'";
}

if($idTipoComp==3){
  $sWhere = "AND dm.obligatoriedad='$idObliga'";
}

if($idTipoComp==3 || $idObliga==3){
  $sWhere = "";
}


if ($idComp!=0) {
  $otroWhere = "AND dcn.idCompetencia='$idComp'";
}else {
  $otroWhere = "";
}

// $sWhere     = "";
// // $otroWhere  = "";
// if($idObliga==3){
//   $sWhere = "AND dcn.idTipo='$idTipoComp'";
// }
//
// if($idTipoComp==3){
//   $sWhere = "AND dm.obligatoriedad='$idObliga'";
// }
//
//
// if ($idComp!=0) {
//   $sWhere = "AND dcn.idCompetencia='$idComp'";
// }
//
//
//
// if($idTipoComp==3 || $idObliga==3 || $idComp=='' || $idComp==0){
//   $sWhere = "";
// }


// else {
//   $otroWhere = "";
// }
?>

<!-- <div class=""> -->
  <!-- <label>Descargar</label> -->
  <table id="tableObj" class="table table-bordered" style="width:100%;" >
    <thead>
      <tr class="bg-primary">
        <th class="text-center" rowspan="2" style="width:10%">No. de <br> Obj general</th>
        <th class="text-center" rowspan="2" style="width:40%">Objetivo general</th>
        <th class="text-center" colspan="4" style="width:40%">Cantidad de cursos por nivel de aporte</th>
        <th class="text-center" rowspan="2" style="width:10%">Total cursos</th>
      </tr>
      <tr class="" bgcolor="#f0ad4e">
        <th class="text-center"><font color="white">Contribuye</font></th>
        <th class="text-center"><font color="white">Logra</font></th>
        <th class="text-center"><font color="white">Sostiene</font></th>
        <th class="text-center"><font color="white">No aplica</font></th>
      </tr>
      </tr>
    </thead>
		<tbody>
			<?php
				$qryObj = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, c.nombreCurso, dm.ciclo, c.idDepartamento, d.descripcion AS nomDepto,
                            dcn.idCompetencia, cc.descripcion AS nomCompetencia, tc.descripcion as nomTipoComp, dcn.fAprobacionPerfil, dcn.tipoaporte, dcn.idTipo, dcn.idObjgeneral, obg.definicion as nomObj, obg.codObjGeneral, dco.ordenamiento as ordenObjGral
                            FROM detalle_curso_nivelaporte dcn LEFT JOIN
                            detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
                            LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
                            LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
                            LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
                            LEFT JOIN objgeneral obg ON (obg.idObjgeneral=dcn.idObjgeneral)
                            LEFT JOIN detalle_carrera_og dco ON (dco.idObjgeneral = obg.idObjgeneral)
                            WHERE dcn.idCarrera='$idCarrera' AND tipoaporte IN ($tipoaporte)
                            $otroWhere $sWhere
                            GROUP BY dcn.idObjgeneral
                            ORDER BY dcn.idCurso , dcn.idCompetencia, dcn.idObjgeneral") or die(mysqli_error($conn));

				while ($resObj = mysqli_fetch_array($qryObj))
				{
					$idObGral  = $resObj['idObjgeneral'];
					$codObGral = $resObj['codObjGeneral'];
          $ordenGral = $resObj['ordenObjGral'];

          $orden1 = $ordenGral[0];
          $orden2 = $ordenGral[1];
          $orden3 = $ordenGral[2];

          $tipoAporte1 = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE tipoaporte='$tipoContribuye' AND idObjgeneral='$idObGral' GROUP BY idCurso ") or die(mysqli_error($conn));
          $totalTipo1 = $tipoAporte1->num_rows;

          $tipoAporte2 = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE tipoaporte='$tipoLogra' AND idObjgeneral='$idObGral' GROUP BY idCurso ") or die(mysqli_error($conn));
          $totalTipo2 = $tipoAporte2->num_rows;

          $tipoAporte3 = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE tipoaporte='$tipoSostiene' AND idObjgeneral='$idObGral' GROUP BY idCurso ") or die(mysqli_error($conn));
          $totalTipo3 = $tipoAporte3->num_rows;

          $tipoAporte4 = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE tipoaporte='$tipoNA' AND idObjgeneral='$idObGral' GROUP BY idCurso ") or die(mysqli_error($conn));
          $totalTipo4 = $tipoAporte4->num_rows;

          $T1 = ($tipoContribuye!='' ? $totalTipo1:0);
          $T2 = ($tipoLogra!='' ? $totalTipo2 : 0);
          $T3 = ($tipoSostiene!='' ? $totalTipo3 : 0);
          $T4 = ($tipoNA!='' ? $totalTipo4 : 0);

          $total = ($T1 + $T2 + $T3 + $T4);
			?>

			<tr>
				<td class="text-center"><?php echo '0'.$orden1.'.0'.$orden2.'.0'.$orden3 ?></td>
				<td class="text-justify"><?php echo $resObj['nomObj'] ?></td>
				<td class="text-center"><?php echo $T1 ?></td>
				<td class="text-center"><?php echo $T2 ?></td>
				<td class="text-center"><?php echo $T3 ?></td>
				<td class="text-center"><?php echo $T4 ?></td>
				<td class="text-center">
          <a href="#" onclick="showCursos('<?php echo $idObGral ?>')">
            <?php echo $total ?></td>
          </a>
			</tr>
			<?php
				}
			?>
		</tbody>

  </table>
<!-- </div> -->


<script type="text/javascript">
// $(document).ready( function () {
// 	$('#tableObj').DataTable( {
// 		"language": {
// 			"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
// 		},
// 			ordering	: false,
      // dom: 'Bfrtip',
        // buttons: [
        // {
        //   extend: 'pdf',
        //   text: '<img src="images/pdf.png" width=20 height=20/>',
        //   titleAttr: 'Exportar a pdf'
        // },
        // {
        //   extend: 'excel',
        //   text: '<img src="images/xls.png" width=20 height=20/>',
        //   titleAttr: 'Exportar a excel'
        // },
        // {
        //   extend: 'csv',
        //   text: '<img src="images/csv.png" width=20 height=20/>',
        //   titleAttr: 'Exportar a csv'
        // },
        // {
        //   extend: 'print',
        //   text: '<img src="images/print.png" width=20 height=20/>',
        //   titleAttr: 'Imprimir'
        // }],
// 			columnDefs: [ 
// 				{ width: "10%", targets: 0 },
// 				{ width: "70%", targets: 1 },
// 				{ width: "10%", targets: 2 },
// 				{ width: "10%", targets: 3 },
// 			],
// 		});
// });

function showCursos(idObjGral){

  var selected = '';
  $('input[type=checkbox]').each(function(){
    if (this.checked) {
      selected += $(this).val()+',';
    }
  });

  fin = selected.length - 1; // calculo cantidad de caracteres menos 1 para eliminar la coma final
  selected = selected.substr( 0, fin );

  urlModalEval = './modal/modalCursosReporte.php?tipoaporte='+selected+'&idObjgeneral='+idObjGral;
  $.get(urlModalEval, function(data){
    $('#modalCursosReporte').html(data).modal();
  })
}
</script>
