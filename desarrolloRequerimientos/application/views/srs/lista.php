<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

    });
</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>SRS</h2>
    </header>
    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/srs/consulta" >
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Filtro</h2>
                    </header>
                    <div class="panel-body">
                        <label class="col-sm-1 control-label">Proyecto </label>
                        <div class="col-sm-4">
                            <?php
                            if (!empty($consulta['idProyecto'])) {
                                llenaComboProyectos($consulta['idProyecto']);
                            } else {
                                llenaComboProyectos('');
                            }
                            ?>          
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" >
                                <i class="glyphicon glyphicon-search"></i> Consultar</button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <section class="panel">
                <div class="panel-body">
                    <form id="formGuardar" method="post" action="<?php echo base_url(); ?>index.php/srs/nuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Consulta de SRS</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>                                                
                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" >
                                                <i class="glyphicon glyphicon-file"></i> Nuevo SRS</button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table mb-none" id="requerimientos">
                                                <thead>
                                                    <tr>
                                                        <th>Id SRS</th>
                                                        <th>Propósito</th>
                                                        <th>Linea base</th>
                                                        <th>Proyecto</th>
                                                        <th>Usuario creación</th>
                                                        <th>Fecha creación</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($srs)) {
                                                        foreach ($srs as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idSRS'] ?></td>
                                                                <td><?= $u['proposito'] ?></td>
                                                                <td><?= $u['nombreLineaBase'] ?></td>
                                                                <td><?= $u['nombreProyecto'] ?></td>
                                                                <td><?= $u['nombreUsrCreacion'] ?></td>
                                                                <td><?= $u['fechaCreacion'] ?></td>
                                                                <td class="actions">
                                                                    <a href="<?php echo base_url(); ?>index.php/srs/detalle/<?= $u['idSRS'] ?>/<?= $u['idLineaBase'] ?>/<?= $u['idProyecto'] ?> "><i class="glyphicon glyphicon-search"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        endforeach;
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