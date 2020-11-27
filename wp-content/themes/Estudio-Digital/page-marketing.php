<?php get_header(); $id_page= get_the_ID(); ?>
	

<section class="pb-5">
  <div class="banner banner-serv">
    <div class="main-banner">
      <div class="main-banner__content">
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1>Marketing Digital </h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
              <p><?php the_field( 'marketing_texto_banner_1' ); ?></p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'marketing_imagen_banner_1' ); ?>" />
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <?php if ( wp_is_mobile() ) : ?>
              <a class="btn btn-banner btn-banner-respon"  href="https://api.whatsapp.com/send?phone=573002976970">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
            <?php else : ?>
              <a class="btn btn-banner btn-banner-respon"  href="https://web.whatsapp.com/send?phone=573002976970">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
            <?php endif; ?>
            
          </div>
        </div>
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1>Marketing Digital </h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
              <p><?php the_field( 'marketing_texto_banner_2' ); ?></p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'marketing_imagen_banner_2' ); ?>" />
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <a class="btn btn-banner btn-banner-respon"  href="#">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
          </div>
        </div>
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1>Marketing Digital </h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
              <p><?php the_field( 'marketing_texto_banner_3' ); ?></p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'marketing_imagen_banner_3' ); ?>" />
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <a class="btn btn-banner btn-banner-respon"  href="#">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<div class="section-text container">
  <div class="subtitle-general">
      <h2><?php the_field( 'marketing_funciona_titulo' ); ?></h2>
    </div>
    <div class="section-text__text">
      <p><?php the_field( 'marketing_funciona_texto' ); ?></p>
    </div>
</div>



<section class="py-4">
  <div class="agencia agencia-audio ">
    <div class="main-agencia">
      <div class="main-agencia__content">
        <div class="agencia-content__video">
          <video src="<?php the_field( 'marketing_hablemos_video' ); ?>" autoplay="true" controls="true"></video>
        </div>
      </div>
      <div class="main-agencia__content">
        <div class="agencia-content__text">
          <h3><?php the_field( 'marketing_hablemos_titulo' ); ?></h3>
          <p><?php the_field( 'marketing_hablemos_texto' ); ?></p>
          <div class="agencia-content__text--btn">
            <?php if ( wp_is_mobile() ) : ?>
              <a target="_blank" class="btn btn-agencia-audio"  href="<?php the_field( 'marketing_hablemos_boton_desktop' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php else : ?>
              <a target="_blank" class="btn btn-agencia-audio"  href="<?php the_field( 'marketing_hablemos_boton_mobile' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php endif; ?>
          	<a href="" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="py-4 ">
  <div class="marketing-steps container">
    <div class="main-marketing-steps">
      <div class="subtitle-general">
        <h2><?php the_field( 'marketing_hacer_titulo' ); ?></h2>
      </div>
     <?php the_field( 'marketing_hacer_texto' );  ?>
    </div>
  </div>
</section>


<section class="py-4">
	<div class="audiencia-audio creacion marketing">
		<div class="subtitle-general">
	    	<h2><?php the_field( 'marketing_recursos_titulo' ); ?></h2>
	    </div>
		<div class="main-audiencia-audio main-ecommerce">
			<div class="main-audiencia-audio__content">
				<div class="audiencia-audio-content__img">
					<img src="<?php the_field( 'marketing_recursos_imagen' ); ?>" />
				</div>
			</div>
			<div class="main-audiencia-audio__content">
				<div class="audiencia-text__slider">
					<div class="audiencia-audio-content__text">
						<div class="audiencia-audio-content__text--text">
							<p><?php the_field( 'marketing_recursos_texto' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="py-4">
	<div class="tools-audio tools-creacion tools-desarrollo tools-marketing agencia-dev" >
		<div class="main-aliados main-tools-ecommerce padding-rl">
			<div class="main-tools-audio__content">
				<div class="tools-audio-content__text">
					<div class="tools-audio-content__text--text">
            <?php the_field( 'marketing_recursos_items' ); ?>
						
					</div>
				</div>
			</div>
			<div class="main-tools-audio__content">
				<div class="tools-audio-content__icons">
          <div class="tools-audio-content__icons--content">
  					<div class="tools-audio-content__icons--img">
  						<img src="<?php the_field( 'marketing_recursos_logo_1' ); ?>" />
  					</div>
          </div>
          <div class="tools-audio-content__icons--content2">
            <div class="tools-audio-content__icons--img">
              <img src="<?php the_field( 'marketing_recursos_logo_2' ); ?>" />
            </div>
            <div class="tools-audio-content__icons--img">
              <img src="<?php the_field( 'marketing_recursos_logo_3' ); ?>" />
            </div>
          </div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="py-4">
  <div class="marketing-steps container">
    <div class="main-marketing-steps">
      <div class="subtitle-general">
        <h2> <?php the_field( 'marketing_obtienes_titulo' ); ?> </h2>
      </div>
      <?php the_field( 'marketing_obtienes_texto' ); ?>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="type-marketing container">
    <div class="subtitle-general">
      <h2><?php the_field( 'marketing_tipos_titulo' ); ?></h2>
    </div>
    <?php the_field( 'marketing_tipos_texto' ); ?>
  </div>
</section>

<div class="section-text container">
  <div class="subtitle-general">
      <h2> <?php the_field( 'marketing_otros_tipos_titulo' ); ?> <h2>
    </div>
    <?php the_field( 'marketing_otros_tipos_texto' ); ?>
</div>

<div class="section-text container">
  <div class="subtitle-general">
      <h2> <?php the_field( 'marketing_favorece_titulo' ); ?> </h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <?php the_field( 'marketing_favorece_texto' ); ?>
    </div>
</div>


<div class="section-text container">
  <div class="subtitle-general">
      <h2> <?php the_field( 'marketing_tiempo_titulo' ); ?> </h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <?php the_field( 'marketing_tiempo_texto' ); ?>
    </div>
</div>




<section>
	<div class="form-audio">
		<div class="main-form-audio padding-rl">
			<div class="subtitle-general">
		    	<p>Formulario de contacto</p>
		    </div>
        <div class="main-form-audio__content">
          <?php echo FrmFormsController::get_form_shortcode( array( 'id' => 3, 'title' => false, 'description' => false ) ); ?>
		    </div>
		</div>
	</div>
</section>




<?php get_footer(); ?>
