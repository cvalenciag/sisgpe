<?php
require_once '../valid.php';
$session_id = $_SESSION['session_id'];

$editaAlum = (isset($_REQUEST['editar']) && !empty($_REQUEST['editar']))?$_REQUEST['editar']:'';

if($editaAlum == 2){
  $idGrupoAl = $_GET['idGrupoAlum'];
}


?>
<div class="modal-dialog modal-md" style="width:70%;" backdrop="true">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4>Agregar Alumnos</h4>
    </div>

    <div class="modal-body">
      <input type="hidden" name="" id="idGrupoAl" value="<?php echo $idGrupoAl ?>">
      <input type="hidden" name="" id="editarAlumnos" value="<?php echo $editaAlum ?>">

      <div class="admin_eval">
        <label>Descargar</label>
        <table id="tableAlumnos" class="table table-bordered table-hover" style="width:100%;">
          <thead>
            <tr class="alert-info">
              <th class="text-center">Código SII</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Apellido</th>
              <th class="text-center">Carrera</th>
              <th class="text-center">Agregar</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $qryAlumnos = $conn->query("SELECT * FROM alumno a LEFT JOIN carrera c ON (c.idCarrera=a.idCarrera) WHERE a.estado=1  ORDER BY idAlumno") or die(mysqli_error($conn));

            foreach ($qryAlumnos as $alumnos)
            {
            ?>
            <tr>
              <td class="text-center"><?php echo $alumnos['codSII'] ?></td>
              <td class="text-justify"><?php echo $alumnos['nomAlumno'] ?></td>
              <td class="text-justify"><?php echo $alumnos['apeAlumno'] ?></td>
              <td class="text-center"><?php echo $alumnos['descripcion'] ?></td>
              <td class="text-center">

              <?php
                $idAlumno = $alumnos['idAlumno']; 

                if($editaAlum == 2){
                  $qryGpoAlumno = $conn->query("SELECT * FROM detalle_grupoAlumno WHERE idGrupoAl='$idGrupoAl' AND idalumno='$idAlumno' AND estado=1") or die(mysqli_error($conn));
                }else {
                  $qryGpoAlumno = $conn->query("SELECT * FROM tmp WHERE idalumno='$idAlumno' AND idSession='$session_id'");
                }

                // $qryGpoAlumno = $conn->query("SELECT * FROM detalle_grupoAlumno WHERE idalumno='$idAlumno' AND idGrupoAl='$maxIdGpo'");

                if ($qryGpoAlumno->num_rows>0){
                  $var = "btn btn-danger btn-sm glyphicon glyphicon-ok";
                }else {
                  $var = "btn btn-success btn-sm glyphicon glyphicon-plus";
                }
              ?>

              <button type="button" name="button" class="<?php echo $var ?>"
                id="btnAddAlum_<?php echo $idAlumno ?>" onclick="saveAlumno(this.id)">
              </button>
            </td>
            </tr>
            <?php
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $('#tableAlumnos').DataTable( {
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },

    dom: 'Bfrtip',
      buttons: [
      {
        extend: 'pdf',
        text: '<img src="images/pdf.png" width=20 height=20/>',
        titleAttr: 'Exportar a pdf'
      },
      {
        extend: 'excel',
        text: '<img src="images/xls.png" width=20 height=20/>',
        titleAttr: 'Exportar a excel'
      },
      {
        extend: 'csv',
        text: '<img src="images/csv.png" width=20 height=20/>',
        titleAttr: 'Exportar a csv'
      },
      {
        extend: 'print',
        text: '<img src="images/print.png" width=20 height=20/>',
        titleAttr: 'Imprimir'
      }],
      columnDefs: [
        { width: "2%",  targets: 0 },
        { width: "33%", targets: 1 },
        { width: "33%", targets: 2 },
        { width: "30%", targets: 3 },
        { width: "2%",  targets: 4 },
      ],
    });
});


function saveAlumno(id){

  arr         = id.split('_');
  xIdAlumno   = arr[1];
  xIdGrupoAl  = $('#idGrupoAl').val();

  editarDatos = $('#editarAlumnos').val();

  $('#btnAddAlum_'+xIdAlumno).addClass("btn btn-danger glyphicon glyphicon-ok");


  if(editarDatos == 2){
    datos = 'xIdGpoAluE='+xIdGrupoAl+'&xIdAlumno='+xIdAlumno+'&detalleEdit=dA';
  }else {
    datos = 'idalumno='+xIdAlumno+'&detalle=d';
  }


  $.ajax({
    type: 'POST',
  	url: 'grupoAlumnoGrabar.php',
    data: datos,
    // data: "idGrupoAl="+xMaxId+'&idalumno='+xIdAlumno+'&detalle=d',

    beforeSend: function(objeto){
      $("#resultAlumnos").html("Mensaje: Cargando...");
    },

    success: function(datos){
      $("#resultAlumnos").html(datos);
    }

  }); //LLAVE AJAX
}
</script>
