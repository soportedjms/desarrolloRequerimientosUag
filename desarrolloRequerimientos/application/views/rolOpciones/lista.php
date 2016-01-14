<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<script type="text/javascript">

    $(document).ready(function () {

        $("#rol").change(function () {
            var rol = 0;
            rol = $("#rol").val();
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/rolOpciones/traerOpcionesRol",
                type: "POST",
                data: {idrol: rol}
            }).done(function (data) {
                var response = $.parseJSON(data);
                var newOptions = "";
                $("#opciones").find('tbody').remove();
                $("#opciones").append('<tbody>');
                for (i = 0; i < response.length; i++)
                {
                    newOptions = '';
                    newOptions += '<tr>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].idOpcion + '">' + response[i].idOpcion + '</label>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].descOpcion + '">' + response[i].descOpcion + '</label>';
                    newOptions += '<td><label class="pull-left" value="' + response[i].descModulo + '">' + response[i].descModulo + '</label>';
                    if (response[i].tienePermiso==0)
                        newOptions += '<td><input type="checkbox" id="idOpcion" name="idOpcion[]" value="' + response[i].idOpcion + '"/>Asignar</td>';
                    else
                        newOptions += '<td><input type="checkbox" id="idOpcion" name="idOpcion[]" value="' + response[i].idOpcion + '" checked=checked/>Asignar</td>';
                    newOptions += '</tr>';
                    $("#opciones").append(newOptions);
                }
                $("#opciones").append('</tbody>');
            }).fail(function (jqXHR, textStatus) {
            });
        });
    });

</script>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Rol opciones</h2>
    </header>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xl-12">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/rolOpciones/guardar" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Rol opciones</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>
                                            <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" name="guardar" value="guardar">
                                                <i class="glyphicon glyphicon-file"></i>Guardar</button>
                                        </div>
                                    </div>

                                    <div class="form-group mb-lg">
                                        <div class="clearfix">
                                            <label class="pull-left">Rol</label>
                                        </div>
                                        <div class="input-group input-group-icon">
                                            <?php llenaCombo(); ?>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="opciones" class="table mb-none">
                                            <thead>
                                                <tr>
                                                    <th>Id opción</th>
                                                    <th>Opción</th>
                                                    <th>Módulo</th>
                                                    <th>Seleccionar</th>
                                                </tr>
                                            </thead>
                                            <!--Codigo de javascript-->
                                            <tbody>
                                                <?php  if (!empty($opciones)) { 
                                                    foreach ($opciones as $u): ?>
                                                        <tr>
                                                            <td><?= $u['idOpcion'] ?></td>
                                                            <td><?= $u['descOpcion'] ?></td>
                                                            <td><?= $u['descModulo'] ?></td>
                                                            <?php if ($u['tienePermiso']==0) { ?>
                                                            <td><input type="checkbox" id="idOpcion" name="idOpcion[]" value="<?= $u['idOpcion'] ?>"/>Asignar</td>
                                                            <?php } else { ?>
                                                            <td><input type="checkbox" id="idOpcion" name="idOpcion[]" value="<?= $u['idOpcion'] ?>" checked=checked/>Asignar</td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php endforeach;  } else {  ?> <tr> <td> No hay información </td>  <?php }?>
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