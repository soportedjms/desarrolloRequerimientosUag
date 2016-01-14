<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $("#idCasoPrueba").change(function () {
            var rol = 0;
            caso = $("#idCasoPrueba").val();
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/casoPruebaRequerimiento/traerCasoPruebaRequerimientos",
                type: "POST",
                data: {idcasoprueba: caso}
            }).done(function (data) {
                var response = $.parseJSON(data);
                var newOptions = "";
                $("#requerimientos").find('tbody').remove();
                $("#requerimientos").append('<tbody>');
                for (i = 0; i < response.length; i++)
                {
                    newOptions = '';
                    newOptions += '<tr>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].idRequerimientoUsuario + '">' + response[i].idRequerimientoUsuario + '</label>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].nombre + '">' + response[i].nombre + '</label>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].descripcionCorta + '">' + response[i].descripcionCorta + '</label>';
                    if (response[i].asignado == 0)
                    {
                        newOptions += '<td><input type="checkbox" id="idRequerimiento" name="idRequerimiento[]" value="' + response[i].idRequerimiento + '"/>Asignar';
                        newOptions += '<input type="hidden" id="idRequerimientoUsuario" name="idRequerimientoUsuario[]" value="' + response[i].idRequerimientoUsuario + '"/></td>';
                    }
                    else
                    {
                        newOptions += '<td><input type="checkbox" id="idRequerimiento" name="idRequerimiento[]" value="' + response[i].idRequerimiento + '" checked=checked/>Asignar';
                        newOptions += '<input type="hidden" id="idRequerimientoUsuario" name="idRequerimientoUsuario[]" value="' + response[i].idRequerimientoUsuario + '"/></td>';
                    }
                    newOptions += '</tr>';
                    $("#requerimientos").append(newOptions);
                }
                $("#requerimientos").append('</tbody>');
            }).fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Asignación de caso de prueba</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/casoPruebaRequerimiento/guardar" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Asignación de caso de prueba</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>
                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="guardar" value="guardar">
                                                <i class="glyphicon glyphicon-file"></i>Guardar</button>
                                        </div>
                                    </div>

                                    <div class="form-group mb-lg">
                                        <div class="clearfix">
                                            <label class="pull-left">Caso de prueba</label>
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <?php llenaComboCasoPrueba(""); ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="requerimientos" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Id usuario</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <!--Codigo de javascript-->
                                            <tbody>
                                                <?php if (!empty($casosPrueba)) {
                                                    foreach ($casosPrueba as $u):
                                                        ?>
                                                        <tr>
                                                            <td><?= $u['idRequerimientoUsuario'] ?></td>
                                                            <td><?= $u['nombre'] ?></td>
                                                            <td><?= $u['descripcionCorta'] ?></td>
        <?php if ($u['asignado'] == 0) { ?>
                                                                <td><input type="checkbox" id="idRequerimiento" name="idRequerimiento[]" value="<?= $u['idRequerimiento'] ?>"/>Asignar
                                                                    <input type="hidden" id="idRequerimientoUsuario" name="idRequerimientoUsuario[]" value="<?= $u['idRequerimientoUsuario'] ?>">
                                                                </td>
        <?php } else { ?>
                                                                <td><input type="checkbox" id="idRequerimiento" name="idRequerimiento[]" value="<?= $u['idRequerimiento'] ?>" checked=checked/>Asignar
                                                                    <input type="hidden" id="idRequerimientoUsuario" name="idRequerimientoUsuario[]" value="<?= $u['idRequerimientoUsuario'] ?>">
                                                                </td>
                                                        <?php } ?>
                                                        </tr>
    <?php endforeach;
} else { ?> <tr> <td> No hay información </td>  <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
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