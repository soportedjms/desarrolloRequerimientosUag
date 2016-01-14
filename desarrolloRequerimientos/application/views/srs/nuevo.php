<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>
<script type="text/javascript">

    $(document).ready(function () {
        $('#mensaje').hide(function (event) {
            $('#mensaje').show(0).delay(2500).hide(1000);
        });
    });
</script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>SRS</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/srs/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nuevo SRS</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Proyecto <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <?php
                                                if (!empty($datos['idProyecto'])) {
                                                    llenaComboProyectos($datos['idProyecto']);
                                                } else {
                                                    llenaComboProyectos("1");
                                                }
                                                ?>                                                      
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Propósito <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea name="proposito" class="form-control" placeholder="Proporcione propósito de la SRS" 
                                                          maxlength="300" rows="3"
                                                          <?php
                                                          if (!empty($datos['proposito'])) {
                                                              if ($datos['proposito'] != "") {
                                                                  ?> value="<?= $datos['proposito'] ?>" <?php
                                                              }
                                                          }
                                                          ?> required/><?php
                                                          if (!empty($datos['proposito'])) {
                                                              if ($datos['proposito'] != "") {
                                                                  ?><?= $datos['proposito'] ?><?php
                                                              }
                                                          }
                                                          ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Alcance <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea name="alcance" class="form-control" maxlength="300" rows="3"
                                                          placeholder="Proporcione alcance de la SRS"  
                                                          <?php
                                                          if (!empty($datos['alcance'])) {
                                                              if ($datos['alcance'] != "") {
                                                                  ?> value="<?= $datos['alcance'] ?>" <?php
                                                              }
                                                          }
                                                          ?> required/><?php
                                                          if (!empty($datos['alcance'])) {
                                                              if ($datos['alcance'] != "") {
                                                                  ?><?= $datos['alcance'] ?><?php
                                                              }
                                                          }
                                                          ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Objetivo <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <textarea  name="objetivo" class="form-control" maxlength="700" rows="4"
                                                           placeholder="Proporcione objetivo de la SRS"  
                                                           <?php
                                                           if (!empty($datos['objetivo'])) {
                                                               if ($datos['objetivo'] != "") {
                                                                   ?> value="<?= $datos['objetivo'] ?>" <?php
                                                               }
                                                           }
                                                           ?> required/><?php
                                                           if (!empty($datos['objetivo'])) {
                                                               if ($datos['objetivo'] != "") {
                                                                   ?><?= $datos['objetivo'] ?><?php
                                                               }
                                                           }
                                                           ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Descripción </label>
                                            <div class="col-sm-6">
                                                <textarea name="descripcion" class="form-control" maxlength="1000" rows="5"
                                                          placeholder="Proporcione descripción de la SRS"  
                                                          <?php
                                                          if (!empty($datos['descripcion'])) {
                                                              if ($datos['descripcion'] != "") {
                                                                  ?> value="<?= $datos['descripcion'] ?>" <?php
                                                              }
                                                          }
                                                          ?>/><?php
                                                          if (!empty($datos['descripcion'])) {
                                                              if ($datos['descripcion'] != "") {
                                                                  ?><?= $datos['descripcion'] ?><?php
                                                              }
                                                          }
                                                          ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="alert alert-warning">
                                                <h4>Aviso</h4>
                                                <p>Al guardar se generará una nueva SRS para la última línea base aprobada del proyecto seleccionado, la SRS no podrá ser modificada. </p>
                                            </div>
                                            <label class="col-sm-9 control-label"></label>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/srs'">
                                                    <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
                                            </div>
                                        </div>
                                    </footer>
                                    <?php if (!empty($mensaje)) { ?>
                                        <div id="mensaje" class="alert alert-danger" role="alert"><?= $mensaje ?></div>
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