<?php get_header(); $id_page= get_the_ID(); ?>
	

<section class="pb-5">
  <div class="banner banner-serv banner-aud">
    <div class="main-banner">
      <div class="main-banner__content">
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1><?php the_field( 'audiovisual_banner_titulo_1' ); ?></h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
            	<p>Una buena producción audiovisual es una poderosa forma de mostrar al mundo todos los productos, talentos y servicios que puedes ofrecer.</p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'audiovisual_banner_imagen_1' ); ?>" />
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
              <h1><?php the_field( 'audiovisual_banner_titulo_2' ); ?></h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
            	<p>Llega hasta tus nuevos clientes a través de internet con imágenes atractivas y videos impactantes imposibles de ignorar.</p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'audiovisual_banner_imagen_2' ); ?>" />
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <a class="btn btn-banner btn-banner-respon"  href="#">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
          </div>
        </div>
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1><?php the_field( 'audiovisual_banner_titulo_3' ); ?></h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
            	<p>Más de 1200 clientes a lo largo de nuestros 12 años de servicio corroboran el compromiso, pasión y entrega que ponemos en cada proyecto.</p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'audiovisual_banner_imagen_3' ); ?>" />
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <a class="btn btn-banner btn-banner-respon"  href="#">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
          </div>
        </div>
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1><?php the_field( 'audiovisual_banner_titulo_4' ); ?></h1>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
            	<p>Escuchamos tus necesidades, compartimos ideas y creamos el trabajo idóneo para tu negocio</p>

            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#">Contacto</a>
            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img src="<?php the_field( 'audiovisual_banner_imagen_4' ); ?>" />
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


<div class="section-text section-text-audio">
	<div class="subtitle-general">
      <h2><?php the_field( 'audiovisual_beneficios_titulo' ); ?></h2>
    </div>
    <?php the_field( 'audiovisual_beneficios_texto' ); ?>
</div>



<section>
  <div class="agencia agencia-audio">
    <div class="main-agencia">
      <div class="main-agencia__content">
        <div class="agencia-content__video">
          <img src="<?php the_field( 'audiovisual_hablemos_imagen' ); ?>" />
        </div>
      </div>
      <div class="main-agencia__content">
        <div class="agencia-content__text">
          <h3><?php the_field( 'audiovisual_hablemos_titulo' ); ?></h3>
          <p><?php the_field( 'audiovisual_hablemos_texto' ); ?></p>
          <div class="agencia-content__text--btn">
            <?php if ( wp_is_mobile() ) : ?>
              <a class="btn btn-agencia-audio"  href="<?php the_field( 'audiovisual_hablemos_boton_mobile' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php else : ?>
              <a class="btn btn-agencia-audio"  href="<?php the_field( 'audiovisual_hablemos_boton_desktop' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php endif; ?>
            
          	<a href="" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<section class="py-4">
  <div class="type-marketing type-audio container">
    <div class="subtitle-general">
      <H2><?php the_field( 'audiovisual_servicios_titulo' ); ?></H2>
    </div>
    <?php the_field( 'audiovisual_servicios_texto' ); ?>
  </div>
</section>



<!-- <section class="py-4">
  <div class="contenido">
    <div class="main-contenido">
      <div class="subtitle-general">
        <p>Nuestras creaciones audiovisuales</p>
      </div>
      <div class="main-contenido__content">
        <?php $args = array( 'post_type' => 'CreamosContenido', 'posts_per_page' => 6);?>   
        <?php $loop = new WP_Query( $args ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <div class="contenido-content__grid">
          <div class="contenido-content__gridtext">
            <p><?php the_title(); ?></p>
          </div>
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section> -->



<section class="py-4">
  <div class="marketing-steps audio-steps padding-rl">
    <div class="main-marketing-steps">
      <div class="subtitle-general">
        <h2><?php the_field( 'audiovisual_ventajas_titulo' ); echo meta_value( 'audiovisual_ventajas_titulo',  $id_page);?></h2>
      </div>
      <?php the_field( 'audiovisual_ventajas_texto' ); echo meta_value( 'audiovisual_ventajas_texto',  $id_page);?>
    </div>
  </div>
</section>





<section class="py-4">
	<div class="audiencia-audio">
		<div class="subtitle-general">
	    	<h2><?php the_field( 'audiovisual_tiempo_titulo' ); echo meta_value( 'audiovisual_tiempo_titulo',  $id_page);?></h2>
	    </div>
		<div class="main-audiencia-audio main-aliados">
			<div class="main-audiencia-audio__content">
				<div class="audiencia-audio-content__img">
					<img src="<?php the_field( 'audiovisual_tiempo_imagen' ); echo meta_value_img( 'audiovisual_tiempo_imagen',  $id_page);?>" />
				</div>
			</div>
			<div class="main-audiencia-audio__content">
				<div class="audiencia-text__slider">
					<div class="audiencia-audio-content__text">
						<div class="audiencia-audio-content__text--text">
							<?php the_field( 'audiovisual_tiempo_texto' ); echo meta_value( 'audiovisual_tiempo_texto',  $id_page);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="py-4">
  <div class="type-marketing type-audio container">
    <div class="subtitle-general">
      <h2><?php the_field( 'audiovisual_produccion_titulo' ); echo meta_value( 'audiovisual_produccion_titulo',  $id_page);?></h2>
    </div>
    <?php the_field( 'audiovisual_produccion_texto' ); echo meta_value( 'audiovisual_produccion_texto',  $id_page);?>
  </div>
</section>


<div class="section-text container">
  <div class="subtitle-general">
      <h2><?php the_field( 'audiovisual_considerar_titulo' ); echo meta_value( 'audiovisual_considerar_titulo',  $id_page);?></h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <?php the_field( 'audiovisual_considerar_texto' ); echo meta_value( 'audiovisual_considerar_texto',  $id_page);?>
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
