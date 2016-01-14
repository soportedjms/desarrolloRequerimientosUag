<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Usuarios</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/usuarios/guardarNuevo" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Nuevo usuario</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Usuario <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="usuario" class="form-control" placeholder="ej.: dmontene" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Password <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="password" class="form-control" placeholder="Proporcione password" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Nombre <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="nombre" class="form-control" placeholder="Proporcione nombre del usuario" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Email <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <input type="email" name="email" class="form-control" placeholder="ej.: email@email.com" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Es administrador<span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="radio-custom radio-primary">
                                                    <input id="si" name="esAdmin" type="radio" value="1" required/>
                                                    <label for="si">Si</label>
                                                </div>
                                                <div class="radio-custom radio-primary">
                                                    <input id="no" name="esAdmin" type="radio" value="0" />
                                                    <label for="no">No</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Roles <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <?php
                                                if (!empty($roles)) {
                                                    llenaRolesEditar($roles);
                                                } else {
                                                    $roles = array("");
                                                    llenaRolesEditar($roles);
                                                }
                                                ?>                                               
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/usuarios'">
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