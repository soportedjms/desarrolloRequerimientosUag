<div class="inner-wrapper">

    <aside id="sidebar-left" class="sidebar-left">
        <div class="sidebar-header">
            <div class="sidebar-title">Menú</div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
        </div>

        <div class="nano">
            <div class="nano-content">
                <nav id="menu" class="nav-main" role="navigation">
                    <ul class="nav nav-main">
                        <li class="nav-active">
                            <a href="<?php echo site_url('inicial') ?>">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <span>Inicio</span>
                            </a>
                        </li>
                        <?php 
                        menu();
                        ?>     
                        <!--                        <li class="nav-parent">
                                                    <a>
                                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                                        <span>Catálogos</span>
                                                    </a>
                                                    <ul class="nav nav-children">
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>index.php/usuarios">
                                                                Usuarios
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>index.php/roles">
                                                                Roles
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>index.php/modulos">
                                                                Módulos
                                                            </a>
                                                        </li>
                                                         <li>
                                                            <a href="<?php echo base_url(); ?>index.php/opciones">
                                                                Opciones
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo base_url(); ?>index.php/rolOpciones">
                                                                Rol opciones
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                        
                                                <li class="nav-parent">
                                                    <a href="solicitud_cambio.php">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                        <span>Requerimientos</span>
                                                    </a>
                                                </li>-->
                    </ul>
                </nav>
            </div>
        </div>
    </aside>