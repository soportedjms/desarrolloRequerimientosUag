<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Líneas base</h2>
    </header>
    <div id="mensaje" class="alert alert-danger" role="alert" hidden></div>
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
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="modificar" id="modificar"  
                                onClick="window.location.href = '<?php echo base_url(); ?>index.php/lineasBase/editar/<?= $datos['idLineaBase'] ?>/<?= $datos['idProyecto'] ?>'">
                            <i class="glyphicon glyphicon-pencil"></i> Modificar</button>
                        <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/lineasBase'">
                            <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
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
                    <a href="#captura" data-toggle="tab" class="text-center">Glosario y definiciones</a>
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
                                        <input type="hidden" name="idLineaBase" value="<?= $datos['idLineaBase'] ?>" />
                                        <label class="col-sm-3 control-label">Proyecto </label>
                                        <div class="col-sm-9">
                                            <label class="col-sm-2 control-label" style="color: green;font-size: 15px;font-weight: bold;"><?= $datos['nombreProyecto'] ?> </label>
                                            <input type="hidden" name="idProyecto" value="<?= $datos['idProyecto'] ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Nombre</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="nombre" class="form-control" placeholder="Proporcione nombre"  maxlength="50" disabled    
                                            <?php
                                            if (!empty($datos['nombre'])) {
                                                if ($datos['nombre'] != "") {
                                                    ?> value="<?= $datos['nombre'] ?>" <?php
                                                       }
                                                   }
                                                   ?> required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Descripción</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="descripcion" class="form-control" disabled
                                                   maxlength="200" placeholder="Proporcione descripción"  
                                                   <?php
                                                   if (!empty($datos['descripcion'])) {
                                                       if ($datos['descripcion'] != "") {
                                                           ?> value="<?= $datos['descripcion'] ?>" <?php
                                                       }
                                                   }
                                                   ?> required/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Aprobar línea base</label>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="estaAprobada" disabled  id="estaAprobada" <?php if ($datos['estaAprobada'] == 1) { ?> checked=checked <?php } ?> />
                                                Aprobada
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Estatus</label>
                                        <div class="col-sm-6">
                                            <label class="col-sm-2 control-label" style="color: green;font-size: 15px;font-weight: bold;"><?= $datos['descEstatus'] ?> </label>                                       
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>          
                </div>

                <div id="captura" class="tab-pane">
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
                                        <table class="table mb-none" id="requerimientos">
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
        <!--</form>-->
    </div>

</section>


<?php $this->load->view('plantilla/vistaPie'); ?>