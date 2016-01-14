<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        function mensaje($msg)
        {
            $('#mensaje').html($msg);
            $('#mensaje').show(0).delay(2500).hide(1000);
        }

        $("#guardarCambio").click(function (event) {
            event.preventDefault();
            //Obtener y validar si cambio algún estatus
            seleccionados = armarJson();
            if (seleccionados == "")
            {
                mensaje("No se ha cambiado el estatus de ningún requerimiento.");
                return;
            }
            seleccionados = '{"cambiados":' + seleccionados + '}';
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/requerimientos/guardarCambioEstatus",
                type: "POST",
                data: {json: seleccionados}
            }).done(function (data) {
                if (data != "Si")
                {
                    mensaje(data);
                }
                else
                {
                    $('#mensaje2').html("Estatus cambiados con éxito.");
                    $('#mensaje2').show(0).delay(2500).hide(1000);
                    location.reload();
                }
            }).fail(function (jqXHR, textStatus) {
            });
        });

        function armarJson()
        {
            var table = document.getElementById('requerimientos');
            var inputs = table.getElementsByTagName('input');
            var combos = table.getElementsByTagName('select');
            var index = 0;
            var req = "";
            var reqUS = "";
            var cambiados = "";
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == 'hidden') {
                    if (inputs[i].name == "idReqTabla")
                    {
                        req = inputs[i].value;
                    }
                    if (inputs[i].name == "idReqUsTabla")
                    {
                        reqUs = inputs[i].value;
                    }
                    if (inputs[i].name == "idEstatus")
                    {
                        if (inputs[i].value != combos[index].value)
                        {
                            if (cambiados == '') {
                                cambiados = '{"idRequerimiento":' + req;
                                cambiados = cambiados + ',"idRequerimientoUsuario":"' + reqUs + '"';
                                cambiados = cambiados + ',"idEstatusAnterior":' + inputs[i].value;
                                cambiados = cambiados + ',"idEstatus":' + combos[index].value + "}";
                            }
                            else {
                                cambiados = cambiados + ',{"idRequerimiento":' + req;
                                cambiados = cambiados + ',"idRequerimientoUsuario":"' + reqUs + '"';
                                cambiados = cambiados + ',"idEstatusAnterior":' + inputs[i].value;
                                cambiados = cambiados + ',"idEstatus":' + combos[index].value + "}";
                            }
                        }
                        index = index + 1;
                    }
                }
            }
            if (cambiados != "")
                cambiados = "[" + cambiados + "]";
            return cambiados;
        }
    });

</script>
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Requerimientos</h2>
    </header>
    <div id="mensaje" class="alert alert-danger" role="alert" hidden></div>
    <div id="mensaje2" class="alert alert-success" role="alert" hidden></div>
    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/requerimientos/consulta" >
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        </div>
                        <h2 class="panel-title">Filtro</h2>
                    </header>
                    <div class="panel-body">
                        <label class="col-sm-2 control-label">ID requerimiento </label>
                        <div class="col-sm-2">
                            <input type="text" name="idRequerimiento" id="idRequerimiento" class="form-control"  
                            <?php
                            if (!empty($consulta['idRequerimiento'])) {
                                if ($consulta['idRequerimiento'] != "") {
                                    ?> value="<?= $consulta['idRequerimiento'] ?>" <?php
                                       }
                                   }
                                   ?>/>
                        </div>
                        <label class="col-sm-1 control-label">Nombre </label>
                        <div class="col-sm-2">
                            <input type="text" name="nombre" id="nombre" class="form-control"
                            <?php
                            if (!empty($consulta['nombre'])) {
                                if ($consulta['nombre'] != "") {
                                    ?> value="<?= $consulta['nombre'] ?>" <?php
                                       }
                                   }
                                   ?> />
                        </div>
                        <label class="col-sm-1 control-label">Proyecto </label>
                        <div class="col-sm-4">
                            <?php
                            if (!empty($consulta['idProyecto'])) {
                                llenaComboProyectos($consulta['idProyecto']);
                            } else {
                                llenaComboProyectos('');
                            }
                            ?>          
                        </div>
                    </div>
                    <div class="panel-body">
                        <label class="col-sm-1 control-label">Tipo</label>
                        <div class="col-sm-2">
                            <?php
                            if (!empty($consulta['idTipo'])) {
                                llenaComboTipoRequerimiento($consulta['idTipo'], 1);
                            } else {
                                llenaComboTipoRequerimiento('', 1);
                            }
                            ?>          
                        </div>
                        <label class="col-sm-1 control-label">Prioridad </label>
                        <div class="col-sm-2">
                            <?php
                            if (!empty($consulta['idPrioridad'])) {
                                llenaComboPrioridad($consulta['idPrioridad'], 1);
                            } else {
                                llenaComboPrioridad('', 1);
                            }
                            ?>         
                        </div>
                        <label class="col-sm-1 control-label">Estatus </label>
                        <div class="col-sm-2" >
                            <?php
                            if (!empty($consulta['idEstatus'])) {
                                llenaComboEstatusConsultaRequisitos($consulta['idEstatus'], 'R');
                            } else {
                                llenaComboEstatusConsultaRequisitos('', 'R');
                            }
                            ?>         
                        </div>
                        <div class="col-sm-2" >
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="historial"  id="historial" <?php if ($consulta['historial'] == 1) { ?> checked=checked <?php } ?> />
                                    Historial
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" >
                            <i class="glyphicon glyphicon-search"></i> Consultar</button>
                    </div>
                </section>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/requerimientos/guardarCambioEstatus" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Consulta y cambio de estatus de requerimientos</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>                                                
                                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" 
                                                    onClick="window.location.href = '<?php echo base_url(); ?>index.php/requerimientos/nuevo'">
                                                <i class="glyphicon glyphicon-file"></i> Nuevo requerimiento</button>
                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" id="guardarCambio">
                                                <i class="glyphicon glyphicon-floppy-saved"></i> Cambio de estatus</button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table mb-none" id="requerimientos">
                                                <thead>
                                                    <tr>
                                                        <th>Id usuario</th>
                                                        <th>Nombre</th>
                                                        <th>Proyecto</th>
                                                        <th>Tipo</th>
                                                        <th>Prioridad</th>
                                                        <th>Estatus</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($requerimientos)) {
                                                        foreach ($requerimientos as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idRequerimientoUsuario'] ?>
                                                                    <input type="hidden" id="idReqTabla" name="idReqTabla" value="<?= $u['idRequerimiento'] ?>">
                                                                    <input type="hidden" id="idReqUsTabla" name="idReqUsTabla" value="<?= $u['idRequerimientoUsuario'] ?>">
                                                                </td>
                                                                <td><?= $u['nombre'] ?></td>
                                                                <td><?= $u['nombreProyecto'] ?></td>
                                                                <td><?= $u['descTipo'] ?></td>
                                                                <td><?= $u['descPrioridad'] ?></td>
                                                                <td>
                                                                    <input type="hidden" id="idEstatus" name="idEstatus" value="<?= $u['idEstatus'] ?>">
                                                                    <?php
                                                                    if ($u['activo'] == 1) {
                                                                        if (!empty($u['idEstatus'])) {
                                                                            llenaComboEstatus($u['idEstatus'], 'R');
                                                                        } else {
                                                                            llenaComboEstatus("1", 'R');
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <?= $u['descEstatus'] ?>
                                                                    <?php } ?>
                                                                </td>
                                                                <td><?= $u['fecha'] ?></td>
                                                                <td class="actions">
                                                                    <?php if ($u['activo'] == 1) { ?>
                                                                        <a href="<?php echo base_url(); ?>index.php/requerimientos/editar/<?= $u['idRequerimiento'] ?>/<?= $u['idRequerimientoUsuario'] ?>/E"><i class="fa fa-pencil"></i></a>
                                                                    <?php } ?>
                                                                    <a href="<?php echo base_url(); ?>index.php/requerimientos/editar/<?= $u['idRequerimiento'] ?>/<?= $u['idRequerimientoUsuario'] ?>/D"><i class="glyphicon glyphicon-search"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        endforeach;
                                                    } else {
                                                        ?> <tr> <td> No hay información </td>  <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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