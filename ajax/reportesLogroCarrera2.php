<?php
require_once 'valid.php';

$idCarrera  = (isset($_REQUEST['idCarrera']) && !empty($_REQUEST['idCarrera']))?$_REQUEST['idCarrera']:'';
$semestre1 	= (isset($_REQUEST['semestre1']) && !empty($_REQUEST['semestre1']))?$_REQUEST['semestre1']:'';
$semestre2  = (isset($_REQUEST['semestre2']) && !empty($_REQUEST['semestre2']))?$_REQUEST['semestre2']:'';


$nameCarrera    = $conn->query("SELECT * FROM carrera WHERE idCarrera='$idCarrera'");
$resCarrera     = $nameCarrera->fetch_assoc();
$nombreCarrera  = $resCarrera['descripcion'];


$sql = "SELECT dr.idCompetencia, descripcion FROM rubrica r
LEFT JOIN detalle_rubrica dr ON(dr.idRubrica=r.idRubrica)
LEFT JOIN competencia c ON (c.idCompetencia = dr.idCompetencia) GROUP BY dr.idCompetencia";


$result = mysqli_query($conn, $sql);


$valoresY = array();
$valoresX = array();


while ($ver=mysqli_fetch_array($result)) {
  $valoresY[]=$ver[0];

  $idCompetencia = $ver['idCompetencia'];

}


$datosX = json_encode($valoresX);
$datosY = json_encode($valoresY);

// var_dump($datosY);

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

  nameCarrera = ('<?php echo $nombreCarrera ?>');

  var trace1 = {
    x: datosX,
    y: datosY,
    text: datosX.map(String),
    // text: total,
    textposition: 'auto',
    hoverinfo: 'none',
    // name: 'SI Aporta',
    orientation: 'h',
    marker: {
      color: '#2271B3',
      width: 1
    },
    type: 'bar'
  };


	var layout = {
    title: 'Carrera: '+nameCarrera,
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


  var data = [trace1];

  Plotly.newPlot('graficoBarraH2', data, layout);
  </script>

</div>
