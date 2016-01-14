<?php $this->load->view('plantilla/vistaEncabezado'); ?>

<?php $this->load->view('plantilla/vistaMenu'); ?>

<section role="main" class="content-body">
    <header class="page-header">
        <h2>Definiciones de glosario</h2>
    </header>
    <div class="row">
        <div class="col-md-9 col-lg-12 col-xl-9">
            <section class="panel">
                <div class="panel-body">
                    <form id="formInicial" method="post" action="<?php echo base_url(); ?>index.php/definiciones/consulta" >
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        <h2 class="panel-title">Definiciones de glosario</h2>
                                    </header>
                                    <div class="panel-body">
                                        <div>                                                
                                            <button type="button" class="mb-xs mt-xs mr-xs btn btn-primary" 
                                                    onClick="window.location.href = '<?php echo base_url(); ?>index.php/definiciones/nuevo'">
                                                <i class="glyphicon glyphicon-file"></i> Nueva definición</button>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><h3>Filtro</h3></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-1 control-label">Palabra </label>
                                            <div class="col-sm-3">
                                                <input type="text" name="palabraFiltro" id="palabraFiltro" class="form-control" />
                                            </div>
                                            <label class="col-sm-1 control-label">Glosario </label>
                                            <div class="col-sm-4">
                                                <?php llenaComboGlosario(''); ?>
                                            </div>
                                              <button type="submit" class="mb-xs mt-xs mr-xs btn btn-primary" >
                                                <i class="glyphicon glyphicon-search"></i> Consultar</button>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table mb-none">
                                                <thead>
                                                    <tr>
                                                        <th>Id definición</th>
                                                        <th>Palabra</th>
                                                        <th>Definición</th>
                                                        <th>Activo</th>
                                                        <th>Glosario</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (!empty($definiciones)) {
                                                        foreach ($definiciones as $u):
                                                            ?>
                                                            <tr>
                                                                <td><?= $u['idDefinicion'] ?></td>
                                                                <td><?= $u['palabra'] ?></td>
                                                                <td><?= $u['definicion'] ?></td>
                                                                <td><?= $u['activo'] ?></td>
                                                                <td><?= $u['nombreGlosario'] ?></td>
                                                                <td class="actions">
                                                                    <?php if ($u['activo']==1){ ?>
                                                                    <a href="<?php echo base_url(); ?>index.php/definiciones/editar/<?= $u['idDefinicion'] ?>"><i class="fa fa-pencil"></i></a>
                                                                    <?php } ?>
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