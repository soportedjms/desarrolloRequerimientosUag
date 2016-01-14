<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Proyectos</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/proyectos/guardarEditar" >
                        <div class="row">
                            <div class="col-md-9">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar proyecto</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idProyecto" value="<?= $proyecto['idProyecto'] ?>" />
                                            <input type="hidden" name="usuarioCreacion" value="<?= $proyecto['usuarioCreacion'] ?>" />
                                            <label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nombre" class="form-control" placeholder="Nombre del proyecto" value="<?= $proyecto['nombre'] ?>" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea type="text" name="descripcion" data-plugin-maxlength="" maxlength="200" 
                                                          class="form-control" rows="3" id="descripcion" value="<?= $proyecto['descripcion'] ?>" required><?= $proyecto['descripcion'] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Fecha inicio y término</label>
                                            <div class="col-md-6">
                                                <div class="input-daterange input-group" data-plugin-datepicker>
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                    <input type="text" class="form-control" id="fechaInicio" name="fechaInicio" value="<?= $proyecto['fechaInicio'] ?>" required>
                                                    <span class="input-group-addon">a</span>
                                                    <input type="text" class="form-control" id="fechaTermino" name="fechaTermino" value="<?= $proyecto['fechaTermino'] ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="col-sm-3 control-label">Estatus <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                if (!empty($proyecto['idEstatus'])) {
                                                    llenaComboEstatus($proyecto['idEstatus'],'T');
                                                } else {
                                                    llenaComboEstatus("1",'T');
                                                }
                                                ?>                                               
                                            </div>
                                        </div>
                                    </div>
                                        <footer class="panel-footer">
                                            <div class="row">
                                                <div class="col-sm-9 col-sm-offset-3">
                                                    <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                    <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/proyectos'">
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