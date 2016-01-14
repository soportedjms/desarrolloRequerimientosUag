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
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/glosarios/guardarEditar" >
                        <div class="row">
                            <div class="col-md-9">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar glosario</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idGlosario" value="<?= $glosario['idGlosario'] ?>" />
                                            <label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nombre" class="form-control" maxlength="50" 
                                                       placeholder="Nombre del glosario" value="<?= $glosario['nombre'] ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea type="text" name="descripcion" data-plugin-maxlength="" maxlength="200" 
                                                          class="form-control" rows="3" id="descripcion" value="<?= $glosario['descripcion'] ?>" required><?= $glosario['descripcion'] ?></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Objetivo <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea type="text" name="objetivo" data-plugin-maxlength="" maxlength="200" 
                                                          class="form-control" rows="3" id="objetivo" value="<?= $glosario['objetivo'] ?>" required><?= $glosario['objetivo'] ?></textarea>
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Proyecto <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                if (!empty($glosario['idProyecto'])) {
                                                    llenaComboProyectos($glosario['idProyecto']);
                                                } else {
                                                    llenaComboProyectos("1");
                                                }
                                                ?>                                               
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Estatus <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                if (!empty($glosario['idEstatus'])) {
                                                    llenaComboEstatus($glosario['idEstatus'],'T');
                                                } else {
                                                    llenaComboEstatus("1","T");
                                                }
                                                ?>                                               
                                            </div>
                                        </div>
                                    </div>
                                        <footer class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                    <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/glosarios'">
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