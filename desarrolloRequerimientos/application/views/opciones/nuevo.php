<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Opciones</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/opciones/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nueva opción</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="descripcion" class="form-control" placeholder="ej.: Usuarios" required/>
                                            </div>
                                        </div>
                                        <div  class="form-group">
                                            <label class="col-sm-3 control-label">Módulo <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                if (!empty($opcion['idModulo'])) {
                                                    llenaModulos($opcion['idModulo']);
                                                } else {
                                                    llenaModulos("");
                                                }
                                                ?>                                               
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nombre controlador <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nombreControlador" class="form-control" placeholder="ej.: usuarios" required/>
                                            </div>
                                        </div>
                                    </div>

                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/opciones'">
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