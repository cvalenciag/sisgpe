<?php
require_once '../valid.php'; 

// ===============================================================================================================
$idCriterio	= (isset($_REQUEST['idCriterio']) && !empty($_REQUEST['idCriterio']))?$_REQUEST['idCriterio']:'';
$idSubCrite	= (isset($_REQUEST['idSubcriterio']) && !empty($_REQUEST['idSubcriterio']))?$_REQUEST['idSubcriterio']:'';


$deleteRegistro = mysqli_query($conn, "DELETE FROM subcriterio WHERE idSubcriterio='$idSubCrite' AND idCriterio='$idCriterio'");

echo '<script type = "text/javascript">
        alert("El registro se eliminó correctamente.");
      </script>';

?>

<div class="form-group">
	<table class="table table-bordered" style="width:100%;">
		<thead>
			<tr class="alert-info">
				<th class="text-center">Nivel</th>
				<th class="text-center">Descripción <br> del Nivel</th>
				<th class="text-center">Tipo de Puntaje</th>
				<th class="text-center">Total</th>
				<th class="text-center">Mínimo</th>
				<th class="text-center">Máximo</th>
				<th class="text-center">Peso</th>
				<th class="text-center">Funciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$qrySubCri = $conn->query("SELECT sc.idSubcriterio, sc.idNivel, n.descripcion as descNivel, sc.rango, sc.total, sc.minimo, sc.maximo, sc.descripcion as descSubCri, sc.peso FROM subcriterio sc LEFT JOIN nivel n USING (idNivel) WHERE idCriterio='$idCriterio' AND sc.estado=1") or die(mysqli_error($conn));

			foreach ($qrySubCri as $subcri)
			{
			?>
			<tr>
				<td class="text-center"><?php echo $subcri['descNivel'] ?></td>
				<td class="text-justify"><?php echo $subcri['descSubCri'] ?></td>
        <td class="text-center">
          <?php if ($subcri['rango'] == 1){
          ?>
            Fijo
          <?php
            }elseif($subcri['rango'] == 2) {
          ?>
            Por rango
          <?php
            }
          ?>
        </td>
        <td class="text-center">
          <?php if ($subcri['rango'] == 2){
          ?>
            --
          <?php
            }elseif($subcri['rango'] == 1) {
              echo $subcri['total'];
            }
          ?>
        </td>
        <td class="text-center">
          <?php if ($subcri['rango'] == 1){
          ?>
            --
          <?php
            }elseif($subcri['rango'] == 2) {
              echo $subcri['minimo'];
            }
          ?>
        </td>
        <td class="text-center">
          <?php if ($subcri['rango'] == 1){
          ?>
            --
          <?php
            }elseif($subcri['rango'] == 2) {
              echo $subcri['maximo'];
            }
          ?>
        </td>
				<td class="text-center"><?php echo $subcri['peso'].'%' ?></td>
				<td class="text-center">
					<button type="button" name="button" class="btn btn-success btn-xs" id="<?php echo $idCriterio.'_'.$subcri['idSubcriterio'] ?>" title="Edita Subcriterio" onclick="editSubCri(this.id);">
						<span class = "glyphicon glyphicon-edit"></span>
					</button>
					<button type="button" name="button" class="btn btn-danger btn-xs" id="<?php echo $idCriterio.'_'.$subcri['idSubcriterio'] ?>" title="Elimina Subcriterio" onclick="deleteSubCri(this.id);">
						<span class="glyphicon glyphicon-trash"></span>
					</button>
				</td>
			</tr>
			<?php
			}
			?>
		</tbody>
	</table>
</div>
