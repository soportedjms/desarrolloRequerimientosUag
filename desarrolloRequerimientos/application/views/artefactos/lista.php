<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        var artefacto_borrar = 0;

        $(".show-delete-modal").click(function (event) {
            artefacto_borrar = $(this).data("idartefacto");
        });

        $("#confirm-delete").click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/artefactos/eliminarArtefacto",
                type: "POST",
                data: {idartefacto: artefacto_borrar}
            }).done(function (data) {
                if (data=="no")
                {
                    alert("Hubo problemas al eliminar.");
                }
                else if(data=="ok")
                {
                    location.reload();
                }
                else
                {
                    alert("El artefacto ya se encuentra asignado a un requerimiento, no se puede eliminar.");
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Artefactos</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/artefactos/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Artefactos</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>

                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="nuevo" value="nuevo">
                                                <i class="glyphicon glyphicon-file"></i>Nuevo artefacto</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id artefacto</th>
                                                        <th>Descripción</th>
                                                        <th>Descripción detallada</th>
                                                        <th>Estatus</th>
                                                        <th>Proyecto</th>
                                                        <th>Archivos</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php  if (!empty($artefactos)) { 
                                                    foreach ($artefactos as $u): ?>
                                                        <tr>
                                                            <td><?= $u['idArtefacto'] ?></td>
                                                            <td><?= $u['descripcion'] ?></td>
                                                            <td><?= $u['descripcionDetallada'] ?></td>
                                                            <td><?= $u['descEstatus'] ?></td>
                                                            <td><?= $u['nombreProyecto'] ?></td>
                                                            <td> <a href="<?php echo base_url(); ?>index.php/artefactos/cargarArchivos/<?= $u['idArtefacto'] ?>">Agregar archivos</a></td>
                                                            <td class="actions">
                                                                <a href="<?php echo base_url(); ?>index.php/artefactos/editar/<?= $u['idArtefacto'] ?>"><i class="fa fa-pencil"></i></a>
                                                                <a class="show-delete-modal" href="#" data-idartefacto="<?= $u['idArtefacto'] ?>" data-toggle="modal" data-target="#modal-eliminar">
                                                                    <i class="fa fa-trash-o"></i></a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;  } else {  ?> <tr> <td> No hay información </td>  <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <!--Delete -->
    <div class="modal fade" id="modal-eliminar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Desea eliminar el artefacto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button id="confirm-delete"  type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!---->
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>