<section id="Nosotros">
  <div class="agencia">
    <div class="main-agencia">
      <div class="main-agencia__content">
        <div class="agencia-content__text">
          <h3>Somos agencia</h3>
          <p>"... Para nosotros el marketing es el acertijo que resolvemos con arte, comunicación y datos"</p>
        </div>
      </div>
      <div class="main-agencia__content">
        <div class="agencia-content__video">
          <video id="videohome" src="<?php echo get_template_directory_uri();?>/assets/img/video-agencia.mp4" autoplay="true" controls="true"></video>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- <section>
  <div class="contenido">
    <div class="main-contenido">
      <div class="subtitle-general">
        <p>Creamos contenido</p>
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
