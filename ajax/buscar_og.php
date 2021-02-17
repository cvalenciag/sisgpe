	<?php
		if (isset($conn))
		{
	?>
			<!-- Modal -->
			<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Agregar objetivos generales </h4>
				  </div>
				  <div class="modal-body">
					<form class="form-horizontal">
                    <div class="form-group">
					<div class="col-sm-6">

					<label>Tipo de competencia:</label><br/>
					<select name = "idTipo" id = "tipo" required = "required" onchange="">
					<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
					<?php
					$qborrow = $conn->query("SELECT idTipo,descripcion FROM tipocompetencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
					while($fborrow = $qborrow->fetch_array()){
					?>
					<option value = "<?php echo $fborrow['idTipo']?>"><?php echo $fborrow['descripcion']?>
					</option>
					<?php
					}
					?>
					</select>
					</div></div>
					<div class="form-group">
					<div class="col-sm-6">

					<label>Competencia:</label><br/>
					<select name = "idCompetencia" id = "competencia" required = "required" onchange="">
					<option value = "" selected = "selected" disabled = "disabled">Seleccione una opción</option>
					<!--<?php
					/*$qborrow = $conn->query("SELECT idCompetencia,descripcion FROM competencia where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));
					while($fborrow = $qborrow->fetch_array()){*/
					?>
					<option value = "<?php //echo $fborrow['idCompetencia']?>"><?php //echo $fborrow['descripcion']?>
					</option>
					<?php
					//}
					?>-->
					</select>
					</div></div>
					<div class="form-group">
					<div class="col-sm-6">

					<input type="text" class="form-control" id="q" placeholder="Buscar objetivos generales" onkeyup="load(1)">
					</div>
					<button type="button" class="btn btn-default" onclick="load(1)">
						<span class='glyphicon glyphicon-search'></span> Buscar</button>
					</div>
					</form>
					<div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                    <div class="outer_div"></div><!-- Datos ajax Final -->
					</div>
					<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				  </div>
				</div>
			  </div>
			</div>
	<?php
		}
	?>
