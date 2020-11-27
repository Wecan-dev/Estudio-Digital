
<section class="pb-5">
  <div class="banner">
    <div class="main-banner">
      <div class="main-banner__content">
        <?php $args = array( 'post_type' => 'Banner');?>   
        <?php $loop = new WP_Query( $args ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="main-banner__item">
          <div class="main-banner__text">
            <div class="main-banner__title title-general">
              <h1><?php the_title();?><?php the_content();?></h1>
            </div>
            
            <div class="boton-banner d-none d-lg-flex">
              <?php $primer_boton = get_field( 'primer_boton' ); ?>
              <?php if ( $primer_boton ) : ?>
                <a class="btn btn-banner btn-secun" href="<?php echo esc_url( $primer_boton['url'] ); ?>" target="<?php echo esc_attr( $primer_boton['target'] ); ?>"><?php echo esc_html( $primer_boton['title'] ); ?></a>
              <?php endif; ?>
              <?php $segundo_boton = get_field( 'segundo_boton' ); ?>
              <?php if ( $segundo_boton ) : ?>
                <a class="btn btn-banner btn-general"  data-toggle="modal" data-target="#ModalContacto" href="<?php echo esc_url( $segundo_boton['url'] ); ?>" target="<?php echo esc_attr( $segundo_boton['target'] ); ?>"><?php echo esc_html( $segundo_boton['title'] ); ?></a>
              <?php endif; ?>

            </div>
          </div>
          <div class="main-banner__img">
            <div class="main-banner__img--content">
              <img  src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
            </div>
          </div>
          <div class="boton-banne d-block d-lg-none">
            <a class="btn btn-banner btn-banner-respon"  href="#">Hablemos de tu proyecto <i class="fa fa-whatsapp" aria-hidden="true"></i> </a>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>
