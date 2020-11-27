<section id="Aliados">
  <div class="aliados">
    <div class="main-aliados">
      <div class="subtitle-general subtitle-general-aliados ">
        <p>Nuestros aliados</p>
      </div>
      <div class="main-aliados__content">
        <?php $args = array( 'post_type' => 'Aliados');?>   
          <?php $loop = new WP_Query( $args ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
        <div class="content-aliados__items">
          <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</section>