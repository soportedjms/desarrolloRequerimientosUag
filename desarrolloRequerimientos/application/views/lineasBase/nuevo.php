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
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/lineasBase/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nueva línea base</h2>
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
                                            <label class="col-sm-2 control-label">Estatus </label>
                                            <label class="col-sm-2 control-label" style="color: green;font-size: 15px;font-weight: bold;">Activo </label>
                                            <input type="hidden" name="estatus"  <?php
                                            if (!empty($datos['estatus'])) {
                                                if ($datos['estatus'] != "") {
                                                    ?> value="<?= $datos['estatus'] ?>" <?php
                                                       }
                                                   } else {
                                                       ?>value="1" <?php } ?> />
                                        </div>
                                        <div class="form-group">
                                            <div class="alert alert-warning">
                                                <h4>Aviso</h4>
                                                <p>Al guardar se generará una nueva línea base para el proyecto seleccionado donde serán agregados aquellos requisitos que se encuentran marcados como activos y en estatus terminados además de las deficiones marcadas como activas del glosario perteneciente al proyecto seleccionado. </p>
                                            </div>
                                            <label class="col-sm-9 control-label"></label>
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