<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        var archivo_borrar = 0;

        $(".show-delete-modal").click(function (event) {
            archivo_borrar = $(this).data("idarchivo");
        });

        $("#confirm-delete").click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/artefactos/eliminarArchivo",
                type: "POST",
                data: {idarchivo: archivo_borrar}
            }).done(function (data) {
                if (data == "no")
                {
                    alert("Hubo problemas al eliminar.");
                }
                else if (data == "ok")
                {
                    location.reload();
                }
                else
                {
                    alert(data);
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
                    <form id="formInicial" action="<?php echo base_url(); ?>index.php/artefactos/nuevoArchivo" method="POST" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Agregar archivos de artefactos</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>
                                            <input type="hidden" name="idArtefacto" value="<?= $idArtefacto ?>" />
                                            <span ><h3><b>Seleccionar archivo</b></h3></span>
                                            <input type="file" name="userfile" class="fileupload-new"/><br>
                                            <input type="submit" name="submit" value="Cargar archivo" class="fileupload-new" />
                                        </div>     

                                        <br>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id archivo</th>
                                                        <th>Nombre</th>
                                                        <th>URL</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if (!empty($archivos)) {
                                                        foreach ($archivos as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idArchivo'] ?></td>
                                                                <td><?= $u['nombre'] ?></td> 
                                                                <td> <a href="<?= $u['url'] ?>" target="_blank"><?= $u['url'] ?></a></td>
                                                                <td class="actions">
                                                                    <a class="show-delete-modal" href="#" data-idarchivo="<?= $u['idArchivo'] ?>" 
                                                                       data-toggle="modal" data-target="#modal-eliminar">
                                                                        <i class="fa fa-trash-o"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        endforeach;
                                                    } else {
                                                        ?> <tr> <td> No hay archivos agregados </td>  <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-1">
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/artefactos'">
                                                    <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
                                            </div>
                                        </div>
                                    </footer>
                                    <?php if (!empty($mensaje)) { ?>
                                        <div class="alert alert-danger" role="alert"><?= $mensaje ?></div>
                                    <?php } ?>
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
                    <p>¿Desea eliminar el archivo?</p>
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