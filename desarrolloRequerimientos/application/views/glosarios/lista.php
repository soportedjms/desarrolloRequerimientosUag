<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Glosarios</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/glosarios/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Glosarios</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>

                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="nuevo" value="nuevo">
                                                <i class="glyphicon glyphicon-file"></i>Nuevo glosario</button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id glosario</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
                                                        <th>Objetivo</th>
                                                        <th>Proyecto</th>
                                                        <th>Estatus</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    if (!empty($glosarios)) {
                                                        foreach ($glosarios as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idGlosario'] ?></td>
                                                                <td><?= $u['nombre'] ?></td>
                                                                <td><?= $u['descripcion'] ?></td>
                                                                <td><?= $u['objetivo'] ?></td>
                                                                <td><?= $u['nombreProyecto'] ?></td>
                                                                <td><?= $u['descEstatus'] ?></td>
                                                                <td class="actions">
                                                                    <a href="<?php echo base_url(); ?>index.php/glosarios/editar/<?= $u['idGlosario'] ?>"><i class="fa fa-pencil"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach;
                                                    } else {
                                                        ?> <tr> <td> No hay información </td>  <?php } ?>
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