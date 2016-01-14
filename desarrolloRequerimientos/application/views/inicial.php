<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Inicio</h2>
    </header>

    <div class="row">
        <div class="col-md-12 col-lg-4 col-xl-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-secondary">
                                <i class="fa fa-list-alt"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Requerimientos activos</h4>
                                <div class="info">
                                    <strong class="amount"><?= $totalReq['cantidad'] ?></strong>
                                    <span class="text-primary">(<?= $totalTerm['cantidad'] ?> Terminados)</span>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href='<?php echo base_url(); ?>index.php/requerimientos'>(ver todos)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <div class="col-md-12 col-lg-4 col-xl-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-tertiary">
                                <i class="fa fa-copy"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Peticiones</h4>
                                <div class="info">
                                    <strong class="amount"><?= $petReq['cantidad'] ?></strong>
                                    <span class="text-primary">(<?= $reqPeticion['cantidad'] ?> Asignadas)</span>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href='<?php echo base_url(); ?>index.php/peticiones'>(ver todos)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        
        <div class="col-md-12 col-lg-4 col-xl-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-columns"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Cambios en las actividades</h4>
                                <div class="info">
                                    <strong class="amount"><?= $totalActividades ?></strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href='<?php echo base_url(); ?>index.php/metricasGenerales'>(ver métricas generales)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Requerimientos</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none" id="requerimientos">
                            <thead>
                                <tr>
                                    <th>Id usuario</th>
                                    <th>Nombre</th>
                                    <th>Proyecto</th>
                                    <th>Tipo</th>
                                    <th>Prioridad</th>
                                    <th>Estatus</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($requerimientos)) {
                                    foreach ($requerimientos as $u):
                                        ?>
                                        <tr>
                                            <td><?= $u['idRequerimientoUsuario'] ?> </td>
                                            <td><?= $u['nombre'] ?></td>
                                            <td><?= $u['nombreProyecto'] ?></td>
                                            <td><?= $u['descTipo'] ?></td>
                                            <td><?= $u['descPrioridad'] ?></td>
                                            <td><?= $u['descEstatus'] ?></td>
                                            <td><?= $u['fecha'] ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                } else {
                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" onClick="window.location.href = '<?php echo base_url(); ?>index.php/requerimientos'">
                                Ir a Requerimientos</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Artefactos</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Artefacto</th>
                                    <th>Descripción</th>
                                    <th>Estatus</th>
                                    <th>Proyecto</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!empty($artefactos)) {
                                    foreach ($artefactos as $u):
                                        ?>
                                        <tr>
                                            <td><?= $u['idArtefacto'] ?></td>
                                            <td><?= $u['descripcion'] ?></td>
                                            <td><?= $u['descEstatus'] ?></td>
                                            <td><?= $u['nombreProyecto'] ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                } else {
                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" onClick="window.location.href = '<?php echo base_url(); ?>index.php/artefactos'">
                                Ir a Artefactos</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>

        <div class="col-md-6">
            <section class="panel panel-featured panel-featured-primary">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Peticiones</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                                <tr>
                                    <th>Petición</th>
                                    <th>Nombre</th>

                                    <th>Estatus</th>
                                    <th>Proyecto</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (!empty($peticiones)) {
                                    foreach ($peticiones as $u):
                                        ?>
                                        <tr>
                                            <td><?= $u['idPeticion'] ?></td>
                                            <td><?= $u['nombre'] ?></td>
                                            <td><?= $u['descEstatus'] ?></td>
                                            <td><?= $u['nombreProyecto'] ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                } else {
                                    ?> <tr> <td> No hay información </td>  <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" onClick="window.location.href = '<?php echo base_url(); ?>index.php/peticiones'">
                                Ir a Peticiones</button>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
    </div>

</section>


<?php $this->load->view('plantilla/vistaPie'); ?>