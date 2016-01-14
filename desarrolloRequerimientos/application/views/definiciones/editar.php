<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $('#mensaje').hide();
        $("#formInicial").submit(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/definiciones/validaGuardar",
                type: "POST",
                data: $(this).serialize()
            }).done(function (data) {

                if (data == "modal")
                {
                    $('#modal-guardar').modal('show');
                }
                else
                {
                    //si no es modal y trae mensaje entonces mostrar mensaje, si no refrescar la pagina
                    if (data != "")
                    {
                        $('#modal-guardar').modal('hide');
                        $('#mensaje').html(data);
                        $('#mensaje').show(0).delay(2500).hide(1000);
                    } else {
                        window.location.href = "<?php echo base_url(); ?>index.php/definiciones";
                    }
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });

        $("#confirm-guardar").click(function (event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/definiciones/guardarNuevo",
                type: "POST",
                data: $("#formInicial").serialize()
            }).done(function (data) {
                $('#modal-guardar').modal('hide');
                //si trae mensaje mostrarlo si no refrescar
                if (data == "")
                {
                    window.location.href = "<?php echo base_url(); ?>index.php/definiciones";
                }
                else
                {
                    $('#mensaje').html(data);
                    $('#mensaje').show(0).delay(2500).hide(1000);
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Definiciones de glosario</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/definiciones/validaGuardar" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Editar definición</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="hidden" name="idDefinicion" value="<?= $definicion['idDefinicion'] ?>" />
                                            <input type="hidden" name="idGlosario" value="<?= $definicion['idGlosario'] ?>" />
                                            <label class="col-sm-3 control-label">Glosario</label>
                                            <div class="col-sm-9" >
                                                <label class="col-sm-3 control-label"><?= $definicion['nombreGlosario'] ?></label>                              
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Palabra <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" name="palabra" class="form-control" placeholder="ej.: CMMI" 
                                                       value="<?= $definicion['palabra'] ?>" maxlength="100" required/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Definición <span class="required">*</span></label>
                                            <div class="col-sm-9">
                                                <textarea name="definicion" rows="3" maxlength="500" value="<?= $definicion['definicion'] ?>"
                                                          class="form-control" placeholder="Proporcione definición de la palabra" required><?= $definicion['definicion'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <footer class="panel-footer">
                                        <div class="row">
                                            <div class="col-sm-9 col-sm-offset-3">
                                                <button class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i>  Guardar</button>
                                                <button type="button" class="btn btn-default" onClick="window.location.href = '<?php echo base_url(); ?>index.php/definiciones'">
                                                    <i class="glyphicon glyphicon-arrow-left"></i> Atrás</button>
                                            </div>
                                        </div>
                                    </footer>
                                    <div id="mensaje" class="alert alert-danger" role="alert"></div>
                                </section>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <!--Delete -->
    <div class="modal fade" id="modal-guardar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmar guardar</h4>
                </div>
                <div class="modal-body">
                    <p>La palabra ya existe, ¿Desea reemplazarla?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button id="confirm-guardar"  type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!---->
</section>


<?php $this->load->view('plantilla/vistaPie'); ?>