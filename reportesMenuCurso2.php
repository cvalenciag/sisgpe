<?php
  require_once 'valid.php';

  $idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
  $tipoComp   = (isset($_REQUEST['tipoComp']) && !empty($_REQUEST['tipoComp']))?$_REQUEST['tipoComp']:'';
  $idComps     = (isset($_REQUEST['idComp']) && !empty($_REQUEST['idComp']))?$_REQUEST['idComp']:'';
  $idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';

  $nameCarrera    = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'");
  $resCarrera     = $nameCarrera->fetch_assoc();
  $nombreCarrera  = $resCarrera['descripcion'];


  if($idComps == 0){
  	$sIdComp = "";
  }

  if($idComps!=0){
  	$sIdComp = "AND dcn.idCompetencia IN ($idComps)";
  }


  $sWhere = "";
  if($idObliga==3){
    $sWhere = "AND dcn.idTipo='$tipoComp'";
  }

  if($tipoComp==3){
    $sWhere = "AND dm.obligatoriedad='$idObliga'";
  }

  if($tipoComp==3 || $idObliga==3){
    $sWhere = "";
  }


  $sql = "SELECT descripcion, idCompetencia, dcn.idCurso FROM detalle_curso_nivelaporte dcn
          LEFT JOIN competencia USING (idCompetencia)
          LEFT JOIN detalle_malla dm ON (dm.idCurso = dcn.idCurso)
          WHERE dcn.idCarrera='$idCarrera' $sIdComp
          $sWhere AND tipoaporte IN (1,2,3) GROUP BY idCompetencia";

  $sql2 = "SELECT descripcion, idCompetencia, dcn.idCurso FROM detalle_curso_nivelaporte dcn
           LEFT JOIN competencia USING (idCompetencia)
           LEFT JOIN detalle_malla dm ON (dm.idCurso = dcn.idCurso)
           WHERE dcn.idCarrera='$idCarrera' $sIdComp
           $sWhere AND tipoaporte=4 GROUP BY idCompetencia";


  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql2);

  $valoresY = array();
  $valoresX = array();

  $valoresY2 = array();
  $valoresX2 = array();

  while ($ver=mysqli_fetch_array($result)) {
    $valoresY[]=$ver[0];

    $idCompetencia  = $ver['idCompetencia'];
    $idCurso        = $ver['idCompetencia'];

    $totalComp = $conn->query("SELECT COUNT(*) totalComp1 FROM (SELECT * FROM detalle_curso_nivelaporte dcn
                                    LEFT JOIN competencia USING (idCompetencia, idTipo) LEFT JOIN detalle_malla dm USING (idCarrera, idCurso, eliminado) WHERE dcn.idCarrera='$idCarrera'
                                    AND idCompetencia='$idCompetencia' AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere GROUP BY dcn.idCurso, dcn.idCompetencia) AS totComp1") or die(mysqli_error($conn));

    while ($resComp = mysqli_fetch_assoc($totalComp)) {
      $valoresX[]=$resComp['totalComp1'];
    }
  }

  while ($ver2=mysqli_fetch_array($result2)) {
    $valoresY2[]=$ver2[0];

    $idCompetencia2 = $ver2['idCompetencia'];
    $idCurso2       = $ver2['idCompetencia'];

    $qryNA = $conn->query("SELECT COUNT(*) totalNA FROM (SELECT dcn.idCarrera, dcn.idCurso, c.nombreCurso, dm.ciclo,
                          c.idDepartamento, d.descripcion AS nomDepto,
                          dcn.idCompetencia, cc.descripcion AS nomCompetencia, tc.descripcion AS nomTipoComp, dcn.fAprobacionPerfil, dcn.tipoaporte, dcn.idTipo, dm.obligatoriedad FROM detalle_curso_nivelaporte dcn LEFT JOIN detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
                          LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
                          LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
                          WHERE dcn.idCarrera='$idCarrera' $sIdComp AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere GROUP BY dcn.idCurso ORDER BY dcn.idCurso, dcn.idCompetencia) AS totNA") or die(mysqli_error($conn));
    $resQryNA = mysqli_fetch_assoc($qryNA);
    $totalGralNA = $resQryNA['totalNA'];

    $totalComp2 = $conn->query("SELECT COUNT(*) totalComp2 FROM (SELECT * FROM detalle_curso_nivelaporte dcn
                                    LEFT JOIN competencia USING (idCompetencia, idTipo) LEFT JOIN detalle_malla dm USING (idCarrera, idCurso, eliminado) WHERE dcn.idCarrera='$idCarrera'
                                    AND idCompetencia='$idCompetencia2' AND (tipoaporte!=0 AND tipoaporte!=4) $sWhere GROUP BY dcn.idCurso, dcn.idCompetencia) AS totComp2") or die(mysqli_error($conn));

    while ($resComp2 = mysqli_fetch_assoc($totalComp2)) {
      $totales = $totalGralNA - $resComp2['totalComp2']; 
      $valoresX2[]=$totales;
    }
  }

  $datosX = json_encode($valoresX);
  $datosY = json_encode($valoresY);

  $datosX2 = json_encode($valoresX2);
  $datosY2 = json_encode($valoresY2);


?>
<div id="graficoBarraH2" align="center">

  <script type="text/javascript">
    function crearBarrasV(json){
      var parsed = JSON.parse(json);
      var arr = [];

      for (var x in parsed){
        arr.push(parsed[x]);
      }

      return arr;
    }

  </script>

  <script type="text/javascript">

  datosX=crearBarrasV('<?php echo $datosX ?>');
  datosY=crearBarrasV('<?php echo $datosY ?>');

  datosX2=crearBarrasV('<?php echo $datosX2 ?>');
  datosY2=crearBarrasV('<?php echo $datosY2 ?>');

  nameCarrera = ('<?php echo $nombreCarrera ?>');

  var trace1 = {
    x: datosX,
    y: datosY,
    text: datosX.map(String),
    // text: total,
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'SI Aporta',
    orientation: 'h',
    marker: {
      color: '#2271B3',
      width: 1
    },
    type: 'bar'
  };

  var trace2 = {
    x: datosX2,
    y: datosY2,
    text: datosX2.map(String),
    // text: total2,
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'NO Aporta',
    orientation: 'h',
    marker: {
      color: '#A2CADF',
      width: 1
    },
    type: 'bar'
  };

	var layout = {
    title: '<b>Total de cursos que aportan a las competencias <br> Carrera: '+nameCarrera+'</b>',
    barmode: 'stack',
    height: 550,
    font: {
      family: 'Arial',
      size: 12
    },

    margin: {
      l: 350,
      r: 20,
      t: 150,
      b: 70
    },

    xaxis: {
      autotick: false,
      ticks: 'outside',
      tick0: 0,
      dtick: 0,
      ticklen: 8,
      tickwidth: 4,
      tickcolor: '#000'
    },
  };


  var data = [trace1, trace2];

  Plotly.newPlot('graficoBarraH2', data, layout);
  </script>


</div>
