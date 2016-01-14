<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Actividades</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/actividades/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nueva actividad</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="descripcion" class="form-control" placeholder="ej.: Desarrollo" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Seleccione</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="actividadDefault" name="actividadDefault" />
                                                    Actividad default
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Seleccione</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"  id="defaultModificacion" name="defaultModificacion" />
                                                    Default modificación
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Orden ejecución<span class="required">*</span></label>
                                            <div class="col-sm-1">
                                                <input type="text" name="ordenEjecucion" class="form-control" value="0.0" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Duración hrs. <span class="required">*</span></label>
                                            <div class="col-sm-1">
                                                <input type="text" name="duracionHrs" class="form-control" value="0.0" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Proyecto <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                llenaComboProyectos("1");
                                                ?>                                               
                                            </div>
                                        </div>

                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/actividades'">
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