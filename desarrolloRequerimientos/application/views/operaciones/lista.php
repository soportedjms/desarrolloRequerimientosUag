<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        var usuario_borrar = 0;

        $(".show-delete-modal").click(function (event) {
            operacion_borrar = $(this).data("idoperacion");
        });

        $("#confirm-delete").click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/operaciones/eliminarOperacion",
                type: "POST",
                data: {idoperacion: operacion_borrar}
            }).done(function (data) {
                if (data == "no")
                {
                    alert("Hubo problemas al eliminar.");
                }
                else
                {
                    location.reload();
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Operaciones</h2>
    </header>
    <div class="row">
        <div class="col-md-6 col-lg-12 col-xl-6">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/operaciones/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Operaciones</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>

                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="nuevo" value="nuevo">
                                                <i class="glyphicon glyphicon-file"></i>Nueva operación</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id operación</th>
                                                        <th>Descripción</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($operaciones)) {
                                                        foreach ($operaciones as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idOperacion'] ?></td>
                                                                <td><?= $u['descripcion'] ?></td>
                                                                <td class="actions">
                                                                    <a href="<?php echo base_url(); ?>index.php/operaciones/editar/<?= $u['idOperacion'] ?>"><i class="fa fa-pencil"></i></a>
                                                                    <a class="show-delete-modal" href="#" data-idoperacion="<?= $u['idOperacion'] ?>" data-toggle="modal" data-target="#modal-eliminar">
                                                                        <i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                    <?php endforeach; } else { ?> <tr> <td> No hay información </td>  <?php } ?>
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
                    <p>¿Desea eliminar la operación?</p>
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