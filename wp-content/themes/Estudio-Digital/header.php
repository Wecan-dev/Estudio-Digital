<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Estudio Digital</title>

  <!-- Behavioral Meta Data -->
  <meta content='width=device-width, initial-scale=1, user-scalable=no' name='viewport'>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="theme-color" content="#24272c">
  
  <!-- Google Meta Data -->
  <meta name='description', content=''>
  <meta name='keywords', content=''>
  <meta name="robots" content="index, follow">

  <!-- Blog Meta Data -->
  <meta name="dc.language" content="es">
  <meta name="dc.source" content="">
  <meta itemprop="url" content="">

  <!-- Twitter Card Meta Data -->
  <meta content='summary' name='twitter:card'>
  <meta content='Estudio Digital' name='twitter:site'>
  <meta content='Estudio Digital' name='twitter:title'>
  <meta content='Estudio Digital' name='twitter:description'>

  <!-- Open Graph Meta Data -->
  <meta content='website' property='og:type'>
  <meta content='<?php echo get_template_directory_uri();?>/assets/img/favicon-32x32.png' property='og:image'>
  <meta property="og:site_name" content="">
  <meta property="og:title" content="">
  <meta content='' property='og:description'>
  <meta property="og:type" content="">
  <meta property="og:image" content="">

  <link crossorigin="anonymous" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" rel="stylesheet">

	<link href="<?php echo get_template_directory_uri();?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/font-awesome.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/slick-theme.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/slick.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/main.css" rel="stylesheet">
  <link href="<?php echo get_template_directory_uri();?>/assets/css/responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/flaticon.css">
  <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/assets/css/animate.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" rel="stylesheet">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri();?>/assets/img/favicon-32x32.png">
  <?php wp_head(); ?>
</head>
<body>

<header id="header" class="header">
  <div class="top-nav <?php if(is_home()){echo 'top-nav-bg';} ?>">
    <div class="top-nav__content padding-rl">
      <div class="link-email">
        <a target="_blank" href="mailto:marketing@sigmasoft.co">marketing@sigmasoft.co</a>
        <?php if ( wp_is_mobile() ) : ?>
          <a  href="https://api.whatsapp.com/send?phone=573002976970">+57 300 2976970</a>
        <?php else : ?>
          <a target="_blank" href="https://web.whatsapp.com/send?phone=573002976970">+57 300 2976970</a>
        <?php endif; ?>
        
      </div>
      <div class="link-redes d-none d-lg-flex">
        <a href="https://www.facebook.com/estudiodigital.co/" target="_blank">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a href="https://www.instagram.com/estudiodigital.co/" target="_blank">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a href="" target="_blank">
          <i class="fa fa-linkedin" aria-hidden="true"></i>
        </a>
        <a href="https://www.youtube.com/channel/UCo3zvcAHbe2vQbIaws9t5AA/" target="_blank">
          <i class="fa fa-youtube-play" aria-hidden="true"></i>
        </a>
        <a href="https://twitter.com/GrupoEDigital" target="_blank">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>    
        <div class="nav-btn-acceso">
          <a href="#">Acceso a clientes</a>
        </div>
      </div>
    </div>
  </div>
    <nav class="navbar navbar-expand-lg navbar-fixed-js" id="navbar">
      <div class="main-brand">
        <a itemprop="url" class="navbar-brand" href="<?php bloginfo('url'); ?>">
			   <img id="iso" src="<?php echo get_template_directory_uri();?>/assets/img/logo-estudio-nuevo1.png" alt="" />
        </a>
        <button class="navbar-toggler  border-0 hamburger hamburger--elastic ml-autos" data-toggle="offcanvas"
          type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
        </button>
      </div>
      <div class="navbar-collapse offcanvas-collapse">
        <ul class="navbar-nav ">
			<li class="nav-item ">
				<a class="nav-link  " href="<?php bloginfo('url'); ?>">Inicio</a>
			</li>

			<li class="nav-item ">
				<a class="nav-link  " href="#Nosotros">nosotros</a>
			</li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          servicios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/desarrollo">Desarrollo Web</a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/marketing">Marketing Digital</a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/ecommerce">Comercio Electronico</a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/audio-visual">Producción Audiovisual</a>
          <a class="dropdown-item" href="<?php bloginfo('url'); ?>/creacion-de-marca">Creación de Marca</a>
        </div>
      </li>
			<li class="nav-item">
        <a class="nav-link "href="#Portafolio">portafolio</a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link "href="#">blog</a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link "href="#" data-toggle="modal" data-target="#ModalContacto">contacto</a>
      </li>
		</ul>
    <div class="link-redes  d-block d-lg-none">
        <a target="_blank" href="https://www.facebook.com/estudiodigital.co/">
          <i class="fa fa-facebook" aria-hidden="true"></i>
        </a>
        <a target="_blank" href="https://www.instagram.com/estudiodigital.co/">
          <i class="fa fa-instagram" aria-hidden="true"></i>
        </a>
        <a target="_blank" href="">
          <i class="fa fa-linkedin" aria-hidden="true"></i>
        </a>
        <a target="_blank" href="https://www.youtube.com/channel/UCo3zvcAHbe2vQbIaws9t5AA/">
          <i class="fa fa-youtube-play" aria-hidden="true"></i>
        </a>
        <a target="_blank" href="https://twitter.com/GrupoEDigital">
          <i class="fa fa-twitter" aria-hidden="true"></i>
        </a>    
        <div class="nav-btn-acceso">
          <a href="#">Acceso a clientes</a>
        </div>
      </div>
      </div>
	</nav>
</header>

<!-- Modal Contacto -->
<div class="modal fade" id="ModalContacto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="main-modal__form">
          <center class="mt-2">
            <h2>Contáctanos</h2>
          </center>
          <?php echo FrmFormsController::get_form_shortcode( array( 'id' => 2, 'title' => false, 'description' => false ) ); ?>
        </div>
      </div>
      
    </div>
  </div>
</div>