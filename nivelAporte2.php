<?php
require_once 'valid.php';

$idCarrera    = (isset($_REQUEST['carrera']) && !empty($_REQUEST['carrera']))?$_REQUEST['carrera']:'';
$fechaPerfil  = (isset($_REQUEST['fechaPerfil']) && !empty($_REQUEST['fechaPerfil']))?$_REQUEST['fechaPerfil']:'';
$idCurso      = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';
$idCiclo      = (isset($_REQUEST['cicloObj']) && !empty($_REQUEST['cicloObj']))?$_REQUEST['cicloObj']:'';


$qfila  = $conn->query("SELECT descripcion FROM carrera where estado=1 and idCarrera='$idCarrera'") or die(mysqli_error($conn));
$fcarre = $qfila->fetch_assoc();

$qfila2 = $conn->query("SELECT nombreCurso FROM curso WHERE estado=1 AND idCurso='$idCurso'") or die(mysqli_error($conn));
$fcurso = $qfila2->fetch_assoc();
?>
 
<!-- <!DOCTYPE html> -->
<!-- <html lang = "eng">
  <php require("head.php"); ?>
	 <div class = "container-fluid">
    <php require("menu.php"); ?>
      <div class = "col-lg-1"></div>
        <div class = "col-lg-9 well" style = "margin-top:110px;background-color:fefefe;">
          <div class = "alert alert-jcr">Diseño curricular / Nivel de Aporte</div>

          <button id="btnVolver" type = "button" style = "float:right;" class = "btn btn-primary"><span class = "glyphicon glyphicon-circle-arrow-left"></span> Volver</button> -->

          <!-- <br> -->

          <div class = "form-group">
            <label>Malla curricular de la Carrera: </label>  <?php echo $fcarre['descripcion'];?>
          </div>

          <div class = "form-group">
            <label>Curso: </label>  <?php echo $fcurso['nombreCurso'];?>
          </div>

					<div class="form-group">
            <label>Ciclo: </label>  <?php echo $idCiclo ?>
          </div>

					<!-- <div class = "form-group">
            Fecha Perfil: <label><php echo $fechaPerfil;?></label>
					</div> -->

					<div id="admin_table">
              <table id="tableObjs" class="table table-bordered table-hover" style="width:100%;">
                <thead class="alert-info">
                  <tr>
                    <th class="text-center" width="10%">Tipo Competencia</th>
                    <th class="text-center" width="5%"></th>
                    <th class="text-center" width="20%">Competencia</th>
  									<th class="text-center" width="10%">Tipo de Objetivo de Aprendizaje</th>
  									<th class="text-center" width="5%"></th>
  									<th class="text-center" width="25%">Objetivos de Aprendizaje</th>
  									<th class="text-center" width="10%">Tipo de Aporte</th>
  								</tr>
                </thead>
                <tbody>

                <?php
                $qryRegistros = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso' ") or die(mysqli_error($conn));

                if($qryRegistros->num_rows==0)
                {

                  $qryObjetivosGenerales = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, eliminado) SELECT $idCarrera, $idCurso, c.idTipo, c.idCompetencia, 1, dco.idObjgeneral, 0, 0, 0 FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                                          LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                                          LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia)
                                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                                          LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                                          WHERE cog.fAprobacion='$fechaPerfil'") or die(mysqli_error($conn));

                  $qryNivelAporte = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$idCurso'") or die(mysqli_error($conn));

                  while($resNivelAporte = $qryNivelAporte->fetch_array())
                  {
                    $idObjGeneral   = $resNivelAporte['idObjgeneral'];

                    $qryObjetivosEspecificos = $conn->query("INSERT INTO detalle_curso_nivelaporte (idCarrera, idCurso, idTipo, idCompetencia, tipoobj, idObjgeneral, idObjespecifico, tipoaporte, eliminado) SELECT $idCarrera, $idCurso, c.idTipo, og.idCompetencia, 2, doge.idObjgeneral, doge.idObjespecifico, 0, 0 FROM detalle_og_oe doge
                    LEFT JOIN objespecifico obje ON (obje.idObjespecifico = doge.idObjespecifico) LEFT JOIN og_oe og ON (og.idObjgeneral=doge.idObjgeneral) LEFT JOIN competencia c ON (c.idCompetencia=og.idCompetencia) WHERE doge.idObjgeneral='$idObjGeneral'") or die(mysqli_error($conn));
                  }

                }
                // else {
                  // code...


                // $q_admin = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                //                         ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                //                         LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                //                         LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia)
                //                         LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                //                         LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                //                         WHERE cog.fAprobacion='$fechaPerfil' ORDER BY dcc.ordenamiento") or die(mysqli_error($conn));

                $q_admin = $conn->query("SELECT dcn.idCarrera, dcn.idCurso, dcn.idTipo, dcc.ordenamiento AS ordenTipoC, tc.descripcion AS descTipo, dcn.idCompetencia, c.descripcion AS descCompetencia, dcn.tipoobj, dco.ordenamiento AS ordenObjGral, dcn.idObjgeneral, obg.definicion AS descObGral, dcn.idObjespecifico, obe.definicion AS descObEsp
                FROM detalle_curso_nivelaporte dcn LEFT JOIN tipocompetencia tc ON (tc.idTipo = dcn.idTipo)
                LEFT JOIN competencia c ON (c.idCompetencia = dcn.idCompetencia) LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dcn.idObjgeneral) LEFT JOIN objespecifico obe ON (obe.idObjespecifico = dcn.idObjespecifico)
                LEFT JOIN detalle_carrera_og dco ON (dco.idObjgeneral = dcn.idObjgeneral) LEFT JOIN
                detalle_carrera_competencia dcc ON (dcc.idCompetencia = dcn.idCompetencia) WHERE dcn.idCarrera='$idCarrera' AND idCurso='$idCurso' ORDER BY dcn.idObjgeneral, dcn.idObjespecifico") or die(mysqli_error($conn));

                while($f_admin = $q_admin->fetch_array())
                {
                  $idObjGeneral     = $f_admin['idObjgeneral'];
                  $idObjEspecifico  = $f_admin['idObjespecifico'];

                  $qryOrden = $conn->query("SELECT * FROM detalle_og_oe WHERE idObjgeneral='$idObjGeneral' AND idObjespecifico='$idObjEspecifico' ORDER BY ordenamiento") or die(mysqli_error($conn));

                  $resOrden = $qryOrden->fetch_array();

                ?>
                  <tr class = "target">
                    <td class="text-center"><?php echo $f_admin['tipoobj'] == 1 ? $f_admin['descTipo'] : '' ?></td>
                    <td class="text-center"><?php echo $f_admin['tipoobj'] == 1 ? $f_admin['ordenTipoC'] : '' ?></td>
                    <td class="text-center"><?php echo $f_admin['tipoobj'] == 1 ? $f_admin['descCompetencia'] : '' ?></td>
                    <td class="text-center"><?php echo $f_admin['tipoobj'] == 1 ? 'General' : 'Específico' ?></td>
                    <td class="text-center"><?php echo $f_admin['tipoobj'] == 1 ? $f_admin['ordenObjGral'] : $resOrden['ordenamiento'] ?></td>
                    <td class="text-center"><?php echo $f_admin['descObGral']?></td>
                    <td class="text-justify">
                      <div class="form-group">
                        <select name="" id="<?php echo $f_admin['idTipo']?>_<?php echo $f_admin['idCompetencia']?>_<?php echo $f_admin['tipoobj']?>_<?php echo $f_admin['idObjgeneral']?>_<?php echo $f_admin['idObjespecifico']?>" required="required" onchange="saveAporte(this.id);">
                          <option value="" selected="selected">Elige un tipo de aporte</option>
                          <option value="1">Contribuye</option>
                          <option value="2">Logra</option>
                          <option value="3">Sostiene</option>
                          <option value="4">No aplica</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                <?php
                  // }
                }
                ?>

                <input type="hidden" name="" id="idCarreraMod" value="<?php echo $idCarrera?>"/>
                <input type="hidden" name="" id="idCursoMod" value="<?php echo $idCurso?>"/>
                <!-- <input type="hidden" name="" id="fechaPerfilMod" value="<?php echo $fechaPerfil?>"/> -->
                <!-- <input type="hidden" name="" id="idCicloMod" value="<?php echo $idCiclo?>"/> -->

                </tbody>
              </table>
          </div>


<!-- <script src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> -->
<script type="text/javascript">

// $(document).ready(function() {
//
//   $('#tableObjs').DataTable( {
//       "pageLength": 5,
// "language": {
//           "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
//       },
//       dom: 'Bfrtip',
//   lengthMenu: [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Mostrar todos' ]],
//       columnDefs: [
//     { width: "40%", targets: 0 },
//     { width: "20%", targets: 1 },
//     { width: "20%", targets: 2 },
//     { width: "20%", targets: 3 },
//   ],
//
//   } );
//
// });

// FUNCION PARA GRABAR DATOS=================================================================
function saveAporte(id){

  var arr           = id.split('_');
  var idTipo        = arr[0];
  var idCompetencia = arr[1];
  var idTipoObj     = arr[2];
  var idObjGral     = arr[3];
  var idObjEspec    = arr[4];

  var idTipoAporte  = $('#'+id).val();
  var xIdCarrera    = $('#idCarreraMod').val();
  var xIdCurso      = $('#idCursoMod').val();


  $.ajax({
      type: "POST",
      url: "nivelAporteGrabar2.php",
      data: "tipoCompetencia="+idTipo+'&idCompetencia='+idCompetencia+'&idTipoObj='+idTipoObj+'&idObGral='+idObjGral+'&idTipoAporte='+idTipoAporte+'&idCarrera='+xIdCarrera+'&idCurso='+xIdCurso+'&idObjEspe='+idObjEspec,

      beforeSend: function(objeto){
	    },

	    success: function(datos){
        alert("Registro agregado.");
		  }

  });

}
// FIN FUNCION PARA GRAGAR =================================================







</script>
