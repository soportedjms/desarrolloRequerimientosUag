<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>SRS</h2>
    </header>
    <div id="mensaje" class="alert alert-danger" role="alert" hidden></div>
    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/srs/exportar">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12">
                    <section class="panel panel-transparent">
                        <header class="panel-heading">
                            <div class="panel-actions">
                                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                            </div>
                            <h2 class="panel-title">Detalle</h2>
                        </header>
                        <div class="panel-body">
                            <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/srs'">
                                <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
                            <button type="button" class="btn btn-default" 
                             onClick="window.location.href = '<?php echo base_url(); ?>index.php/srs/exportar/<?= $datos['idSRS'] ?>/<?= $datos['idProyecto'] ?>/<?= $datos['idLineaBase'] ?>'">
                                <i class="fa fa-download"></i> Exportar PDF</button>
                        </div>
                    </section>
                </div>

            </div>
            <!--<form id="form" action="http://preview.oklerthemes.com/porto-admin/1.4.1/forms-validation.html" class="form-horizontal">-->
            <div class="tabs">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#general" data-toggle="tab" class="text-center"><i class="fa fa-star"></i> General</a>
                    </li>
                    <li>
                        <a href="#glosarioYReferencias" data-toggle="tab" class="text-center">Glosario y referencias</a>
                    </li>
                    <li>
                        <a href="#detalle" data-toggle="tab" class="text-center">Requerimientos</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="general" class="tab-pane active">
                        <!--Datos generales del requerimiento--> 
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <div class="panel-actions">
                                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        </div>
                                        <h2 class="panel-title">Datos generales</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idSRS" value="<?= $datos['idSRS'] ?>" />
                                            <label class="col-sm-3 control-label">Proyecto </label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" style="color: green;font-size: 15px;font-weight: bold;"><?= $datos['nombreProyecto'] ?> </label>
                                                <input type="hidden" name="idProyecto" value="<?= $datos['idProyecto'] ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Línea base </label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label"><?= $datos['nombreLineaBase'] ?> </label>
                                                <input type="hidden" name="idLineaBase" value="<?= $datos['idLineaBase'] ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Propósito</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['proposito'] ?> </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Alcance</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['alcance'] ?> </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Objetivo</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['objetivo'] ?> </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['descripcion'] ?> </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Fecha creación</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['fechaCreacion'] ?> </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Usuario creación</label>
                                            <div class="col-sm-9">
                                                <label class="col-sm-12 control-label" ><?= $datos['nombreUsrCreacion'] ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>          
                    </div>

                    <div id="glosarioYReferencias" class="tab-pane">
                        <!--Definiciones--> 
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <div class="panel-actions">
                                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        </div>
                                        <h2 class="panel-title">Glosario y definiciones</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table mb-none" id="definiciones">
                                                <thead>
                                                    <tr>
                                                        <th>Id Glosario</th>
                                                        <th>Nombre</th>
                                                        <th>Palabra</th>
                                                        <th>Definición</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($definiciones)) {
                                                        foreach ($definiciones as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idGlosario'] ?></td>
                                                                <td><?= $u['nombreGlosario'] ?></td>
                                                                <td><?= $u['palabra'] ?></td>
                                                                <td><?= $u['definicion'] ?></td>
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

                        <!--Peticiones-->
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <div class="panel-actions">
                                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        </div>
                                        <h2 class="panel-title">Peticiones</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table mb-none" id="peticiones">
                                                <thead>
                                                    <tr>
                                                        <th>Id petición</th>
                                                        <th>Nombre</th>
                                                        <th>Descripción</th>
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
                                                                <td><?= $u['descripcion'] ?></td>                                                          
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

                        <!--Atributos-->
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <div class="panel-actions">
                                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        </div>
                                        <h2 class="panel-title">Artefactos</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table mb-none" id="artefactos">
                                                <thead>
                                                    <tr>
                                                        <th>Id artefacto</th>
                                                        <th>Descripción</th>
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
                    </div>

                    <div id="detalle" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <div class="panel-actions">
                                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
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
                                                        <th>Tipo</th>
                                                        <th>Prioridad</th>
                                                        <th>Estatus</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
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
                                                                <td><?= $u['descTipo'] ?></td>
                                                                <td><?= $u['descPrioridad'] ?></td>
                                                                <td><?= $u['descEstatus'] ?></td>
                                                                <td><?= $u['fecha'] ?></td>
                                                                <td class="actions">
                                                                    <a href="<?php echo base_url(); ?>index.php/requerimientos/editar/<?= $u['idRequerimiento'] ?>/<?= $u['idRequerimientoUsuario'] ?>/D"><i class="glyphicon glyphicon-search"></i></a>
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
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>