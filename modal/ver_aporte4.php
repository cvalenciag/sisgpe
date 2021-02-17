<?php
  include 'connect.php';
  if (isset($conn))
  {
?>
    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg" id="miModalCursosEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nivel de Aporte</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class = "form-group">
              <div class="col-sm-6">
                <label>Departamento Acádemico:</label><br/>
                  <select name="deptoAcad" id="deptoAcadEdit" required="required" onchange="load(1)">
                    <option value = "" selected = "selected">Seleccione una opción</option>
                      <?php
                        $qborrow = $conn->query("SELECT idDepartamento,descripcion FROM departamento where estado=1 ORDER BY descripcion") or die(mysqli_error($conn));

                        while($fborrow = $qborrow->fetch_array())
                        {
                      ?>

                      <option value="<?php echo $fborrow['idDepartamento']?>"><?php echo $fborrow['descripcion']?></option>

                      <?php
					              }
                      ?>
                  </select>
                </div>
              </div>


              <div class = "form-group">
                <div class="col-sm-6">
                  <label>Obligatoriedad:</label><br/>
                    <select name="obligatorio" id="obligatorioEdit" required="required" onchange="load(1)">
                      <option value="" selected="selected">Seleccione una opción</option>
                      <option value="1">Si</option>
                      <option value="0">No</option>
                    </select>
                </div>
              </div>
          </form>

          <!-- Carga gif animado -->
          <div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div>

          <!-- Datos ajax Final -->
					<div class="outer_div2"></div>
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
