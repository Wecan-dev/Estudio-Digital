<section>
  <div class="servicio">
    <div class="main-servicio padding-rl">
      <div class="subtitle-general">
        <p>Detalle de los servicios</p>
      </div>
      <div class="main-servicio__content">
      	<?php $args = array( 'post_type' => 'Servicios', 'posts_per_page' => 20);?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-servicio__items">
          <a href="#/" class="item-service">
            <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
            <div class="item-service__text">
              <p> <?php the_title(); ?></p>
            </div>
          </a>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>