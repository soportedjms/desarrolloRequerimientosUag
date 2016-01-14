<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Proyectos</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/proyectos/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Proyectos</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>

                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="nuevo" value="nuevo">
                                                <i class="glyphicon glyphicon-file"></i>Nuevo proyecto</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id proyecto</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th>Fecha inicio</th>
                                                        <th>Fecha término</th>
                                                        <th>Estatus</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if (!empty($proyectos)) {
                                                        foreach ($proyectos as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idProyecto'] ?></td>
                                                                <td><?= $u['nombre'] ?></td>
                                                                <td><?= $u['descripcion'] ?></td>
                                                                <td><?= $u['fechaInicio'] ?></td>
                                                                <td><?= $u['fechaTermino'] ?></td>
                                                                <td><?= $u['descEstatus'] ?></td>
                                                                <td class="actions">
                                                                    <a href="<?php echo base_url(); ?>index.php/proyectos/editar/<?= $u['idProyecto'] ?>"><i class="fa fa-pencil"></i></a>
                                                                </td>
                                                            </tr>
    <?php endforeach;
} else { ?> <tr> <td> No hay información </td>  <?php } ?>
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
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>