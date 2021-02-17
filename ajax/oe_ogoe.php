<?php
	require_once '../valid.php';
     $session_id= $_SESSION['session_id'];
	/*$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){*/

                $idObjgeneral = (isset($_REQUEST['idObjgeneral']) && !empty($_REQUEST['idObjgeneral']))?$_REQUEST['idObjgeneral']:'';
		 $idOgOe = (isset($_REQUEST['idOgOe']) && !empty($_REQUEST['idOgOe']))?$_REQUEST['idOgOe']:'';
		 $q = (isset($_REQUEST['q'])&& !empty($_REQUEST['q']))? mysqli_real_escape_string($conn,(strip_tags($_REQUEST['q'], ENT_QUOTES))):'';
		 $fAprobacion = (isset($_REQUEST['fAprobacion']) && !empty($_REQUEST['fAprobacion']))?$_REQUEST['fAprobacion']:'';
                $qfila = $conn->query("SELECT definicion FROM objgeneral where estado=1 and idObjgeneral='$idObjgeneral' ORDER BY definicion") or die(mysqli_error($conn));
                 $fcarre = $qfila->fetch_assoc();
               /* $fila = $qfila->fetch_assoc();
                ?>
             <label><?php echo "Objetivo general: " . $fila['definicion']; ?></label><br/>

<?php



		 $sTable = "objespecifico";*/
		 $sWhere = "";
		if ( $q != "" )
		{
			$sWhere = "WHERE definicion LIKE '%$q%' and estado = '1'";

		}
		else
		{
			$sWhere = " where estado = '1' order by definicion asc";
		}



                ?>

                <label style="font-size:20px !important;color:#286090;font-family:Century Gothic;"><?php echo "Objetivo general: " . $fcarre['definicion']; ?></label><br/>

		 <div class = "alert alert-success msj" style="text-align:center;">Objetivo específico agregado correctamente!!</div>

			<!-- ?>
			<div class="table-responsive"> -->

			  <!-- <table class="table" class="table table-striped table-bordered dt-responsive nowrap"> -->

<div id = "admin_table">

				<table id = "table2" class = "table table-bordered table-hover" style="width: 100%;">

					<thead class = "alert-info">

				<tr>
					<th class="text-center">Objetivo especifico</th>
					<th class="text-center">Ordenamiento</th>
					<th class="text-center">Agregar</th>
				</tr>
				</thead>
							<tbody>
				<?php

				$q_admin = $conn->query("select * from objespecifico $sWhere") or die(mysqli_error($conn));

			/*	if ($numrows>0){
				while ($row=mysqli_fetch_array($query)){*/
					while($row = $q_admin->fetch_array()){
					$idObjespecifico=$row['idObjespecifico'];
					$definicion=$row['definicion'];

					$sql=$conn->query("select * from tmp where idObjespecifico= '" .$idObjespecifico . "' and idObjgeneral= '" .$idObjgeneral . "' and fAprobacion= '" .$fAprobacion . "' and idSession='".$session_id."'");
					$fila2 = $sql->fetch_assoc();

					if ($sql->num_rows>0){
						$var = "btn btn-sm btn-danger glyphicon glyphicon-ok";

						$ordenamiento = $fila2["ordenamiento"];
					} else {
						$var ="btn btn-sm btn-success glyphicon glyphicon-plus";

						$ordenamiento = $fila2["ordenamiento"];
					}

					/*$fila = $result->fetch_assoc();*/
					?>
				<tr class = "target">

						<td><?php echo $definicion; ?></td>
						<td class='col-xs-1'>
						<div class="pull-right">
						<input type="text" class="form-control" style="text-align:right" id="ordenamiento_<?php echo $idObjespecifico; ?>"  value="<?php echo $ordenamiento;?>" >
						</div></td>

		<td class="text-center">

                                                            <input type="hidden" id="idObjgeneralf" value="<?php echo $idObjgeneral;?>"/>
                                                            <input type="hidden" id="idOgOef"value="<?php echo $idOgOe;?>"/>

                                                             <input type="hidden" id="fAprobacionf"value="<?php echo $fAprobacion;?>"/>
                                                               <a id="agregaOE" class="<?php echo $var;?>" href="#" value="<?php echo $idObjespecifico;?>"></a>

									</td>




					</tr>
					<?php
				}
				?>
				</tbody>
						</table>
					</div>

<script src = "https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

	<script type = "text/javascript">
	$(document).ready(function() {
    $('#table2').DataTable( {
        "pageLength": 5,
	"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        },
        dom: 'Lfrtip',
		lengthMenu: [[ 10, 25, 50, -1 ],[ '10 filas', '25 filas', '50 filas', 'Mostrar todos' ]],
        columnDefs: [
      { width: "60%", targets: 0 },
      { width: "20%", targets: 1 },
      { width: "20%", targets: 2 },
    ],

    } );

    $('.msj').hide();

     $("#table2").on("click", "#agregaOE", function(){
     	var id = $(this).attr('value');
                        var idOgOe = $("#idOgOef").attr('value');
                        var idObjgeneral = $("#idObjgeneralf").attr('value');
                        var fAprobacion = $("#fAprobacionf").attr('value');
                        var ordenamiento = $('#ordenamiento_'+id).val();

                        if (isNaN(ordenamiento))
			{
			alert('El dato no es válido');
			document.getElementById('ordenamiento_'+id).focus();
			$('#ordenamiento_'+id).css("border", "3px solid red");
			return false;
		}	else {
			$('#ordenamiento_'+id).css("border", "");
		}


			if (ordenamiento == '')
			{
			alert('El dato no debe estar vacío');
			document.getElementById('ordenamiento_'+id).focus();
			$('#ordenamiento_'+id).css("border", "3px solid red");
			return false;
		}else {
			$('#ordenamiento_'+id).css("border", "");
		}
		/*	else if (empty(ordenamiento))
			{
			alert('El dato no debe estar vacío');
			document.getElementById('ordenamiento_'+id).focus();
			return false;
			}*/
			//Fin validacion
			 // if ($(this).attr("class") == "btn btn-success glyphicon glyphicon-plus")

                        $(this).addClass("btn btn-sm btn-danger glyphicon glyphicon-ok");

                        $.ajax({


                        	 type: "POST",
        url: "./ajax/agregar_ogoe.php",
        data: "idObjespecifico="+id+"&ordenamiento="+ordenamiento+"&idObjgeneral="+idObjgeneral+"&idOgOe="+idOgOe+"&fAprobacion="+fAprobacion,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		 /* $('.msj').show();*/
		}
                });
		});




} );
</script>
