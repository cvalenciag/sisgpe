<?php
  require_once 'valid.php';

  $idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
  $fechaMalla = (isset($_REQUEST['fechaMalla']) && !empty($_REQUEST['fechaMalla']))?$_REQUEST['fechaMalla']:'';
  $idTipoComp = (isset($_REQUEST['idTipoComp']) && !empty($_REQUEST['idTipoComp']))?$_REQUEST['idTipoComp']:'';
  $idObliga   = (isset($_REQUEST['idObliga']) && !empty($_REQUEST['idObliga']))?$_REQUEST['idObliga']:'';
  $idComp     = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';
  $tipoaporte = (isset($_REQUEST['tipoaporte']) && !empty($_REQUEST['tipoaporte']))?$_REQUEST['tipoaporte']:'';

  $tipoSostiene = (isset($_REQUEST['tipoSostiene']) && !empty($_REQUEST['tipoSostiene']))?$_REQUEST['tipoSostiene']:'';
  $tipoLogra = (isset($_REQUEST['tipoLogra']) && !empty($_REQUEST['tipoLogra']))?$_REQUEST['tipoLogra']:'';
  $tipoContribuye = (isset($_REQUEST['tipoContribuye']) && !empty($_REQUEST['tipoContribuye']))?$_REQUEST['tipoContribuye']:'';
  $tipoNA = (isset($_REQUEST['tipoNA']) && !empty($_REQUEST['tipoNA']))?$_REQUEST['tipoNA']:'';

  $nameCarrera    = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'");
  $resCarrera     = $nameCarrera->fetch_assoc();
  $nombreCarrera  = $resCarrera['descripcion'];


  $sWhere     = "";
  $otroWhere  = "";
  if($idObliga==3){
    $sWhere = "AND dcn.idTipo='$idTipoComp'";
  }

  if($idTipoComp==3){
    $sWhere = "AND dm.obligatoriedad='$idObliga'";
  }

  if($idTipoComp==3 || $idObliga==3 || $idComp==''){
    $sWhere = "";
  }


  if ($idComp!=0) {
    $otroWhere = "AND dcn.idCompetencia='$idComp'";
  }else {
    $otroWhere = "";
  }

  // $sql = "SELECT codObjGeneral, idCurso FROM detalle_curso_nivelaporte LEFT JOIN objgeneral USING (idObjgeneral) WHERE
  //         idCarrera=$idCarrera AND tipoaporte=1 GROUP BY idCurso";
  // $sql = "SELECT codObjGeneral, idObjgeneral FROM detalle_carrera_og LEFT JOIN objgeneral USING (idObjgeneral)
  //         WHERE idCarrera='$idCarrera'";
  $sql = "SELECT  obg.codObjGeneral, dcn.idCurso FROM detalle_curso_nivelaporte dcn LEFT JOIN
                      detalle_malla dm ON (dm.idCurso = dcn.idCurso) LEFT JOIN curso c ON (c.idCurso = dcn.idCurso)
                      LEFT JOIN departamento d ON (d.idDepartamento = c.idDepartamento)
                      LEFT JOIN competencia cc ON (cc.idCompetencia = dcn.idCompetencia)
                      LEFT JOIN tipocompetencia tc ON (tc.idTipo = cc.idTipo)
                      LEFT JOIN objgeneral obg ON (obg.idObjgeneral=dcn.idObjgeneral)
                      WHERE dcn.idCarrera='$idCarrera' AND tipoaporte IN ($tipoaporte)
                      $otroWhere $sWhere
                      GROUP BY obg.codObjGeneral
                      ORDER BY obg.codObjGeneral";

  // $sql2 = "SELECT codObjGeneral, idCurso FROM detalle_curso_nivelaporte LEFT JOIN objgeneral USING (idObjgeneral) WHERE
  //         idCarrera=$idCarrera AND tipoaporte=2 GROUP BY idCurso";
  //
  // $sql3 = "SELECT codObjGeneral, idCurso FROM detalle_curso_nivelaporte LEFT JOIN objgeneral USING (idObjgeneral) WHERE
  //         idCarrera=$idCarrera AND tipoaporte=3 GROUP BY idCurso";
  //
  // $sql4 = "SELECT codObjGeneral, idCurso FROM detalle_curso_nivelaporte LEFT JOIN objgeneral USING (idObjgeneral) WHERE
  //         idCarrera=$idCarrera AND tipoaporte=4 GROUP BY idCurso";


  $result = mysqli_query($conn, $sql);
  $result2 = mysqli_query($conn, $sql);
  $result3 = mysqli_query($conn, $sql);
  $result4 = mysqli_query($conn, $sql);

  $valoresY = array();
  $valoresX = array();

  $valoresY2 = array();
  $valoresX2 = array();

  $valoresY3 = array();
  $valoresX3 = array();

  $valoresY4 = array();
  $valoresX4 = array();

  while ($ver=mysqli_fetch_array($result)) {
    $valoresX[]=$ver[0];

    // $idObGral = $ver['idObjgeneral'];
    $codObGral = $ver['codObjGeneral'];

    // $tot1 = $conn->query("SELECT COUNT(*) totAporte1 FROM (SELECT codObjGeneral, idCurso FROM detalle_curso_nivelaporte LEFT JOIN
    //                       objgeneral USING (idObjgeneral) WHERE idCarrera=$idCarrera AND tipoaporte=1 GROUP BY idCurso) AS t1") or die(mysqli_error($conn));
    $tot1 = $conn->query("SELECT COUNT(*) totAporte1 FROM (SELECT * FROM detalle_curso_nivelaporte LEFT JOIN
                          objgeneral USING (idObjgeneral , idCompetencia) WHERE idCarrera='$idCarrera'
                          AND tipoaporte != 0 AND tipoaporte='$tipoContribuye' AND codObjGeneral = '$codObGral' GROUP BY idCurso) AS t1") or die(mysqli_error($conn));

    while ($r1 = mysqli_fetch_assoc($tot1)) {
      $valoresY[]=$r1['totAporte1'];
    }
  }

  while ($ver2=mysqli_fetch_array($result2)) {
    $valoresX2[]=$ver2[0];

    // $idObGral = $ver2['idObjgeneral'];
    $codObGral = $ver2['codObjGeneral'];

    $tot2 = $conn->query("SELECT COUNT(*) totAporte2 FROM (SELECT * FROM detalle_curso_nivelaporte LEFT JOIN
                          objgeneral USING (idObjgeneral , idCompetencia) WHERE idCarrera='$idCarrera'
                          AND tipoaporte != 0 AND tipoaporte='$tipoLogra' AND codObjGeneral = '$codObGral' GROUP BY idCurso) AS t2") or die(mysqli_error($conn));

    while ($r2 = mysqli_fetch_assoc($tot2)) {
      $valoresY2[]=$r2['totAporte2'];
    }

  }

  while ($ver3=mysqli_fetch_array($result3)) {
    $valoresX3[]=$ver3[0];

    // $idObGral = $ver3['idObjgeneral'];
    $codObGral = $ver3['codObjGeneral'];

    $tot3 = $conn->query("SELECT COUNT(*) totAporte3 FROM (SELECT * FROM detalle_curso_nivelaporte LEFT JOIN
                          objgeneral USING (idObjgeneral , idCompetencia) WHERE idCarrera='$idCarrera'
                          AND tipoaporte != 0 AND tipoaporte='$tipoSostiene' AND codObjGeneral = '$codObGral' GROUP BY idCurso) AS t3") or die(mysqli_error($conn));

    while ($r3 = mysqli_fetch_assoc($tot3)) {
      $valoresY3[]=$r3['totAporte3'];
    }
  }

  while ($ver4=mysqli_fetch_array($result4)) {
    $valoresX4[]=$ver4[0];

    // $idObGral = $ver4['idObjgeneral'];
    $codObGral = $ver4['codObjGeneral'];

    $tot4 = $conn->query("SELECT COUNT(*) totAporte4 FROM (SELECT * FROM detalle_curso_nivelaporte LEFT JOIN
                          objgeneral USING (idObjgeneral , idCompetencia) WHERE idCarrera='$idCarrera'
                          AND tipoaporte != 0 AND tipoaporte='$tipoNA' AND codObjGeneral = '$codObGral' GROUP BY idCurso) AS t4") or die(mysqli_error($conn));

    while ($r4 = mysqli_fetch_assoc($tot4)) {
      $valoresY4[]=$r4['totAporte4'];
    }
  }


  $datosX = json_encode($valoresX);
  $datosY = json_encode($valoresY);

  $datosX2 = json_encode($valoresX2);
  $datosY2 = json_encode($valoresY2);

  $datosX3 = json_encode($valoresX3);
  $datosY3 = json_encode($valoresY3);

  $datosX4 = json_encode($valoresX4);
  $datosY4 = json_encode($valoresY4);


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

  datosX3=crearBarrasV('<?php echo $datosX3 ?>');
  datosY3=crearBarrasV('<?php echo $datosY3 ?>');

  datosX4=crearBarrasV('<?php echo $datosX4 ?>');
  datosY4=crearBarrasV('<?php echo $datosY4 ?>');

  nameCarrera = ('<?php echo $nombreCarrera ?>');

  var trace1 = {
    x: datosX,
    y: datosY,
    text: datosY.map(String),
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'Contribuye',
    // orientation: 'v',
    marker: {
      color: '#1473E7',
      width: 1
    },
    type: 'bar'
  };

  var trace2 = {
    x: datosX2,
    y: datosY2,
    text: datosY2.map(String),
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'Logra',
    // orientation: 'v',
    marker: {
      color: '#EA3E3E',
      width: 1
    },
    type: 'bar'
  };

  var trace3 = {
    x: datosX3,
    y: datosY3,
    text: datosY3.map(String),
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'Sostiene',
    // orientation: 'v',
    marker: {
      color: '#A6E872',
      width: 1
    },
    type: 'bar'
  };

  var trace4 = {
    x: datosX4,
    y: datosY4,
    text: datosY4.map(String),
    textposition: 'auto',
    hoverinfo: 'none',
    name: 'No Aplica',
    // orientation: 'v',
    marker: {
      color: '#6F09BE',
      width: 1
    },
    type: 'bar'
  };

	var layout = {
    title: '<b>Total de Cursos por Nivel de Aporte al Objetivo de Aprendizaje <br> Carrera: '+nameCarrera+'</b>',
    barmode: 'stack',
    height: 550,
    font: {
      family: 'Arial',
      size: 12
    },

    margin: {
      l: 250,
      r: 20,
      t: 150,
      b: 70
    },

    yaxis: {
      autotick: false,
      ticks: 'outside',
      tick0: 0,
      dtick: 0,
      ticklen: 8,
      tickwidth: 4,
      tickcolor: '#000'
    },
  };


  var data = [trace1, trace2, trace3, trace4];

  Plotly.newPlot('graficoBarraH2', data, layout);
  </script>


</div>
