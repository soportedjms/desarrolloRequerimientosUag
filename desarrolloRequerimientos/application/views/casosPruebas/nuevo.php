<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Casos de prueba</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/casosPruebas/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nuevo caso de prueba</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="descripcion" maxlength="100" class="form-control" placeholder="Porporcionar descripción"  required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Precondición <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="precondicion" maxlength="300" class="form-control" placeholder="Proporcione precondicion" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Poscondición <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="poscondicion" maxlength="300" class="form-control" placeholder="Proporcione poscondicion" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Responsable <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="responsable" maxlength="100" class="form-control" placeholder="Proporcione responsable" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción detallada</label>
                                            <div class="col-sm-9">
                                                <textarea name="descripcionDetallada" id="descripcionDetallada" class="form-control" 
                                                       maxlength="3000" placeholder="Proporcione descripción detallada" ></textarea>
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

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Estatus <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                llenaComboEstatus("1",'R');
                                                ?>                                               
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/casosPruebas'">
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