<section>
  <div class="comentarios">
    <div class="main-comentarios" style="background-image: url('<?php echo get_template_directory_uri();?>/assets/img/Enmascarar grupo 122.png'); background-repeat: no-repeat; background-size: 50%;
    background-position-x: 10%; height: 600px; width: 100%;">
      <div class="main-comentarios__content"></div>
      <div class="main-comentarios__content container">
        <div class="subtitle-general subtitle-general-secun">
          <p>Comentarios</p>
        </div>
        <div class="comentarios-slider__content">
          <?php $args = array( 'post_type' => 'Comentarios', 'posts_per_page' => 7);?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="slider-comentario__card">
              <div class="slider-comentario__card--img">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
              </div>
              <div class="slider-comentario__card--text">
                <?php the_content(); ?>
                <div class="card-comentario__text--name">
                  <p><?php the_title(); ?></p>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</section>