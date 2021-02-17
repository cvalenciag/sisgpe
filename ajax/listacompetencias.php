<?php
	require_once '../valid.php';

$accioncompetencia = (isset($_REQUEST['accioncompetencia']) && !empty($_REQUEST['accioncompetencia']))?$_REQUEST['accioncompetencia']:'';  
$idEvaluador = (isset($_REQUEST['idEvaluador']) && !empty($_REQUEST['idEvaluador']))?$_REQUEST['idEvaluador']:'';  
$idCompetencia = (isset($_REQUEST['idCompetencia']) && !empty($_REQUEST['idCompetencia']))?$_REQUEST['idCompetencia']:'';

if ($idEvaluador!='' && $idCompetencia!='')
    {
      if($accioncompetencia == 1)
      {
        $sql2=$conn->query("SELECT * FROM detalle_evaluador_competencia WHERE idEvaluador= '$idEvaluador' AND idCompetencia= '$idCompetencia'");
        if ($sql2->num_rows==0){
          $insert_tmp=mysqli_query($conn, "INSERT INTO detalle_evaluador_competencia (idEvaluador,idCompetencia) VALUES ('$idEvaluador','$idCompetencia')");
        }
      }else {
        $conn->query("delete from detalle_evaluador_competencia WHERE idEvaluador = '$idEvaluador' and idCompetencia='$idCompetencia'") or die(mysqli_error($conn));
      }

    }



$sql=$conn->query("SELECT idCompetencia,descripcion from competencia order by descripcion asc");
        if ($sql->num_rows>0) {
           ?>
      
 <table id = "table1" class = "table table-bordered table-hover" style="100%">
              <thead class = "alert-info">
                <tr>                  
                  <th>Competencias</th>  
                  <th>Acción</th>          
                </tr>
              </thead>
              <tbody>
							<?php
  while ($row=mysqli_fetch_array($sql))
  {
			$idCompetencia=$row["idCompetencia"];
			$sql2=$conn->query("select * from detalle_evaluador_competencia where idEvaluador= '$idEvaluador' and idCompetencia= '$idCompetencia'");
			if ($sql2->num_rows==1){
        $checked = 'checked = checked';
      }
      else{
        $checked = '';
      }

              ?>

              <tr class = "target">
                  <td><?php echo $row['descripcion']?></td>
                    <td class='text-center'>
						             <input type="hidden" id="idEvaluador" name="idEvaluador" value="<?php echo $idEvaluador;?>"/>
             <input type="checkbox" id="btnAdd_<?php echo $idCompetencia ?>" onclick="accion2(this.id)"
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

  function accion2(id)
  {
      arr         = id.split('_');
      idCompetencia     = arr[1];
      idEvaluador = $('#idEvaluador').val();
      accioncompetencia      = $('#btnAdd_'+idCompetencia).prop('checked')?1:0;

        $.ajax({
                        type: "GET",
                        url: "./ajax/listacompetencias.php",
                        data: "accioncompetencia="+accioncompetencia+"&idEvaluador="+idEvaluador+"&idCompetencia="+idCompetencia,
                            beforeSend: function(objeto){
                                $("#resultados").html("Mensaje: Cargando...");
                            },
                        success: function(){
                            //$("#resultados").html(datos);
              if (accioncompetencia == 1){
                alert("El registro se agregó correctamente.");
              }else{
                  alert("El registro se eliminó correctamente.");
                }
              }
          });

        }

</script>



							
								

					
					