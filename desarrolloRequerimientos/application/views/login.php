
<!doctype html>
<html class="fixed">
    <head>

        <!-- Basic -->
        <meta charset="UTF-8">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

        <!-- Web Fonts  -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

        <!-- Library CSS -->
        <link rel="stylesheet" href="../plantilla/assets/library/bootstrap/css/bootstrap.css" />

        <link rel="stylesheet" href="../plantilla/assets/library/font-awesome/css/font-awesome.css" />
        <link rel="stylesheet" href="../plantilla/assets/library/magnific-popup/magnific-popup.css" />

        <link rel="stylesheet" href="../plantilla/assets/library/pnotify/pnotify.custom.css" />

        <!-- Theme CSS -->
        <link rel="stylesheet" href="../plantilla/assets/stylesheets/theme.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="../plantilla/assets/stylesheets/theme-custom.css">

        <!-- Head Libs -->
        <script src="../plantilla/assets/library/modernizr/modernizr.js"></script>
    </head>
    <body>
        <!-- start: page -->
        <section class="body-sign">
            <div class="center-sign">
                <a class="logo pull-left">
                    <img src="../imagenes/uag.png" height="54"/>
                </a>

                <div class="panel panel-sign">
                    <div class="panel-title-sign mt-xl text-right">
                        <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Iniciar Sesión</h2>
                    </div>
                    <div class="panel-body">
                        <form id="form_iniciar_sesion" method="post" action="<?php echo base_url(); ?>index.php/login" >
                            <div class="form-group mb-lg">
                                <label class="col-sm-3 control-label">Usuario <span class="required">*</span></label>
                                <div class="input-group input-group-icon">
                                    <input name="usuario" id= "usuario" type="text" class="form-control input-lg" placeholder="Proporcione usuario" required/>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </span>
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

                            <div class="form-group mb-lg">
                                <div class="clearfix">
                                    <label class="pull-left">Contraseña<span class="required">*</span></label>
                                </div>
                                <div class="input-group input-group-icon">
                                    <input name="password" id="password" type="password" class="form-control input-lg" placeholder="Proporcione contraseña" required/>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <?php if (!empty($mensaje)) { ?>
                                <div class="alert alert-danger" role="alert"><?= $mensaje ?></div>
                            <?php } ?>

                            <div class="row">
                                <div class="col-sm-8"></div>
                                <div class="col-sm-4 text-right">
                                    <button  class="btn btn-primary hidden-xs" type="submit" >Ingresar</button> 
                                    <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Ingresar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <p class="text-center text-muted mt-md mb-md">UAG | Desarrollo de requerimientos</p>
            </div>
        </section>
        <!-- end: page -->

        <!-- Library -->
        <script src="../plantilla/assets/library/jquery/jquery.js"></script>		
        <script src="../plantilla/assets/library/jquery-browser-mobile/jquery.browser.mobile.js"></script>		
        <script src="../plantilla/assets/library/jquery-cookie/jquery.cookie.js"></script>				
        <script src="../plantilla/assets/library/bootstrap/js/bootstrap.js"></script>		
        <script src="../plantilla/assets/library/nanoscroller/nanoscroller.js"></script>				
        <script src="../plantilla/assets/library/magnific-popup/magnific-popup.js"></script>		
        <script src="../plantilla/assets/library/jquery-placeholder/jquery.placeholder.js"></script>

        <script src="../plantilla/assets/library/pnotify/pnotify.custom.js"></script>
        <script src="../plantilla/assets/javascripts/ui-elements/examples.notifications.js"></script>

        <!-- Theme Base, Components and Settings -->
        <script src="../plantilla/assets/javascripts/theme.js"></script>

        <!-- Theme Custom -->
        <script src="../plantilla/assets/javascripts/theme.custom.js"></script>

        <!-- Theme Initialization Files -->
        <script src="../plantilla/assets/javascripts/theme.init.js"></script>
    </body>
</html>