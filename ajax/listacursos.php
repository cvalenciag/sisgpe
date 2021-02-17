<?php
	require_once '../valid.php';

$accioncurso = (isset($_REQUEST['accioncurso']) && !empty($_REQUEST['accioncurso']))?$_REQUEST['accioncurso']:'';
$idEvaluador = (isset($_REQUEST['idEvaluador']) && !empty($_REQUEST['idEvaluador']))?$_REQUEST['idEvaluador']:'';
$idCurso = (isset($_REQUEST['idCurso']) && !empty($_REQUEST['idCurso']))?$_REQUEST['idCurso']:'';

if ($idEvaluador!='' && $idCurso!='')
    {
      if($accioncurso == 1)
			{
				$sql2=$conn->query("SELECT * FROM detalle_evaluador_curso WHERE idEvaluador= '$idEvaluador' AND idCurso= '$idCurso'");
	      if ($sql2->num_rows==0){
          $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_evaluador_curso (idEvaluador,idCurso) VALUES ('$idEvaluador','$idCurso')");
				}
      }else {
        $conn->query("delete from detalle_evaluador_curso WHERE idEvaluador = '$idEvaluador' and idCurso='$idCurso'") or die(mysqli_error($conn));
      }

    }

$sql=$conn->query("SELECT idCurso, nombreCurso from curso left join detalle_malla using (idCurso) where AoL=1 group by idCurso order by nombreCurso asc");
// $sql=$conn->query("SELECT idCurso,nombreCurso from curso left join detalle_malla using () order by nombreCurso asc
        if ($sql->num_rows>0) {
           ?>

 <table id = "table1" class = "table table-bordered table-hover" style="100%">
              <thead class = "alert-info">
                <tr>
                  <th>Cursos</th>
                  <th>Acción</th>
                </tr>
              </thead>
              <tbody>
		              <?php
  while ($row=mysqli_fetch_array($sql))
  {
      $idCurso=$row["idCurso"];
      $sql2=$conn->query("select * from detalle_evaluador_curso where idEvaluador= '$idEvaluador' and idCurso= '$idCurso'");
      if ($sql2->num_rows==1){
      	$checked = 'checked = checked';
      }
      else{
      	$checked = '';
      }

              ?>

                        <tr class = "target">
                  <td><?php echo $row['nombreCurso']?></td>
                    <td class='text-center'>
             <input type="hidden" id="idEvaluador" name="idEvaluador" value="<?php echo $idEvaluador;?>"/>
						 <input type="checkbox" id="btnAdd_<?php echo $idCurso ?>" onclick="accion1(this.id)"
						 <?php echo $checked ?> >

						 </button>

                        <!-- <a href="#" ><i  id="btnAdd"></i></a> -->
                        </td>
                  </tr>
                  <?php
  }

?>
                  </tbody>
            </table>

 <?php
    }
?>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 5px;
  text-align: left;
}
</style>

<script>

 	function accion1(id)
	{
			arr 				= id.split('_');
			idCurso 		= arr[1];
			idEvaluador = $('#idEvaluador').val();
			accioncurso 			= $('#btnAdd_'+idCurso).prop('checked')?1:0;

        $.ajax({
                        type: "GET",
                        url: "./ajax/listacursos.php",
                        data: "accioncurso="+accioncurso+"&idEvaluador="+idEvaluador+"&idCurso="+idCurso,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(){
                            //$("#resultados").html(datos);
              if (accioncurso == 1){
								alert("El registro se agregó correctamente.");
              }else{
                	alert("El registro se eliminó correctamente.");
                }
              }
          });

        }

</script>
