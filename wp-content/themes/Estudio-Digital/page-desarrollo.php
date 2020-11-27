<?php get_header(); $id_page= get_the_ID(); ?>
	

<section class="">
  <div class="banner banner-serv banner-dev">
    <div class="main-banner">
      <div class="main-banner__content">
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1> <?php the_field( 'desarrollo_texto_del_banner' ); ?></h1>
            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <a class="btn btn-banner btn-general" href="#" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
            </div>
            <div class="main-banner__subtitle--serv main-banner__title">
            	<p></p>

            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <video autoplay="true" src="<?php echo $desarrollo_video_del_banner = get_field( 'desarrollo_video_del_banner' ); ?>"></video>      
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
      </div>
    </div>
  </div>
</section>


<div class="section-text container">
    <div class="section-text__text section-text__text--others">
      <p><?php the_field( 'desarrollo_seccion_texto_1' ); ?></p>
    </div>
</div>



<section>
  <div class="agencia agencia-audio agencia-dev">
    <div class="main-agencia">
      <div class="main-agencia__content">
        <div class="agencia-content__video">
          <?php if ( get_field( 'desarrollo_hablemos_imagen' ) ) : ?>
            <img src="<?php the_field( 'desarrollo_hablemos_imagen' ); ?>" />
          <?php endif ?>
        </div>
      </div>
      <div class="main-agencia__content">
        <div class="agencia-content__text">
          <h3><?php the_field( 'desarrollo_hablemos_titulo' ); ?></h3>
          <p><?php the_field( 'desarrollo_hablemos_texto' ); ?></p>
          <div class="agencia-content__text--btn">
            <?php if ( wp_is_mobile() ) : ?>
              <a class="btn btn-agencia-audio"  href="<?php the_field( 'desarrollo_hablemos_boton_mobile' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php else : ?>
              <a class="btn btn-agencia-audio"  href="<?php the_field( 'desarrollo_hablemos_boton_desktop' ); ?>" > <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp  </a>
            <?php endif; ?>
              
            
          	<a href="" data-toggle="modal" data-target="#ModalContacto">Contacto</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="section-text section-text-audio">
  <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_importancia_titulo' ); ?></h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <p><?php the_field( 'desarrollo_importancia_texto' ); ?> </p>
    </div>
  <div class="tools-audio-content__text--text">
    <ul>
        <?php if (get_field( 'desarrollo_importancia_item_1' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_1' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_2' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_2' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_3' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_3' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_4' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_4' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_5' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_5' ); ?></li>
        <?php } ?>
      </ul>
      <ul>
        <?php if (get_field( 'desarrollo_importancia_item_6' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_6' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_7' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_7' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_8' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_8' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_9' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_9' ); ?></li>
        <?php } ?>
        <?php if (get_field( 'desarrollo_importancia_item_10' ) != NULL) {?>
          <li><i class="fa fa-check" aria-hidden="true"></i><?php the_field( 'desarrollo_importancia_item_10' ); ?></li>
        <?php } ?>
      </ul>
  </div>
  <div class="section-text__text section-text__text--others">
      <p class="dev-strong" >
        <strong>
        “Un eCommerce te genera ingresos incluso mientras duermes”. <br><br>
        “El mundo web está conectado, sólo hace falta que te integres”.
        </strong>
      </p>
    </div>
</div>



<section id="Portafolio">
  <div class="portafolio">
    <div class="main-portafolio padding-rl">
      <div class="subtitle-general">
        <p>Portafolio Web</p>
      </div>
      <div class="subtitle-text__clientes">
        Lorem ipsum dolor sit amet consectetur adipisicing elit.
      </div>
      <div class="main-portafolio__content d-none d-lg-flex">
        <?php $args = array( 'post_type' => 'Portafolio');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php $contador = 1; ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-portafolio__items">
          <div class="content-portafolio__items--img">
            <?php if(get_the_post_thumbnail_url()): ?>
            <a onclick="openModal();currentSlide(<?php echo $contador ?>)" class="single-slider__img"><img src="<?php echo get_the_post_thumbnail_url(); ?>"></a>
            <?php else: ?>
            <?php endif ?>
          </div>  
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio"><?php the_title(); ?></a>
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio-s">Ver más</a>
        </div>
        <?php $contador++; ?>
        <?php endwhile; ?>
        </div>
        <div class="slider-portafolio__responsive d-block d-lg-none">
        <?php $args = array( 'post_type' => 'Portafolio');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php $contador = 1; ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-portafolio__items">
          <div class="content-portafolio__items--img">
            <?php if(get_the_post_thumbnail_url()): ?>
            <a onclick="openModal();currentSlide(<?php echo $contador ?>)" class="single-slider__img"><img src="<?php echo get_the_post_thumbnail_url(); ?>"></a>
            <?php else: ?>
            <?php endif ?>
          </div>  
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio"><?php the_title(); ?></a>
          <a onclick="openModal();currentSlide(<?php echo $contador ?>)"  class="btn btn-portafolio-s">Ver más</a>
        </div>
        <?php $contador++; ?>
        <?php endwhile; ?>
        </div>
    </div>
  </div>
</section>


<div id="myModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-lg">
  <div class="modal-content "  >
    <button aria-label='Close' class='close' data-dismiss='modal' type='button' onclick="closeModal()">
      <span aria-hidden='true' class='fa fa-close'></span>
    </button>
<?php $args = array( 'post_type' => 'Portafolio');?>   
  <?php $loop = new WP_Query( $args ); ?>
  <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
      <?php if(get_the_post_thumbnail_url()): ?>
          <div class="mySlides">      
            <div class="main-details__slick--items" >
              <div class="main-details__slick--img">
                <img style="width:100%;height:100%" class="details-galeria__img" src="<?php echo get_the_post_thumbnail_url(); ?>">
              </div>
            </div>
          </div>
          <?php else: ?>

          <?php endif ?>
 <?php endwhile; ?>
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <a class="next" onclick="plusSlides(1)">&#10095;</a>
  </div>
  </div>
</div>


<section class="py-4">
  <div class="type-marketing type-audio container">
    <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_tipo_titulo' );  echo meta_value( 'desarrollo_tipo_titulo',  $id_page); ?></h2>
    </div>
    <?php the_field( 'desarrollo_tipo_texto' ); echo meta_value( 'desarrollo_tipo_texto',  $id_page); ?>
  </div>
</section>



<section class="">
  <div class="type-marketing type-audio container">
    <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_necesita_titulo' );  echo meta_value( 'desarrollo_necesita_titulo',  $id_page);?> <h2>
    </div>
    <?php the_field( 'desarrollo_necesita_texto' );  echo meta_value( 'desarrollo_necesita_texto',  $id_page);?>
    
  </div>
</section>


<section class="">
  <div class="type-marketing type-audio container" >
    <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_sitioweb_titulo' );  echo meta_value( 'desarrollo_sitioweb_titulo',  $id_page);?></h2>
    </div>
    <?php the_field( 'desarrollo_sitioweb_texto' );  echo meta_value( 'desarrollo_sitioweb_texto',  $id_page);?>
  </div>
</section>


<section class="py-4">
	<div class="audiencia-audio creacion desarrollo ">
		<div class="subtitle-general">
	    	<h2> <?php the_field( 'desarrollo_tiempo_titulo' );  echo meta_value( 'desarrollo_tiempo_titulo',  $id_page);?></h2>
	    </div>
		<div class="main-audiencia-audio main-ecommerce">
			<div class="main-audiencia-audio__content">
				<div class="audiencia-text__slider">
					<div class="audiencia-audio-content__text">
						<div class="audiencia-audio-content__text--text">
							<p>
               <?php the_field( 'desarrollo_tiempo_texto' );  echo meta_value( 'desarrollo_tiempo_texto',  $id_page);?>
              </p>
						</div>
					</div>
				</div>
			</div>
			<div class="main-audiencia-audio__content">
				<div class="audiencia-audio-content__img">
            <img src="<?php  the_field( 'desarrollo_tiempo_imagen' ); echo meta_value_img( 'desarrollo_tiempo_imagen',  $id_page); ?>" >
				</div>
			</div>
		</div>
	</div>
</section>


<div class="section-text container">
  <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_costo_titulo' ); echo meta_value( 'desarrollo_costo_titulo',  $id_page); ?><h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <?php the_field( 'desarrollo_costo_texto' ); echo meta_value( 'desarrollo_costo_texto',  $id_page); ?>
    </div>
</div>


<div class="section-text container">
  <div class="subtitle-general">
      <h2><?php the_field( 'desarrollo_apunte_final_titulo' ); echo meta_value( 'desarrollo_apunte_final_titulo',  $id_page); ?> </h2>
    </div>
    <div class="section-text__text section-text__text--others">
      <?php the_field( 'desarrollo_apunte_final_texto' ); echo meta_value( 'desarrollo_apunte_final_texto',  $id_page); ?>
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
