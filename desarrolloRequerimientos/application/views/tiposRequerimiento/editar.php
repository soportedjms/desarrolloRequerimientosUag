<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Tipos de requerimiento</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/tiposRequerimiento/guardarEditar" >
                        <div class="row">
                            <div class="col-md-9">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar tipo</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idTipo" value="<?= $tipo['idTipo'] ?>" />
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="descripcion" class="form-control" placeholder="ej.: Usuarios" value="<?= $tipo['descripcion'] ?>" required/>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">FURPS<span class="required">*</span></label>
                                                <div class="col-sm-9">
                                                    <div class="radio-custom radio-primary">
                                                        <input id="si" name="furps" type="radio" value="1"  <?php if ($tipo['furps'] == 1) { ?> checked=checked <?php } ?> required/>
                                                        <label for="si">Si</label>
                                                    </div>
                                                    <div class="radio-custom radio-primary">
                                                        <input id="no" name="furps" type="radio" value="0" <?php if ($tipo['furps'] == 0) { ?> checked=checked <?php } ?>  />
                                                        <label for="no">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <footer class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                    <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/tiposRequerimiento'">
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