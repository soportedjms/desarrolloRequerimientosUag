<!DOCTYPE html>
<html lang="es" class="fixed">
  <head>
    <meta charset="utf-8">
    <title>UAG | Desarrollo de requerimientos</title>
                <script src="<?php echo base_url(); ?>plantilla/assets/library/jquery/jquery.js"></script>	
		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
		<!-- Vendor CSS -->
                <link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/pnotify/pnotify.custom.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/bootstrap-datepicker/css/datepicker3.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/bootstrap-multiselect/bootstrap-multiselect.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/library/morris/morris.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/select2/select2.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
                
                <!-- Specific Page Vendor CSS -->		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/select2/select2.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/dropzone/css/basic.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/dropzone/css/dropzone.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/summernote/summernote.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/summernote/summernote-bs3.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/codemirror/lib/codemirror.css" />		
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/codemirror/theme/monokai.css" />
                <link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />		
                <link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />		
              
		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/stylesheets/theme.css" />
		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>plantilla/assets/stylesheets/theme-custom.css">
		<!-- Head Libs -->
		<script src="<?php echo base_url(); ?>plantilla/assets/library/modernizr/modernizr.js"></script>
  </head>

  <body>
		<section class="body">
			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a class="logo">
						<img src="<?php echo base_url(); ?>imagenes/uag.png" height="35" alt="Porto Admin" /> 
					</a>
					
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<div class="profile-info">
								<span class="name"><?php echo sesionValor('usuarioNombre'); ?></span>
								<span class="role"><?php echo sesionValor('rolNombre'); ; ?></span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo base_url(); ?>index.php/inicial/logout"><i class="fa fa-power-off"></i> Cerrar Sesión</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end:user box -->
			</header>