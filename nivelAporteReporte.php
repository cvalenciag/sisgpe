<?php

header('Pragma: public');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Content-Transfer-Encoding: none');
header('Content-type: application/x-msexcel'); // This should work for the rest
header('Content-Disposition: attachment; filename=Mallas_y_Competencias.xls');

require_once 'connect.php';

$idPerfilEgresado = $_REQUEST['idPerfilEgresado'];
$fechaPerfil      = $_REQUEST['fechaPerfil'];
$idCarrera        = $_REQUEST['idCarrera'];


$qryMalla = $conn->query("SELECT descripcion as nomCarrera FROM perfilegresado LEFT JOIN carrera USING (idCarrera) WHERE
                          idPerfilEgresado='$idPerfilEgresado'")or die(mysqli_error($conn));
$result = $qryMalla->fetch_array();


// CONSULTA DE OBJETIVOS GENERALES ========================================================================================
  $q_admin = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                          ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                          LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                          LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                          LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                          WHERE cog.fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera' ORDER BY dcc.ordenamiento") or die(mysqli_error($conn));


  $q_admin1 = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                          ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                          LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                          LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                          LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                          WHERE cog.fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera' ORDER BY dcc.ordenamiento") or die(mysqli_error($conn));


  $q_admin2 = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                          ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                          LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                          LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                          LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                          WHERE cog.fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera' ORDER BY dcc.ordenamiento") or die(mysqli_error($conn));


  $q_admin3 = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                          ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                          LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                          LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                          LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                          LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                          WHERE cog.fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera' GROUP BY c.idCompetencia") or die(mysqli_error($conn));


// CONSULTAS PARA SABER EL TOTAL DE TIPOS DE COMPETENCIA GENERALES==========================================================
  $countGral = $conn->query("SELECT COUNT(*) totalGral FROM detalle_carrera_og dco LEFT JOIN carrera_og co ON
                           (co.idCarreraOg=dco.idCarreraOg AND co.idCarrera = dco.idCarrera) LEFT JOIN objgeneral obj USING (idObjgeneral) LEFT JOIN
                           detalle_carrera_competencia dcc ON (dcc.idCompetencia = obj.idCompetencia AND dcc.idCarrera = dco.idCarrera)
                           LEFT JOIN competencia c ON (c.idCOmpetencia = dcc.idCompetencia) WHERE c.idTipo = 1
                           AND fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera'") or die(mysqli_error($conn));

  $resCountGral = $countGral->fetch_array();

  $countEspec = $conn->query("SELECT COUNT(*) totalEsp FROM detalle_og_oe doge LEFT JOIN og_oe og ON (og.idOgOe = doge.idOgOe)
                            LEFT JOIN objespecifico objesp ON (objesp.idObjespecifico = doge.idObjespecifico)
                            LEFT JOIN objgeneral obj ON (obj.idObjgeneral = doge.idObjgeneral)
                            LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = obj.idCompetencia)
                            LEFT JOIN competencia c ON (c.idCOmpetencia = dcc.idCompetencia)
                            WHERE c.idTipo = 1 AND fAprobacion = '$fechaPerfil' AND idCarrera='$idCarrera'") or die(mysqli_error($conn));

  $resCountEspec = $countEspec->fetch_array();

  $totalGral = $resCountGral['totalGral'] + $resCountEspec['totalEsp'];
// FIN CONSULTAS PARA SABER EL TOTAL DE TIPOS DE COMPETENCIA GENERALES=======================================================


// CONSULTAS PARA SABER EL TOTAL DE TIPOS DE COMPETENCIA ESPECIFICOS==========================================================
  $countGral1 = $conn->query("SELECT COUNT(*) totalGral FROM detalle_carrera_og dco LEFT JOIN carrera_og co ON
                           (co.idCarreraOg=dco.idCarreraOg AND co.idCarrera = dco.idCarrera) LEFT JOIN objgeneral obj USING (idObjgeneral) LEFT JOIN
                           detalle_carrera_competencia dcc ON (dcc.idCompetencia = obj.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                           LEFT JOIN competencia c ON (c.idCOmpetencia = dcc.idCompetencia) WHERE c.idTipo = 2
                           AND fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera'") or die(mysqli_error($conn));

  $resCountGral1 = $countGral1->fetch_array();

  $countEspec1 = $conn->query("SELECT COUNT(*) totalEsp FROM detalle_og_oe doge LEFT JOIN og_oe og ON (og.idOgOe = doge.idOgOe)
                            LEFT JOIN objespecifico objesp ON (objesp.idObjespecifico = doge.idObjespecifico)
                            LEFT JOIN objgeneral obj ON (obj.idObjgeneral = doge.idObjgeneral)
                            LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = obj.idCompetencia)
                            LEFT JOIN competencia c ON (c.idCOmpetencia = dcc.idCompetencia)
                            WHERE c.idTipo = 2 AND fAprobacion = '$fechaPerfil' AND idCarrera='$idCarrera'") or die(mysqli_error($conn));

  $resCountEspec1 = $countEspec1->fetch_array();

  $totalGral1 = $resCountGral1['totalGral'] + $resCountEspec1['totalEsp'];
  // echo $resCountGral1['totalGral'].'_'.$resCountEspec1['totalEsp'];
// FIN CONSULTAS PARA SABER EL TOTAL DE TIPOS DE COMPETENCIA ESPECIFICOS=======================================================

?>

<table class="table table-bordered" border="1" id="table">
  <thead>
    <tr>
      <td colspan="3" rowspan="5" align="center">
        <p>
          <br>
          <font color="#9F4A95" size="5" face="Times New Roman">Malla Curricular: <br> <b><?php echo $result['nomCarrera']; ?></b></font>
          <br>
          <font size="3.5" face="Times New Roman"><b>(Ciclo - Curso)</b></font>
          <!-- <br><br><br> -->
          <!-- <font color="#FFC000" size="2" face="Times New Roman"><b>Amarillo</b></font> = Contribuye al objetivo de aprendizaje. <br>
          <font color="#70AD47" size="2" face="Times New Roman"><b>Verde</b></font> = Logra el objetivo de aprendizaje. <br>
          <font color="#9F4A95" size="2" face="Times New Roman"><b>Lila</b></font> = Sostiene el objetivo de aprendizaje. -->
        </p>
      </td>

      <td colspan="<?php echo $totalGral ?>" bgcolor="#305496"><font color="white" size="2" face="Times New Roman"><b>COMPETENCIAS SELLO UP</b></font></td>
      <td colspan="<?php echo $totalGral1 ?>" bgcolor="#9F4A95"><font color="white" size="2" face="Times New Roman"><b>COMPTENCIAS ESPECÍFICAS DE LA CARRERA</b></font></td>

    </tr>

<!-- ============================================================================================================= -->
    <!-- <tr>

    </tr> -->

<!-- ============================================================================================================= -->
    <tr>
<?php
        while ($fadmin3 = $q_admin3->fetch_array())
        {
          $idCompetencia    = $fadmin3['idCompetencia'];
          $descCompetencia  = $fadmin3['descComp'];

          $cadenas = $fadmin3['ordenObj'];
          $idx1    = $cadenas[0];

          $qryCompeGral = $conn->query("SELECT COUNT(*) totalCompGral FROM detalle_og_oe doge LEFT JOIN og_oe og ON
                                      (og.idOgOe=doge.idOgOe) LEFT JOIN objespecifico obje ON
                                      (obje.idObjespecifico = doge.idObjespecifico) LEFT JOIN objgeneral objg ON
                                      (objg.idObjgeneral = doge.idObjgeneral) LEFT JOIN competencia c ON (c.idCompetencia = objg.idCompetencia) WHERE c.idCompetencia = '$idCompetencia' AND fAprobacion = '$fechaPerfil'") or die(mysqli_error($conn));

          $resCompeGral   = $qryCompeGral->fetch_array();
          $totalCompGral  = $resCompeGral['totalCompGral'];


          $qryCompeEsp = $conn->query("SELECT COUNT(*) totalCompEspec FROM detalle_carrera_og dco INNER JOIN carrera_og dogo ON
                                     (dogo.idCarreraOg = dco.idCarreraOg AND dogo.idCarrera = dco.idCarrera) INNER JOIN
                                     objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral) INNER JOIN competencia c ON (c.idCompetencia = obg.idCompetencia) INNER JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                                     WHERE c.idCompetencia = '$idCompetencia' AND fAprobacion = '$fechaPerfil' AND dco.idCarrera='$idCarrera'") or die(mysqli_error($conn));

         $resCompeEsp   = $qryCompeEsp->fetch_array();
         $totalCompEsp  = $resCompeEsp['totalCompEspec'];

?>
          <td colspan="<?php echo ($totalCompGral+$totalCompEsp)  ?>">
            <font color="<?php echo $fadmin3['idTipo']==1 ? '#305496' : '#9F4A95' ?>" size="2" face="Times New Roman">
              <b><?php echo $idx1.'. '.$descCompetencia ?></b>
            </font>
          </td>
<?php
        }
?>
    </tr>

<!-- ============================================================================================================= -->
    <tr>
<?php
        while ($fadmin2 = $q_admin2->fetch_array())
        {
?>
      <td bgcolor="<?php echo $fadmin2['idTipo']==1 ? '#9BC2E6' : '#E2C0DE' ?>">
        <font size="2" face="Times New Roman"><b>Obj General</b></font></td>

<?php
          $idObjGeneral = $fadmin2['idObjgeneral'];

          $qryObjEsp = $conn->query("SELECT doge.idObjgeneral, doge.idObjespecifico, obje.definicion AS descObje, doge.ordenamiento as ordenObjetivo FROM detalle_og_oe doge LEFT JOIN objespecifico obje ON (obje.idObjespecifico=doge.idObjespecifico) WHERE doge.idObjgeneral='$idObjGeneral' ORDER BY doge.ordenamiento") or die(mysqli_error($conn));

          while ($f_admin2 = $qryObjEsp->fetch_array())
          {
?>

      <td bgcolor="<?php echo $fadmin2['idTipo']==1 ? '#DDEBF7' : '#F6EAF5' ?>">
        <font size="2" face="Times New Roman">Obj Específico</font></td>

<?php
          } //LLAVE OBJETIVOS ESPECIFICOS

        }// LLAVE OBJETIVOS GENERALES
?>
    </tr>

<!-- ============================================================================================================= -->
    <tr>
<?php
        while ($fadmin1 = $q_admin1->fetch_array())
        {
?>
      <!-- ORDEN OBJETIVO GENERAL -->
      <td bgcolor="<?php echo $fadmin1['idTipo']==1 ? '#9BC2E6' : '#E2C0DE' ?>">
        <font size="2" face="Times New Roman">

          <?php
            $cadena = $fadmin1['ordenObj'];
            $id1 = $cadena[0];
            $id2 = $cadena[1];
            $id3 = $cadena[2];
          ?>

        <b><?php echo '0'.$id1.'.0'.$id2.'.0'.$id3 ?></b>
      </font>
      </td>

<?php
          $idObjGeneral = $fadmin1['idObjgeneral'];

          $qryObjEsp = $conn->query("SELECT doge.idObjgeneral, doge.idObjespecifico, obje.definicion AS descObje, doge.ordenamiento as ordenObjetivo FROM detalle_og_oe doge LEFT JOIN objespecifico obje ON (obje.idObjespecifico=doge.idObjespecifico) WHERE doge.idObjgeneral='$idObjGeneral' ORDER BY doge.ordenamiento") or die(mysqli_error($conn));

          while ($f_admin2 = $qryObjEsp->fetch_array())
          {
              $cadena2 = $f_admin2['ordenObjetivo'];
              $ids1 = $cadena2[0];
              $ids2 = $cadena2[1];
              $ids3 = $cadena2[2];
?>
      <!-- ORDEN OBJETIVO ESPECIFICO -->
      <td bgcolor="<?php echo $fadmin1['idTipo']==1 ? '#DDEBF7' : '#F6EAF5' ?>">
        <font size="2" face="Times New Roman">
          <?php echo '0'.$ids1.'.0'.$ids2.'.0'.$ids3 ?>
        </font>
      </td>

<?php
          } //LLAVE OBJETIVOS ESPECIFICOS

        }// LLAVE OBJETIVOS GENERALES
?>
    </tr>

<!-- ============================================================================================================= -->
    <tr>
<?php
        while ($fadmin = $q_admin->fetch_array())
        {
?>
      <td bgcolor="<?php echo $fadmin['idTipo']==1 ? '#9BC2E6' : '#E2C0DE' ?>" style="width:180px; height:120px">
        <font size="1" face="Times New Roman">
          <b><?php echo $fadmin['descObj'] ?></b>
        </font>
      </td>

<?php
          $idObjGeneral = $fadmin['idObjgeneral'];

          $qryObjEsp = $conn->query("SELECT doge.idObjgeneral, doge.idObjespecifico, obje.definicion AS descObje, doge.ordenamiento as ordenObjetivo FROM detalle_og_oe doge LEFT JOIN objespecifico obje ON (obje.idObjespecifico=doge.idObjespecifico) WHERE doge.idObjgeneral='$idObjGeneral' ORDER BY doge.ordenamiento") or die(mysqli_error($conn));

          while ($f_admin2 = $qryObjEsp->fetch_array())
          {
?>

      <td bgcolor="<?php echo $fadmin['idTipo']==1 ? '#DDEBF7' : '#F6EAF5' ?>" style="width:180px; height:120px">
        <font size="1" face="Times New Roman">
          <b><?php echo $f_admin2['descObje'] ?></b>
        </font>
      </td>

<?php
          } //LLAVE OBJETIVOS ESPECIFICOS

        }// LLAVE OBJETIVOS GENERALES
?>
    </tr>

  </thead>

  <?php
    $qryCursos = $conn->query("SELECT * FROM perfilegresado p LEFT JOIN detalle_malla dm USING (idCarrera) LEFT JOIN curso c ON
                              (c.idCurso=dm.idCurso) LEFT JOIN departamento dep ON (dep.idDepartamento = c.idDepartamento) WHERE p.idPerfilEgresado='$idPerfilEgresado' AND p.idCarrera='$idCarrera' ORDER BY ciclo , nombreCurso") or die(mysqli_error($conn));


    $qryCount = $conn->query("SELECT COUNT(*) as total FROM perfilegresado p LEFT JOIN detalle_malla dm USING (idCarrera)
                              LEFT JOIN curso c ON (c.idCurso=dm.idCurso) WHERE p.idPerfilEgresado='$idPerfilEgresado' AND p.idCarrera='$idCarrera' ORDER BY ciclo , nombreCurso") or die(mysqli_error($conn));
    $resultCount = $qryCount->fetch_array();
  ?>


  <tbody>
    <!-- INICIO CODIGO PARA ESCRIBIR CURSOS -->
<?php
      while($f_admin = $qryCursos->fetch_array())
      {
?>
      <tr>
        <td align="center" style="width:20px;"><font size="2" face="Times New Roman"><b><?php echo $f_admin['ciclo']; ?></b></font></td>
        <td align="justify" style="width:160px;"><font size="2" face="Times New Roman"><b><?php echo $f_admin['nombreCurso']; ?></b></font></td>
        <td align="center" style="width:130px;"><font size="2" face="Times New Roman"><b><?php echo $f_admin['descripcion']; ?></b></font></td>

<?php
        $qadmin = $conn->query("SELECT c.idTipo, c. idCompetencia, tc.descripcion AS descTipoC, dcc.ordenamiento AS
                                ordenComp, c.descripcion AS descComp, dco.idObjgeneral, dco.ordenamiento AS ordenObj, obg.definicion AS descObj FROM detalle_carrera_og dco LEFT JOIN objgeneral obg ON (obg.idObjgeneral = dco.idObjgeneral)
                                LEFT JOIN competencia c ON (c.idCompetencia = obg.idCompetencia)
                                LEFT JOIN detalle_carrera_competencia dcc ON (dcc.idCompetencia = c.idCompetencia AND dcc.idCarrera=dco.idCarrera)
                                LEFT JOIN tipocompetencia tc ON (tc.idTipo = c.idTipo)
                                LEFT JOIN carrera_og cog ON (cog.idCarreraOg = dco.idCarreraOg AND cog.idCarrera = dco.idCarrera)
                                WHERE cog.fAprobacion='$fechaPerfil' AND dco.idCarrera='$idCarrera' ORDER BY dcc.ordenamiento") or die(mysqli_error($conn));

        while ($radmin = $qadmin->fetch_array())
        {
          $r_idObjGral = $radmin['idObjgeneral'];

          // $r_idCarrera = $f_admin['IdCarrera'];
          $r_idCurso   = $f_admin['idCurso'];

          $qryResultadoAporte = $conn->query("SELECT * FROM detalle_curso_nivelaporte WHERE idCarrera='$idCarrera' AND idCurso='$r_idCurso' AND idObjgeneral='$r_idObjGral'") or die(mysqli_error($conn));

          while($results = $qryResultadoAporte->fetch_array())
          {
            if ($results['tipoaporte']==1)
            {
?>
              <td bgcolor="#FFC000"></td>
<?php
            }elseif ($results['tipoaporte']==2) {
?>
              <td bgcolor="#70AD47"></td>
<?php
            }elseif ($results['tipoaporte']==3) {
?>
              <td bgcolor="#9F4A95"></td>
<?php
            }else {
?>
              <td></td>
<?php
            }

          }
        }
?>

      </tr>
<?php
      }
?>
  <!-- FIN CODIGO PARA ESCRIBIR CURSOS -->

  </tbody>

</table>
