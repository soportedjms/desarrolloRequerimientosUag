<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Estatus</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/estatus/guardarEditar" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar estatus</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idEstatus" value="<?= $estatus['idEstatus'] ?>" />
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" maxlength="100" name="descripcion" class="form-control" placeholder="ej.: Activo" value="<?= $estatus['descripcion'] ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Seleccione</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="todos"  id="todos" <?php if ($estatus['todos'] == 1) { ?> checked=checked <?php } ?> />
                                                    Todos
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Seleccione</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="requisitos"  id="requisitos" <?php if ($estatus['requisitos'] == 1) { ?> checked=checked <?php } ?> />
                                                    Requerimiento
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Seleccione</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="actividades"  id="actividades" <?php if ($estatus['actividades'] == 1) { ?> checked=checked <?php } ?> />
                                                    Actividades
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/estatus'">
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
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>