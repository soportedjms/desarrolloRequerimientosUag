<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        var usuario_borrar = 0;

        $(".show-delete-modal").click(function (event) {
            usuario_borrar = $(this).data("idusuario");
        });

        $("#confirm-delete").click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/usuarios/eliminarUsuario",
                type: "POST",
                data: {idusuario: usuario_borrar}
            }).done(function (data) {
                if (data=="no")
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
        <h2>Usuarios</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/usuarios/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Usuarios</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>

                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="nuevo" value="nuevo">
                                                <i class="glyphicon glyphicon-file"></i>Nuevo usuario</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id Usuario</th>
                                                        <th>Usuario</th>
                                                        <th>Password</th>
                                                        <th>Nombre</th>
                                                        <th>Correo</th>
                                                        <th>Es administrador</th>
                                                        <th>Roles</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php  if (!empty($usuarios)) { 
                                                    foreach ($usuarios as $u): ?>
                                                        <tr>
                                                            <td><?= $u['idUsuario'] ?></td>
                                                            <td><?= $u['usuario'] ?></td>
                                                            <td><?= $u['password'] ?></td>
                                                            <td><?= $u['nombre'] ?></td>
                                                            <td><?= $u['correo'] ?></td>
                                                            <td><?= $u['esAdministrador'] ?></td>
                                                            <td><a href="<?php echo base_url(); ?>index.php/usuarios/editar/<?= $u['idUsuario'] ?>">Ver roles</a></td>
                                                            <td class="actions">
                                                                <a href="<?php echo base_url(); ?>index.php/usuarios/editar/<?= $u['idUsuario'] ?>"><i class="fa fa-pencil"></i></a>
                                                                <a class="show-delete-modal" href="#" data-idusuario="<?= $u['idUsuario'] ?>" data-toggle="modal" data-target="#modal-eliminar">
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
                    <p>¿Desea eliminar el usuario?</p>
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