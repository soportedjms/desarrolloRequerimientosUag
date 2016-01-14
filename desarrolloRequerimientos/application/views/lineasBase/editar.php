<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>
<script type="text/javascript">

    $(document).ready(function () {
         $('#mensaje').hide(function (event){
              $('#mensaje').show(0).delay(2500).hide(1000);
         });
    });
</script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Líneas base</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/lineasBase/guardarEditar" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar línea base</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idLineaBase" value="<?= $datos['idLineaBase'] ?>" />
                                            <label class="col-sm-2 control-label">Proyecto </label>
                                            <label class="col-sm-2 control-label" style="color: green;font-size: 15px;font-weight: bold;"><?= $datos['nombreProyecto'] ?> </label>
                                            <input type="hidden" name="idProyecto" value="<?= $datos['idProyecto'] ?>" />
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="nombre" class="form-control" placeholder="Proporcione nombre"  maxlength="50"     
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
                                            <label class="col-sm-3 control-label">Descripción <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="descripcion" class="form-control"
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
                                                    <input type="checkbox" name="estaAprobada"  id="estaAprobada" <?php if ($datos['estaAprobada'] == 1) { ?> checked=checked <?php } ?> />
                                                    Aprobada
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Estatus <span class="required">*</span></label>
                                            <div class="col-sm-6">
                                                <?php
                                                if (!empty($datos['idEstatus'])) {
                                                    llenaComboEstatus($datos['idEstatus'],'T');
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
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/lineasBase'">
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